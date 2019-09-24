<?php

class Obras extends model
{

	public function __construct()
	{
		parent::__construct();
		$this->array = array();
		$this->retorno = array();

		$this->documento = new Documentos();
	}

	//selecionar todos
	public function getAll($filtro, $id_company)
	{


		$where = $this->buildWhere($filtro, $id_company);

		$sql = "
		SELECT * FROM  
			obra obr
			INNER JOIN servico sev ON(obr.id_servico = sev.id)
			INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
			INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
			LEFT JOIN obra_etapa obtp ON (obr.id = obtp.id_obra)		
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

		$where = $this->buildWhere( $filtro, $id_company, $id_cliente);

		$sql = "
		SELECT * FROM  
			obra obr
			INNER JOIN servico sev ON(obr.id_servico = sev.id)
			INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
			INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
			LEFT JOIN obra_etapa obtp ON (obr.id = obtp.id_obra)		
		WHERE " . implode(' AND ', $where) . " GROUP BY obr.id";

		$sql = $this->db->prepare($sql);

		$this->bindWhere($filtro, $sql);



		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	private function buildWhere($filtro, $id,$id_cliente = 0)
	{
		$where = array(
			'obr.id_company=' . $id
		);

		if(!isset($filtro['situacao'])){

			$where[] = 'obr.atv=1';
		}

		if($id_cliente != 0){
			$where[] = 'obr.id_cliente='. $id_cliente;
		}
		if (!empty($filtro['nome_obra'])) {

			if ($filtro['nome_obra'] != '') {

				$where[] = "obr.obr_razao_social LIKE :nome_obra";
			}
		}

		if (!empty($filtro['cliente_nome'])) {

			if ($filtro['cliente_nome'] != '') {

				$where[] = "cle.cliente_nome LIKE :cliente_nome";
			}
		}


		if (!empty($filtro['id'])) {

			if ($filtro['id'] != '') {

				$where[] = "obr.id = :id";
			}
		}

		if (!empty($filtro['situacao'])) {

			if ($filtro['situacao'] != '') {

				$where[] = "obr.atv = :situacao";
			}
		}
		
		if (!empty($filtro['obra_nota_numero'])) {

			if ($filtro['obra_nota_numero'] != '') {

				$where[] = "obr.obra_nota_numero LIKE :obra_nota_numero";
			}
		}

		return $where;
	}

	private function bindWhere($filtro, &$sql)
	{

		if (!empty($filtro['nome_obra'])) {
			if ($filtro['nome_obra'] != '') {
				$sql->bindValue(":nome_obra", '%' . $filtro['nome_obra'] . '%');
			}
		}

		if (!empty($filtro['cliente_nome'])) {
			if ($filtro['cliente_nome'] != '') {
				$sql->bindValue(":cliente_nome", '%' . $filtro['cliente_nome'] . '%');
			}
		}

		if (!empty($filtro['id'])) {
			if ($filtro['id'] != '') {
				$sql->bindValue(":id", $filtro['id']);
			}
		}
		if (!empty($filtro['obra_nota_numero'])) {
			if ($filtro['obra_nota_numero'] != '') {
				$sql->bindValue(":obra_nota_numero", '%' . $filtro['obra_nota_numero'] . '%');
			}
		}

		if (!empty($filtro['situacao'])) {
			if ($filtro['situacao'] != '') {
				if($filtro['situacao'] == 3){
					$filtro['situacao'] = '0';
				}
				
				$sql->bindValue(":situacao", $filtro['situacao']);
			}
		}
		
	}

	//Contagem de quantos Registros
	public function getCount($id_company)
	{

		$r = 0;
		$sql = $this->db->prepare("SELECT COUNT(*) AS c FROM obra WHERE id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$row = $sql->fetch();
		}

		$r = $row['c'];

		return $r;
	}

	//Selecionar por ID
	public function getInfo($id, $id_company)
	{

		$array = array();

		$sql = $this->db->prepare("
		
		SELECT * FROM  
			obra obr
			INNER JOIN servico sev ON(obr.id_servico = sev.id)
			INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
			INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
			LEFT JOIN obra_etapa obtp ON (obr.id = obtp.id_obra)	
			
			WHERE obr.id = :id AND obr.id_company = :id_company");
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
		
		SELECT * FROM  
			obra obr
			INNER JOIN servico sev ON(obr.id_servico = sev.id)
			INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
			INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
			LEFT JOIN obra_etapa obtp ON (obr.id = obtp.id_obra)	
			
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

		$sql = $this->db->prepare("DELETE FROM obra WHERE id = :id AND id_company = :id_company");
		
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		
		if ($sql->execute()) {
			controller::alert('danger', 'obra deletado com sucesso!!');

			$this->deleteEtapasObras($id);

		} else {
			controller::alert('error', 'não foi possivel deletar a obra');
		}
	}

	public function deleteEtapasObras($id){

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
		try {
			$sql = $this->db->prepare("INSERT INTO obra SET 
					id_company = :id_company,
					id_servico = :id_servico,
					id_cliente = :id_cliente,
					id_concessionaria = :id_concessionaria,
					obr_razao_social = :razao_social,
					data_obra 		= :data_obra

			
			");

			$sql->bindValue(":razao_social", $Parametros['obra_nome']);
			$sql->bindValue(":id_servico", $Parametros['servico']);
			$sql->bindValue(":id_cliente", $Parametros['id_cliente']);
			$sql->bindValue(":data_obra", $data);
			$sql->bindValue(":id_concessionaria", $Parametros['concessionaria']);

			$sql->bindValue(":id_company", $id_company);


			if ($sql->execute()) {
				controller::alert('success', 'Obra criado com sucesso!!');
			} else {
				controller::alert('error', 'Não foi possivel fazer o cadastro da obra, Contate o administrador do sistema!!');
			}

			$id_obra = $this->db->lastInsertId();

			$this->servico = new Servicos();
			$etapas = $this->servico->getEtapas($Parametros['concessionaria'], $Parametros['servico']);

			if (isset($etapas)) {
				if (count($etapas) > 0) {
					for ($q = 0; $q < count($etapas); $q++) {

						$sql = $this->db->prepare("INSERT INTO obra_etapa (id_obra, id_etapa, etp_nome_etapa_obra)
							VALUES (:id_obra, :id_etapa, :etp_nome_etapa_obra)
							");
						$sql->bindValue(":id_etapa", $etapas[$q]['id_etapa']);
						$sql->bindValue(":id_obra", $id_obra);
						$sql->bindValue(":etp_nome_etapa_obra", $etapas[$q]['etp_nome']);


						$sql->execute();
					}
				}
			} else {

				error_log(print_r('erro', 1));
			}
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}


		return $this->retorno;
	}

	public function getEtapas($id_obra, $tipo)
	{

		if($tipo == '' || $tipo == '0'){
			$tipo = '1,2,3';
		}	
		
		$sql = "SELECT * FROM  
			obra_etapa obrt
			INNER JOIN etapa etp ON (obrt.id_etapa = etp.id)
		WHERE id_obra = :id_obra AND tipo IN ($tipo) ORDER BY  tipo not in ('2'),ordem DESC, id_etapa_obra ASC,  tipo ASC, `check` not in('1') ASC" ;

		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_obra", $id_obra);


		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
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

			$sql = $this->db->prepare("UPDATE obra SET 
				obr_razao_social = :obra_nome,
				data_obra = :data_obra
				
				WHERE id = :id_obra
        	");

			$sql->bindValue(":obra_nome", $Parametros['obra_nome']);
			$sql->bindValue(":id_obra", $Parametros['id']);
			$sql->bindValue(":data_obra", $data_obra);

			$sql->execute();

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
					}
				}
				
			} else {

			}

			if(isset($Parametros['documento_nome']) && isset($arquivos)){

				$this->documento->add($arquivos, $id_company, $Parametros['id'], $Parametros['documento_nome']);
			}

		}
	}

	public function concluir($id, $id_company)
	{

		if (isset($id) && $id != '') {

			$sql = $this->db->prepare("UPDATE obra SET 
				atv = 0
				
				WHERE id = :id_obra AND id_company = :id_company
        	");

			$sql->bindValue(":id_obra", $id);
			$sql->bindValue(":id_company", $id_company);


			if($sql->execute()){
				controller::alert('success', 'Obra concluida com sucesso!');

			}else {
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


			if($sql->execute()){
				controller::alert('success', 'Concluido');

			}else {
				controller::alert('error', 'Não foi possivel');

			}

		
	}
	
}
