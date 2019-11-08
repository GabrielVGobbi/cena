<?php
class Comercial extends model
{
	public function __construct($nomeTabela)
	{
		parent::__construct();
		$this->array = array();
		$this->retorno = array();
		$this->tabela = $nomeTabela;
	}
	public function getAll($offset, $filtro, $id_company)
	{
		$where = $this->buildWhere($filtro, $id_company);

		$sql = "SELECT *, obr.id as id_obra FROM  
				obra obr
			INNER JOIN cliente cli ON (cli.id = obr.id_cliente)
			INNER JOIN concessionaria con ON (con.id = obr.id_concessionaria)
			INNER JOIN servico sev ON (sev.id = obr.id_servico)
			INNER JOIN status_comercial stc ON (stc.stc_id = obr.id_status)
			INNER JOIN financeiro_obra fino ON (fino.id_obra = obr.id)

			WHERE " . implode(' AND ', $where);

		$sql = $this->db->prepare($sql);

		$this->bindWhere($filtro, $sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	private function buildWhere($filtro, $id)
	{
		$where = array(
			'obr.id_company=' . $id,
			'obr.id_comercial=1'
		);

		if (!empty($filtro['example'])) {
			if ($filtro['example'] != '') {
				$where[] = "com
			INNER JOIN cliente cli ON (cli.id_cliente = com.id_cliente).example LIKE :example";
			}
		}

		return $where;
	}

	private function bindWhere($filtro, &$sql)
	{
		if (!empty($filtro['example'])) {
			if ($filtro['example'] != '') {
				$sql->bindValue(":example", '%' . $filtro['example'] . '%');
			}
		}
	}

	public function add($id_company, $Parametros)
	{
		$tipo = "Inserido";


		$obra_nome 				= $Parametros['obra_nome'];
		$comercial_descricao 	= $Parametros['comercial_descricao'];
		$id_concessionaria 		= $Parametros['concessionaria'];
		$id_servico 			= $Parametros['servico'];
		$id_cliente 			= $Parametros['id_cliente'];

		$valor_proposta 		= controller::PriceSituation($Parametros['valor_proposta']);
		$valor_desconto 		= controller::PriceSituation($Parametros['valor_desconto']);
		$valor_negociado 		= controller::PriceSituation($Parametros['valor_negociado']);
		$valor_custo  			= controller::PriceSituation($Parametros['valor_custo']);


		$data_envio 			= $Parametros['data_envio'];


		try {

			$sql = $this->db->prepare("INSERT INTO obra SET 
        		
				obr_razao_social 			= 	:obra_nome,		
				id_concessionaria 			=	:id_concessionaria, 	
				id_servico 					=	:id_servico,		
				id_cliente 					=	:id_cliente, 	
				id_company 					=	:id_company, 	
				descricao 					=	:comercial_descricao,
				id_status 					= 	1,
				id_comercial 				= 1
        		
			");

			$sql->bindValue(":obra_nome", $obra_nome);
			$sql->bindValue(":id_concessionaria", $id_concessionaria);
			$sql->bindValue(":id_servico", $id_servico);
			$sql->bindValue(":id_cliente", $id_cliente);
			$sql->bindValue(":comercial_descricao", $comercial_descricao);
			$sql->bindValue(":id_company", $id_company);

			if ($sql->execute()) {
				controller::alert('success', 'Inserido com sucesso!!');
			} else {
				controller::alert('danger', 'Não foi possivel fazer a inserção');
			}

			$id_obra = $this->db->lastInsertId();

			$sql = $this->db->prepare("INSERT INTO financeiro_obra SET 

				id_company 			=	:id_company, 	
				valor_proposta 		=	:valor_proposta, 
				valor_desconto 		=	:valor_desconto, 
				valor_negociado 	=	:valor_negociado,
				valor_custo			= 	:valor_custo,
				data_envio 			=	:data_envio,
				id_obra 			=   :id_obra
        		
			");
			$sql->bindValue(":valor_proposta", $valor_proposta);
			$sql->bindValue(":valor_desconto", $valor_desconto);
			$sql->bindValue(":valor_negociado", $valor_negociado);
			$sql->bindValue(":valor_custo", $valor_custo);
			$sql->bindValue(":data_envio", $data_envio);
			$sql->bindValue(":id_company", $id_company);
			$sql->bindValue(":id_obra", $id_obra);


			$sql->execute();

			if (isset($Parametros['compra_quantidade'])) {
				foreach ($Parametros['compra_quantidade'] as $id_etapa => $quantidade) {

					$sql = $this->db->prepare("INSERT INTO etapa_compra_comercial SET 
						id_etapa 			=	:id_etapa,
						id_obra 			=	:id_obra,
						etcc_quantidade 	=	:quantidade
					");

					$sql->bindValue(":id_etapa", $id_etapa);
					$sql->bindValue(":id_obra", $id_obra);
					$sql->bindValue(":quantidade", $quantidade);

					$sql->execute();
				}
			}


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

			return $id_obra;


			
			
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}

		return $id_obra;
	}

	public function getEtapasComercial($id_concessionaria, $id_servico, $id_obra){
	
		$sql = $this->db->prepare("
	
		SELECT * FROM etapa etp
		INNER JOIN etapa_tipo etpt ON (etp.tipo = etpt.id_etapatipo)
		WHERE etp.id IN(
			SELECT etpsc.id_etapa FROM etapas_servico_concessionaria etpsc
			WHERE etpsc.id_concessionaria = :id_concessionaria AND etpsc.id_servico = :id_servico
		)
		AND etp.id NOT IN ( SELECT id_etapa FROM historico_financeiro WHERE id_obra = :id_obra)
		AND etpt.id_etapatipo <> 4
		
		");

		$sql->bindValue(':id_concessionaria', $id_concessionaria);
		$sql->bindValue(':id_servico', $id_servico);
		$sql->bindValue(':id_obra', $id_obra);
		

		$sql->execute();
		
		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}
		
		return $this->array;
	}

	public function getHistoricoByComercial($id_obra, $id_company){
	
		$sql = $this->db->prepare("

			SELECT * FROM historico_financeiro histf
			INNER JOIN etapa etp ON (etp.id = histf.id_etapa)
			INNER JOIN obra obr ON (obr.id = histf.id_obra)
			
			
			WHERE histf.id_obra = :id_obra 
			AND histf.id_company = :id_company

		");

		$sql->bindValue(':id_obra', $id_obra);
		$sql->bindValue(':id_company', $id_company);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}
		return $this->array;

	}

	public function addHistoricoComercial($id_company, $Parametros)
	{
        

		$metodo = $Parametros['metodo'] == 1 ? 'porcentagem' : 'valor';
		$id_etapa = $Parametros['id_etapa'];
		$id_obra = $Parametros['id_obra'];
		$metodo_valor = $Parametros['metodo_valor'];
		$valor_receber = controller::PriceSituation($Parametros['valor_receber']);

		

		try {

			$sql = $this->db->prepare("INSERT INTO historico_financeiro SET 

				id_etapa 			=	:id_etapa,
				id_obra 			=	:id_obra,
				id_company 			=	:id_company,
				metodo				= 	:metodo,
				metodo_valor		=	:metodo_valor,
				valor_receber		= 	:valor_receber
			
			");

			$sql->bindValue(":id_etapa", $id_etapa);
			$sql->bindValue(":id_obra", $id_obra);
			$sql->bindValue(":id_company", $id_company);
			$sql->bindValue(":metodo", $metodo);
			$sql->bindValue(":metodo_valor", $metodo_valor);
			$sql->bindValue(":valor_receber", ($valor_receber));

			$sql->execute();

			return $this->db->lastInsertId();

		} catch (PDOException $e) {

			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}
	}

	public function edit($Parametros)
	{
		$tipo = 'Editado';

		$nome_obra = $Parametros['nome_obra'];

		$valor_proposta 		= controller::PriceSituation($Parametros['valor_proposta']);
		$valor_desconto 		= controller::PriceSituation($Parametros['valor_desconto']);
		$valor_negociado 		= controller::PriceSituation($Parametros['valor_negociado']);

		$valor_custo  			= controller::PriceSituation($Parametros['valor_custo']);
		 

		$data_envio 			= $Parametros['data_envio'];

		if (isset($Parametros['id_obra']) && $Parametros['id_obra'] != '') {
			
			try {

				$sql = $this->db->prepare("UPDATE obra SET 
					
					nome_obra = :nome_obra,
					valor_proposta 		=	:valor_proposta, 
					valor_desconto 		=	:valor_desconto, 
					valor_negociado 	=	:valor_negociado,
					data_envio 			=	:data_envio,
					valor_custo 		= 	:valor_custo

					WHERE id = :id_obra
	        	");
				
				$sql->bindValue(":nome_obra", $nome_obra);
				$sql->bindValue(":id_obra", $Parametros['id_obra']);
				$sql->bindValue(":valor_proposta", $valor_proposta);
				$sql->bindValue(":valor_desconto", $valor_desconto);
				$sql->bindValue(":valor_negociado", $valor_negociado);
				$sql->bindValue(":data_envio", $data_envio);
				$sql->bindValue(":valor_custo", $valor_custo);


				if ($sql->execute()) {
					controller::alert('success', 'Editado com sucesso!!');
				} else {
					controller::alert('danger', 'Erro ao fazer a edição!!');
				}

			} catch (PDOExecption $e) {
				$sql->rollback();
				error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
			}

		} else {
			controller::alert('danger', 'Não foi selecionado nenhum arquivo!!');
		}
	}

	public function updateStatusComercial($Parametros, $id_company)
	{
		$tipo = 'Editado';
		$id_status = $Parametros['tipo'];

		if (isset($Parametros['id'])  && $Parametros['id'] != '') {
			try {

				$sql = $this->db->prepare("UPDATE obra SET 
					
					id_status = :id_status

					WHERE id = :id
				
				");

				$sql->bindValue(":id_status", $id_status);
				$sql->bindValue(":id", $Parametros['id']);

					error_log(print_r($id_status,1));

				if ($sql->execute()) {

					if($id_status == APROVADA){
						$this->updateEtapaCompraObra($Parametros['id']);
					}

					return $Parametros['id'];
				} else {
					controller::alert('danger', 'Erro ao fazer a edição!!');
				}

				

			} catch (PDOExecption $e) {
				$sql->rollback();
				error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
			}
		} else {
			controller::alert('danger', 'Não foi selecionado nenhum registro!!');
		}
	}

	public function updateEtapaCompraObra($id_obra) 
	{
		
		$sql = $this->db->prepare("SELECT * FROM etapa_compra_comercial WHERE id_obra = :id_obra");
		$sql->bindValue(":id_obra", $id_obra);
		$sql->execute();

		
		if ($sql->rowCount() > 0) {
			
			$array = $sql->fetchAll();

			foreach ($array as $etpC) {

				$sql = $this->db->prepare("UPDATE obra_etapa SET 
					quantidade = :quantidade
				
					WHERE id_etapa = :id_etapa AND id_obra = :id_obra
        		");

				$sql->bindValue(":quantidade", $etpC['etcc_quantidade']);
				$sql->bindValue(":id_etapa",   $etpC['id_etapa']);
				$sql->bindValue(":id_obra",    $id_obra);

				$sql->execute();

			}

		} else { 
			return false;
		}



	}

	public function getcomercialById($id_obra, $id_company){
		
		if($id_obra != ''){
			$sql = $this->db->prepare("SELECT *, obr.id as id_obra FROM obra obr
				INNER JOIN concessionaria con ON (con.id = obr.id_concessionaria)
				INNER JOIN servico sev ON (sev.id = obr.id_servico)
				INNER JOIN cliente cli ON (cli.id = obr.id_cliente)
				INNER JOIN financeiro_obra fino ON (fino.id_obra = obr.id)

				WHERE obr.id_company = :id_company 
				AND obr.id = :id_obra
			");
			$sql->bindValue(':id_obra', $id_obra);
			$sql->bindValue(':id_company', $id_company);

			$sql->execute();
			
			if ($sql->rowCount() == 1) {
				$this->array = $sql->fetch();
			}
			
			return $this->array;

		} else {

			controller::alert('danger', 'selecione um registro valido!!');

		}
	}

	public function deleteHistorico($id_obra, $id_historico, $id_company)
	{
		$tipo = 'Deletado';
		
		if (isset($id_obra) && $id_obra != '') {

			$sql = $this->db->prepare("DELETE FROM historico_financeiro WHERE histf_id = :id_historico AND id_obra = :id_obra AND id_company = :id_company");
			
			$sql->bindValue(":id_historico", $id_historico);
			$sql->bindValue(":id_obra", $id_obra);
			$sql->bindValue(":id_company", $id_company);
			
			if ($sql->execute()) {
				controller::alert('success', 'Deletado com sucesso!!');
			} else {
				controller::alert('danger', 'Erro ao deletar!!');
			}

		} else {
			controller::alert('danger', 'Não foi selecionado nenhum arquivo!!');
		}
	}

	public function getCount(){
		
	}

}
