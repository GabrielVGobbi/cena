<?php

class Obras extends model
{

	var $table = 'obra'; //nome da tabela
	var $column = array(0 => '', 1 => 'obr_razao_social', 2 => 'cliente_nome', 3 => 'sev_nome', 4 => 'razao_social'); //ordem das colunas
	var $column_search = array('cli_nome', 'cli_sorenome', 'cli_email'); //colunas para pesquisas
	var $order = array('id' => 'desc'); // order padrão

	public function __construct()
	{
		parent::__construct();
		$this->array = array();
		$this->retorno = array();

		$this->documento = new Documentos();
	}

	public function getAll($filtro, $id_company, $id_user)
	{

		$order = [];

		if (isset($_COOKIE['minha_lista']) && $_COOKIE['minha_lista'] == 'checked') {
			#$order[] = 'obr.id ASC,obr_razao_social';
		}

		$length = isset($filtro['length']) ? $filtro['length'] : '10';

		$start = isset($filtro['start']) ? $filtro['start'] : '0';

		$where = $this->buildWhere($filtro, $id_company);

		if (isset($_COOKIE['minha_lista']) && $_COOKIE['minha_lista'] == 'checked') {
			$sql = ("SELECT * FROM obra_usuario_lista obr_us_li 
						INNER JOIN obra obr ON (obr_us_li.id_obra = obr.id)");
			$where[] = 'obr_us_li.id_usuario = ' . $id_user;
			$where[] = 'obr_us_li.atv = 1';


			if (isset($_COOKIE['urgencia_lista']) && $_COOKIE['urgencia_lista'] == 'checked') {
				$order[] = 'obr_us_li.urgencia DESC';
			}
		} else {
			$sql = ("SELECT 
				obr.obr_razao_social, cle.cliente_nome, cle.cliente_apelido,
				sev.sev_nome,con.razao_social, obr.atv, obr.obra_nota_numero, obr.id as id_obra FROM 
				obra obr
			");
		}

		$order[] =  !empty($this->column[$filtro['order'][0]['column']]) ? " " . $this->column[$filtro['order'][0]['column']] . " " . $filtro['order'][0]['dir'] : ' obr.obr_razao_social';

		$order = ' ORDER BY ' . implode(' , ', $order);

		$sql .= (" 
				INNER JOIN servico sev ON(obr.id_servico = sev.id)
				INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
				INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
				LEFT JOIN obra_endereco obre ON (obre.id_obra_endereco = obr.id_endereco_obra)
				WHERE " . implode(' AND ', $where) . '  GROUP BY obr.id ' . $order . " LIMIT " . $start . " ," . $length);

		$sql = $this->db->prepare($sql);
		$this->bindWhere($filtro, $sql);

		$sql->execute();


		$this->retorno = ($sql->rowCount() > 0) ? $sql->fetchAll() : '';

		return $this->retorno;
		exit();
	}

	//selecionar todos
	public function getLista($filtro, $id_company)
	{
		$where = $this->buildWhere($filtro, $id_company);
		$sql = "
		SELECT * FROM  
			obra obr
			INNER JOIN servico sev ON(obr.id_servico = sev.id)
			INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
			INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
		WHERE " . implode(' AND ', $where) . "  GROUP BY obr.id ORDER BY obr.obr_razao_social";

		$sql = $this->db->prepare($sql);

		$this->bindWhere($filtro, $sql);

		$sql->execute();
		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	public function getObraCliente($id_cliente, $filtro, $id_company)
	{

		$where = $this->buildWhere($filtro, $id_company, $id_cliente);

		$sql = "
		SELECT *, obr.id as id_obra FROM  
			obra obr
			INNER JOIN servico sev ON(obr.id_servico = sev.id)
			INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
			INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
		WHERE " . implode(' AND ', $where) . " GROUP BY obr.id";
		$sql = $this->db->prepare($sql);



		$this->bindWhere($filtro, $sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	private function buildWhere($filtro, $id, $id_cliente = 0)
	{
		$where = array(
			'obr.id_company=' . $id,
			'obr.id_status=3',
			'obr.atv<>2'
		);


		if (!isset($filtro['filtro']['filtros']['situacao'])) {
			$where[] = 'obr.atv=1';
		}

		if ($id_cliente != 0) {
			$where[] = 'obr.id_cliente=' . $id_cliente;
		}

		if (!empty($filtro['filtro']['filtros']['nome_obra'])) {
			if ($filtro['filtro']['filtros']['nome_obra'] != '') {
				$where[] = "obr.obr_razao_social LIKE :nome_obra";
			}
		}
		if (!empty($filtro['filtro']['filtros']['cliente_nome'])) {
			if ($filtro['filtro']['filtros']['cliente_nome'] != '') {
				$where[] = "cle.cliente_nome LIKE :cliente_nome";
			}
		}
		if (!empty($filtro['filtro']['filtros']['id'])) {
			if ($filtro['filtro']['filtros']['id'] != '') {
				$where[] = "obr.id = :id";
			}
		}
		if (!empty($filtro['filtro']['filtros']['situacao'])) {
			if ($filtro['filtro']['filtros']['situacao'] != '') {
				$where[] = "obr.atv = :situacao";
			}
		}

		if (!empty($filtro['filtro']['filtros']['obra_nota_numero'])) {
			if ($filtro['filtro']['filtros']['obra_nota_numero'] != '') {
				$where[] = "obr.obra_nota_numero LIKE :obra_nota_numero";
			}
		}


		if (!empty($filtro['search']['value'])) {
			if ($filtro['search']['value'] != '') {
				$where[] = "(cle.cliente_nome LIKE :value OR obr.obr_razao_social LIKE :value OR cle.cliente_apelido LIKE :value)";
			}
		}

		return $where;
	}

	private function bindWhere($filtro, &$sql)
	{

		if (!empty($filtro['filtro']['filtros']['nome_obra'])) {
			if ($filtro['filtro']['filtros']['nome_obra'] != '') {
				$sql->bindValue(":nome_obra", '%' . $filtro['filtro']['filtros']['nome_obra'] . '%');
			}
		}
		if (!empty($filtro['filtro']['filtros']['cliente_nome'])) {
			if ($filtro['filtro']['filtros']['cliente_nome'] != '') {
				$sql->bindValue(":cliente_nome", '%' . $filtro['filtro']['filtros']['cliente_nome'] . '%');
			}
		}
		if (!empty($filtro['filtro']['filtros']['id'])) {
			if ($filtro['filtro']['filtros']['id'] != '') {
				$sql->bindValue(":id", $filtro['filtro']['filtros']['id']);
			}
		}
		if (!empty($filtro['filtro']['filtros']['obra_nota_numero'])) {
			if ($filtro['filtro']['filtros']['obra_nota_numero'] != '') {
				$sql->bindValue(":obra_nota_numero", '%' . $filtro['filtro']['filtros']['obra_nota_numero'] . '%');
			}
		}
		if (!empty($filtro['filtro']['filtros']['situacao'])) {
			if ($filtro['filtro']['filtros']['situacao'] != '') {
				if ($filtro['filtro']['filtros']['situacao'] == 3) {
					$filtro['filtro']['filtros']['situacao'] = '0';
				}

				$sql->bindValue(":situacao", $filtro['filtro']['filtros']['situacao']);
			}
		}


		if (!empty($filtro['search']['value'])) {
			if ($filtro['search']['value'] != '') {
				$sql->bindValue(":value", '%' . $filtro['search']['value'] . '%');
			}
		}
	}

	//Contagem de quantos Registros
	public function getCount($id_company, $filtro)
	{

		$r = 0;
		$where = $this->buildWhere($filtro, $id_company);

		$sql = (" SELECT COUNT(obr.id) as c FROM 
				
				obra obr 
				INNER JOIN servico sev ON(obr.id_servico = sev.id)
				INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
				INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria) WHERE " . implode(' AND ', $where));

		$sql = $this->db->prepare($sql);

		$this->bindWhere($filtro, $sql);

		$sql->execute();
		if ($sql->rowCount() > 0) {
			$row = $sql->fetch();
		}

		$r = $row['c'];

		return $r;
	}

	public function getCountTotalObras($id_company)
	{

		$r = 0;

		$sql = ("SELECT COUNT(*) as c FROM obra obr WHERE id_status <> 4");
		$sql = $this->db->prepare($sql);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$row = $sql->fetch();
		}

		$r = $row['c'];

		return $r;
	}

	public function getCountAtivas($id_company)
	{

		$r = 0;
		$sql = $this->db->prepare("SELECT COUNT(*) as c FROM obra obr WHERE (obr.atv <> 0 AND obr.atv <> 2) AND id_status = 3 AND id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$row = $sql->fetch();
		}

		$r = $row['c'];

		return $r;
	}



	//Selecionar por ID
	public function getInfo($id, $id_company, $id_user = 0)
	{
		$array = array();


		if (isset($_COOKIE['minha_lista']) && $_COOKIE['minha_lista'] == 'checked') {
			$sql = ("SELECT * FROM obra_usuario_lista obr_us_li 
						INNER JOIN obra obr ON (obr_us_li.id_obra = obr.id)");
			$where[] = 'obr_us_li.id_usuario = ' . $id_user;
			$where[] = 'obr_us_li.atv = 1';


			if (isset($_COOKIE['urgencia_lista']) && $_COOKIE['urgencia_lista'] == 'checked') {
				$order[] = 'obr_us_li.urgencia DESC';
			}
		} else {
			$sql = ("SELECT * FROM 
				obra obr
			");
		}

		$sql .= ("
			INNER JOIN servico sev ON(obr.id_servico = sev.id)
			INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
			INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
			LEFT JOIN obra_endereco obre ON (obre.id_obra_endereco = obr.id_endereco_obra)
			LEFT JOIN obra_etapa obtp ON (obr.id = obtp.id_obra)	
			
			WHERE obr.id = :id AND obr.id_company = :id_company");
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);

		$sql->execute();


		if ($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function getInfoObraCliente($id, $id_company, $id_cliente)
	{

		$array = array();

		$sql = $this->db->prepare("
		
		SELECT *, obr.id as id_obra  FROM  
			obra obr
			INNER JOIN servico sev ON(obr.id_servico = sev.id)
			INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
			INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
			
			WHERE obr.id = :id AND obr.id_company = :id_company AND obr.id_cliente = :id_cliente");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id_cliente', $id_cliente);

		$sql->execute();


		if ($sql->rowCount() > 0) {
			$array = $sql->fetch();
		} else {
			return false;
		}

		return $array;
	}

	public function delete($id, $id_company)
	{
		$Parametros = [
			'id_obra' => $id
		];
		$sql = $this->db->prepare("UPDATE obra SET atv = 2 WHERE id = :id_obra AND id_company = :id_company");

		$sql->bindValue(":id_obra", $id);
		$sql->bindValue(":id_company", $id_company);

		if ($sql->execute()) {
			controller::alert('danger', 'obra deletado com sucesso!!');
			controller::setLog($Parametros, 'obra', 'delete');


			//$this->deleteEtapasObras($id);

		} else {
			controller::alert('error', 'não foi possivel deletar a obra');
		}
	}

	public function deleteEtapasObras($id)
	{

		$sql = $this->db->prepare("DELETE FROM obra_etapa WHERE id_obra = :id");

		$sql->bindValue(":id", $id);

		if ($sql->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function add($Parametros, $id_company)
	{


		$date = strftime('%d-%m-%Y', strtotime('today'));
		$data = ucwords($date);

		$descricao =  isset($Parametros['descricao']) ?  $Parametros['descricao'] : '';

		try {
			$sql = $this->db->prepare("INSERT INTO obra SET 
					id_company = :id_company,
					id_servico = :id_servico,
					id_cliente = :id_cliente,
					id_concessionaria = :id_concessionaria,
					obr_razao_social = :razao_social,
					data_obra 		= :data_obra,
					descricao = :descricao,
					id_status =	3

			");

			$sql->bindValue(":razao_social", $Parametros['obra_nome']);
			$sql->bindValue(":id_servico", $Parametros['servico']);
			$sql->bindValue(":id_cliente", $Parametros['id_cliente']);
			$sql->bindValue(":data_obra", $data);
			$sql->bindValue(":id_concessionaria", $Parametros['concessionaria']);
			$sql->bindValue(":descricao",$descricao);




			$sql->bindValue(":id_company", $id_company);


			if ($sql->execute()) {
				controller::alert('success', 'Obra criado com sucesso!!');
				controller::setLog($Parametros, 'obra', 'add');
			} else {
				controller::alert('error', 'Não foi possivel fazer o cadastro da obra, Contate o administrador do sistema!!');
			}

			$id_obra = $this->db->lastInsertId();

			$sql->bindValue(":razao_social", $Parametros['obra_nome']);

			$this->servico = new Servicos();

			$etapas = $this->servico->getEtapas($Parametros['concessionaria'], $Parametros['servico']);

			if (isset($etapas)) {
				if (count($etapas) > 0) {
					for ($q = 0; $q < count($etapas); $q++) {

						$sql = $this->db->prepare("INSERT INTO obra_etapa (id_obra, id_etapa, etp_nome_etapa_obra, ordem, preco, tipo_compra)
							VALUES (:id_obra, :id_etapa, :etp_nome_etapa_obra, :ordem, :preco, :tipo_compra)
						");

						$sql->bindValue(":id_etapa", $etapas[$q]['id_etapa']);
						$sql->bindValue(":id_obra", $id_obra);
						$sql->bindValue(":etp_nome_etapa_obra", $etapas[$q]['etp_nome']);
						$sql->bindValue(":ordem", $etapas[$q]['order_id']);
						$sql->bindValue(":preco", $etapas[$q]['preco']);
						$sql->bindValue(":tipo_compra", $etapas[$q]['tipo_compra']);


						$sql->execute();
					}
				}
			} else {
			}

			//if($Parametros['id_comercial']){
			//	$this->addFinanceiroObra($Parametros['id_comercial'], $id_obra, $id_company);

			//}

		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}


		return $id_obra;
	}

	public function addFinanceiroObra($id_comercial, $id_obra, $id_company)
	{

		$sql = $this->db->prepare("SELECT * FROM comercial WHERE id_comercial = :id_comercial");
		$sql->bindValue(":id_comercial", $id_comercial);
		$sql->execute();

		if ($sql->rowCount() == 1) {

			$array = $sql->fetch();

			$sql = $this->db->prepare("INSERT INTO financeiro_obra SET 
					id_company = :id_company,
					id_obra = :id_obra,
					valor_proposta = :valor_proposta,
					valor_negociado = :valor_negociado,
					valor_desconto = :valor_desconto, 
					valor_custo = :valor_custo

			");

			$sql->bindValue(":id_obra", $id_obra);
			$sql->bindValue(":valor_proposta", $array['valor_proposta']);
			$sql->bindValue(":valor_negociado", $array['valor_negociado']);
			$sql->bindValue(":valor_desconto", $array['valor_desconto']);
			$sql->bindValue(":valor_custo", $array['valor_custo']);
			$sql->bindValue(":id_company", $id_company);
			$sql->execute();

			$id_financeiro_obra = $this->db->lastInsertId();

			$sql = $this->db->prepare("SELECT * FROM historico_financeiro WHERE id_comercial = :id_comercial");
			$sql->bindValue(":id_comercial", $id_comercial);
			$sql->execute();

			if ($sql->rowCount() > 1) {

				$arrayHistoricoFinanceiro = $sql->fetchALL();

				for ($q = 0; $q < count($arrayHistoricoFinanceiro); $q++) {

					$sql = $this->db->prepare("INSERT INTO historico_financeiro_obra (id_company, id_financeiro_obra, id_etapa, metodo, metodo_valor, valor_receber)
						VALUES (:id_company, :id_financeiro_obra, :id_etapa, :metodo, :metodo_valor, :valor_receber)
					");

					$sql->bindValue(":id_company", $id_company);
					$sql->bindValue(":id_financeiro_obra", $id_financeiro_obra);
					$sql->bindValue(":id_etapa", $arrayHistoricoFinanceiro[$q]['id_etapa']);
					$sql->bindValue(":metodo", $arrayHistoricoFinanceiro[$q]['metodo']);
					$sql->bindValue(":metodo_valor", $arrayHistoricoFinanceiro[$q]['metodo_valor']);
					$sql->bindValue(":valor_receber", $arrayHistoricoFinanceiro[$q]['valor_receber']);

					$sql->execute();
				}
			}
		} else {
			return false;
		}
	}



	public function getEtapas($id_obra, $tipo)
	{



		if ($tipo == '' || $tipo == '0') {
			$tipo = '1,2,3,4';
		}

		$sql = "SELECT *, obrt.quantidade AS quantidade_obra, obrt.preco AS preco_obra, obrt.tipo_compra AS tipo_compra FROM  
			obra_etapa obrt
			INNER JOIN etapa etp ON (obrt.id_etapa = etp.id)
		WHERE  obrt.id_obra = :id_obra AND tipo IN ($tipo) ORDER BY tipo not in ('2'),ordem ASC, id_etapa_obra ASC,  tipo ASC, `check` not in('1') ASC";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_obra", $id_obra);



		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	public function getEtapasByTipoId($id_obra, $tipo)
	{


		if ($tipo == '' || $tipo == '0') {
			$tipo = '1,2,3,4';
		}

		$sql = "SELECT *, obrt.quantidade AS quantidade_obra, obrt.preco AS preco_obra, obrt.tipo_compra AS tipo_compra FROM  
			obra_etapa obrt
			INNER JOIN etapa etp ON (obrt.id_etapa = etp.id)
		WHERE  obrt.id_obra = :id_obra AND tipo IN ($tipo) ORDER BY tipo not in ('2'),ordem ASC, id_etapa_obra ASC,  tipo ASC, `check` not in('1') ASC";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_obra", $id_obra);



		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();

			for ($q = 0; $q < count($this->array); $q++) {
				$doc = new Documentos();
				$arrayDoc = array();
				$arrayDoc = $doc->getDocumentoEtapa($this->array[$q]['id_etapa_obra']);

				$this->array[$q]['documento'] = array();

				if (!empty($arrayDoc)) {
					$docNome = $arrayDoc['docs_nome'];

					$this->array[$q]['documento'] = ($docNome);
				}
			}
		}

		return $this->array;
	}

	public function getEtapasConcluidas($id_obra)
	{

		$r = 0;
		$sql = $this->db->prepare("SELECT COUNT(*) AS c FROM obra_etapa obrt WHERE (id_obra = :id_obra) AND (obrt.check = '1')");
		$sql->bindValue(':id_obra', $id_obra);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$row = $sql->fetch();
		}

		$r = $row['c'];

		return $r;
	}

	public function edit($Parametros, $id_company, $arquivos)
	{

		$data_obra = controller::returnDate($Parametros['data_obra']);

		if (isset($Parametros['id']) && $Parametros['id'] != '') {


			$razao_social = isset($Parametros['razao_social_obra_cliente']) ? $Parametros['razao_social_obra_cliente'] : '';

			$id_departamento = isset($Parametros['cliente_departamento']) ? $Parametros['cliente_departamento'] : '';

			$obr_informacoes = isset($Parametros['obra_infor']) ? $Parametros['obra_infor'] : '';

			$descricao =  isset($Parametros['descricao']) ?  $Parametros['descricao'] : '';

			$id_endereco = isset($Parametros['id_endereco'])
				? $this->setEnderecoObra($Parametros, $id_company, $Parametros['id_endereco'])
				: $this->setEnderecoObra($Parametros, $id_company);

			$sql = $this->db->prepare("UPDATE obra SET 
				obr_razao_social = :obra_nome,
				data_obra = :data_obra, 
				id_endereco_obra = :id_endereco_obra,
				cnpj_obra = :obra_cnpj,
				razao_social_obra_cliente = :razao_social_obra_cliente,
				id_departamento = :id_departamento,
				obr_informacoes = :obr_informacoes,
				descricao = :descricao

				
				
				WHERE id = :id_obra
        	");

			$sql->bindValue(":obra_nome", $Parametros['obra_nome']);
			$sql->bindValue(":id_obra", $Parametros['id']);
			$sql->bindValue(":data_obra", $data_obra);
			$sql->bindValue(":id_endereco_obra", $id_endereco);
			$sql->bindValue(":obra_cnpj", $Parametros['obra_cnpj']);
			$sql->bindValue(":razao_social_obra_cliente", $razao_social);
			$sql->bindValue(":id_departamento", $id_departamento);
			$sql->bindValue(":obr_informacoes", $obr_informacoes);
			$sql->bindValue(":descricao", $descricao);
			

			$sql->execute();

			controller::setLog($Parametros, 'obra', 'edit');

			if (isset($Parametros['check'])) {
				if (count($Parametros['check']) > 0) {
					for ($q = 0; $q < count($Parametros['check']); $q++) {

						$sql = $this->db->prepare("UPDATE obra_etapa obr SET
							obr.check = '1' 
				
							WHERE id_obra = :id_obra AND id_etapa = :id_etapa
						");
						$sql->bindValue(":id_etapa", $Parametros['check'][$q]);
						$sql->bindValue(":id_obra", $Parametros['id_obra']);

						$sql->execute();

						controller::setLog($Parametros, 'obra', 'concluir_obra');
					}
				}
			} else {
			}



			if (isset($Parametros['documento_nome']) && isset($arquivos)) {

				$this->documento->add($arquivos, $id_company, $Parametros['id'], $Parametros['documento_nome']);
			}
		}
	}

	public function setEnderecoObra($Parametros, $id_company, $id_endereco = false)
	{

		if ($id_endereco == false && !empty($Parametros['cep'])) {

			$sql = $this->db->prepare("INSERT INTO obra_endereco SET 
				rua = :rua, 
				numero = :numero,
				cidade = :cidade,
				bairro = :bairro,
				estado = :estado,
				complemento = :complemento,
				inscEstado = :inscEstado,
				cep = :cep
			");

			$sql->bindValue(":rua", $Parametros['rua']);
			$sql->bindValue(":numero", $Parametros['numero']);
			$sql->bindValue(":cidade", $Parametros['cidade']);
			$sql->bindValue(":bairro", $Parametros['bairro']);
			$sql->bindValue(":inscEstado", $Parametros['inscEstado']);
			$sql->bindValue(":complemento", $Parametros['complemento']);
			$sql->bindValue(":estado", $Parametros['estado']);

			$sql->bindValue(":cep", $Parametros['cep']);

			$sql->execute();

			$id_endereco = $this->db->lastInsertId();
		} else {

			$sql = $this->db->prepare("UPDATE `obra_endereco` SET  
				rua = :rua, 
				numero = :numero,
				cidade = :cidade,
				bairro = :bairro,
				estado = :estado,
				complemento = :complemento,
				inscEstado = :inscEstado,
				cep = :cep

				WHERE id_obra_endereco = :id_endereco
			");

			$sql->bindValue(":rua", $Parametros['rua']);
			$sql->bindValue(":numero", $Parametros['numero']);
			$sql->bindValue(":cidade", $Parametros['cidade']);
			$sql->bindValue(":bairro", $Parametros['bairro']);
			$sql->bindValue(":inscEstado", $Parametros['inscEstado']);
			$sql->bindValue(":complemento", $Parametros['complemento']);
			$sql->bindValue(":estado", $Parametros['estado']);
			$sql->bindValue(":id_endereco", $id_endereco);

			$sql->bindValue(":cep", $Parametros['cep']);


			$sql->execute()
				? controller::alert('success', 'Editado com sucesso')
				: controller::alert('error', 'Ops!! deu algum erro');
		}

		return $id_endereco;
	}

	public function concluir($id, $id_company)
	{
		$Parametros = [
			'id' => $id
		];

		if (isset($id) && $id != '') {

			$sql = $this->db->prepare("UPDATE obra SET 
				atv = 0
				
				WHERE id = :id_obra AND id_company = :id_company
        	");

			$sql->bindValue(":id_obra", $id);
			$sql->bindValue(":id_company", $id_company);


			if ($sql->execute()) {
				controller::alert('success', 'Obra concluida com sucesso!');
				controller::setLog($Parametros, 'obra', 'concluir_obra');
			} else {
				controller::alert('error', 'não foi possivel concluir a obra');
			}
		}
	}

	public function desconcluir($id, $id_company)
	{
		$Parametros = [
			'id' => $id
		];

		if (isset($id) && $id != '') {

			$sql = $this->db->prepare("UPDATE obra SET 
				atv = 1
				
				WHERE id = :id_obra AND id_company = :id_company
        	");

			$sql->bindValue(":id_obra", $id);
			$sql->bindValue(":id_company", $id_company);


			if ($sql->execute()) {
				controller::alert('success', 'Obra desconcluida com sucesso!');
				controller::setLog($Parametros, 'obra', 'desconcluir_obra');
			} else {
				controller::alert('error', 'não foi possivel concluir a obra');
			}
		}
	}

	public function parcialCheck($Parametros)
	{

		$id_obra = $Parametros['id_obra'];
		$id_etapa_obra = $Parametros['id_etapa'];

		$sql = $this->db->prepare("UPDATE obra_etapa SET 
				parcial_check = 1
				
				WHERE id_obra = :id_obra AND id_etapa_obra = :id_etapa_obra
        	");

		$sql->bindValue(":id_obra", $id_obra);
		$sql->bindValue(":id_etapa_obra", $id_etapa_obra);


		if ($sql->execute()) {
			controller::alert('success', 'Concluido');
		} else {
			controller::alert('error', 'Não foi possivel');
		}
	}

	public function validacao($id_company, $nome)
	{

		$nome = controller::ReturnValor($nome);

		$sql = $this->db->prepare("SELECT * FROM obra

			WHERE id_company = :id_company AND obr_razao_social = :obra_nome
		");

		$sql->bindValue(':obra_nome', $nome);
		$sql->bindValue(':id_company', $id_company);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getAllByClear($id_company)
	{

		$sql = "SELECT * FROM obra obr		
			WHERE obr.id <> '' AND obr.id NOT IN (SELECT fino.id_obra FROM financeiro_obra fino) AND
			
			(obr.atv <> 0 AND obr.atv <> 2) AND obr.id_status = 3 AND id_company = :id_company
		";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_company', $id_company);


		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	public function checkUrgenceObra($checked, $id, $id_company, $id_user)
	{
		$Parametros = [
			'id' => $id
		];

		if ($this->getListObra($id, $id_user)) {
			$sql = $this->db->prepare("UPDATE obra_usuario_lista SET 
				urgencia = :checked
				
				WHERE id_obra = :id_obra AND id_usuario = :id_usuario
        	");

			$sql->bindValue(":id_obra", $id);
			$sql->bindValue(":id_usuario", $id_user);
			$sql->bindValue(":checked", $checked);
			if ($sql->execute())
				controller::setLog($Parametros, 'obra_urgence', 'obra_urgencia');
			return $id;
		} else {
		}
	}

	public function checkMyListObra($checked, $id, $id_company, $id_user)
	{
		$Parametros = [
			'id' => $id,
			'id_user' => $id_user
		];

		$sql = $this->db->prepare("SELECT * FROM obra_usuario_lista  
				WHERE id_obra = :id_obra AND id_usuario = :id_user LIMIT 1
        ");

		$sql->bindValue(":id_obra", $id);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		if($sql->rowCount() == 1){

			$sql = $this->db->prepare("UPDATE obra_usuario_lista SET 
				atv = :checked
				
				WHERE id_obra = :id_obra AND id_usuario = :id_usuario
        	");

			$sql->bindValue(":id_obra", $id);
			$sql->bindValue(":id_usuario", $id_user);
			$sql->bindValue(":checked", $checked);
			if ($sql->execute())
				controller::setLog($Parametros, 'obra_lista_insert', 'obra_lista');
			return $id;
		} else {

			$sql = $this->db->prepare("INSERT INTO obra_usuario_lista SET 
				id_usuario = :id_usuario,
				id_obra = :id_obra
			");

			$sql->bindValue(":id_obra", $id);
			$sql->bindValue(":id_usuario", $id_user);
			if ($sql->execute())
				controller::setLog($Parametros, 'obra', 'obra_lista');

			return $id;
		}
	}

	public function getListObra($id_obra, $id_user)
	{

		$array = [];

		$sql = $this->db->prepare("SELECT * FROM obra_usuario_lista  
				WHERE id_obra = :id_obra AND id_usuario = :id_user AND atv = 1 LIMIT 1
        ");

		$sql->bindValue(":id_obra", $id_obra);
		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return $sql->rowCount() == 1 ? $sql->fetch() : false;
	}

	public function observacoesByObra($id_obra, $id_etapa){


		$sql = ('SELECT * FROM observacao_usuario obsus
			INNER JOIN observacao obs ON (obs.id_observacao = obsus.id_observacao)
			INNER JOIN users user ON (user.id = obsus.id_user)
			WHERE id_obra = :id_obra AND id_etapa = :id_etapa ORDER BY obsus.id_obs_user DESC
		');

		$sql = $this->db->prepare($sql);
		$sql->bindValue("id_obra", $id_obra);
		$sql->bindValue("id_etapa", $id_etapa);

		$sql->execute();

		return $sql->rowCount() > 0 ? $sql->fetchALL() : '';

	}


}
