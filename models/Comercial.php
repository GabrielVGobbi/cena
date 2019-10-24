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

		$sql = "SELECT * FROM  
				$this->tabela com
			INNER JOIN cliente cli ON (cli.id = com.id_cliente)
			INNER JOIN concessionaria con ON (con.id = com.id_concessionaria)
			INNER JOIN servico sev ON (sev.id = com.id_servico)
			INNER JOIN status_comercial stc ON (stc.stc_id = com.id_status)

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
			'com.id_company=' . $id
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

			$sql = $this->db->prepare("INSERT INTO $this->tabela SET 
        		
				nome_obra 			= 	:obra_nome,		
				id_concessionaria 	=	:id_concessionaria, 	
				id_servico 			=	:id_servico,		
				id_cliente 			=	:id_cliente, 	
				id_company 			=	:id_company, 	

				descricao 			=	:comercial_descricao,

				valor_proposta 		=	:valor_proposta, 
				valor_desconto 		=	:valor_desconto, 
				valor_negociado 	=	:valor_negociado,
				valor_custo			= 	:valor_custo,
				data_envio 			=	:data_envio,
				id_status 			= 	1
        		
			");

			$sql->bindValue(":obra_nome", $obra_nome);
			$sql->bindValue(":id_concessionaria", $id_concessionaria);
			$sql->bindValue(":id_servico", $id_servico);
			$sql->bindValue(":id_cliente", $id_cliente);
			$sql->bindValue(":comercial_descricao", $comercial_descricao);
			$sql->bindValue(":valor_proposta", $valor_proposta);
			$sql->bindValue(":valor_desconto", $valor_desconto);
			$sql->bindValue(":valor_negociado", $valor_negociado);
			$sql->bindValue(":valor_custo", $valor_custo);
			$sql->bindValue(":data_envio", $data_envio);
			$sql->bindValue(":id_company", $id_company);

			if ($sql->execute()) {
				controller::alert('success', 'Inserido com sucesso!!');
			} else {
				controller::alert('danger', 'Não foi possivel fazer a inserção');
			}

			$id_comercial = $this->db->lastInsertId();

			if (isset($Parametros['compra_quantidade'])) {
				foreach ($Parametros['compra_quantidade'] as $id_etapa => $quantidade) {

					$sql = $this->db->prepare("INSERT INTO etapa_compra_comercial SET 
						id_etapa 			=	:id_etapa,
						id_comercial 			=	:id_comercial,
						etcc_quantidade 			=	:quantidade
					");

					$sql->bindValue(":id_etapa", $id_etapa);
					$sql->bindValue(":id_comercial", $id_comercial);
					$sql->bindValue(":quantidade", $quantidade);

					$sql->execute();
				}
			}
			
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}

		return $id_comercial;
	}

	public function getEtapasComercial($id_concessionaria, $id_servico){
	
		$sql = $this->db->prepare("
	
		SELECT * FROM etapa etp
		INNER JOIN etapa_tipo etpt ON (etp.tipo = etpt.id_etapatipo)
		WHERE etp.id IN(
			SELECT etpsc.id_etapa FROM etapas_servico_concessionaria etpsc
			WHERE etpsc.id_concessionaria = :id_concessionaria AND etpsc.id_servico = :id_servico
		)
		AND etp.id NOT IN ( SELECT id_etapa FROM historico_financeiro WHERE id_comercial = :id_comercial)
		AND etpt.id_etapatipo <> 4
		
		");

		$sql->bindValue(':id_concessionaria', $id_concessionaria);
		$sql->bindValue(':id_servico', $id_servico);
		$sql->bindValue(':id_comercial', '16');
		

		$sql->execute();
		
		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}
		
		return $this->array;
	}

	public function getHistoricoByComercial($id_comercial, $id_company){
	
		$sql = $this->db->prepare("

			SELECT * FROM historico_financeiro histf
			INNER JOIN etapa etp ON (etp.id = histf.id_etapa)
			INNER JOIN comercial com ON (com.id_comercial = histf.id_comercial)
			
			
			WHERE histf.id_comercial = :id_comercial 
			AND histf.id_company = :id_company

		");

		$sql->bindValue(':id_comercial', $id_comercial);
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
		$id_comercial = $Parametros['id_comercial'];
		$metodo_valor = $Parametros['metodo_valor'];
		$valor_receber = controller::PriceSituation($Parametros['valor_receber']);

		

		try {

			$sql = $this->db->prepare("INSERT INTO historico_financeiro SET 

				id_etapa 			=	:id_etapa,
				id_comercial 		=	:id_comercial,
				id_company 			=	:id_company,
				metodo				= 	:metodo,
				metodo_valor		=	:metodo_valor,
				valor_receber		= 	:valor_receber
			
			");

			$sql->bindValue(":id_etapa", $id_etapa);
			$sql->bindValue(":id_comercial", $id_comercial);
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

		if (isset($Parametros['id_' . $this->tabela]) && $Parametros['id_' . $this->tabela] != '') {
			
			try {

				$sql = $this->db->prepare("UPDATE $this->tabela SET 
					
					nome_obra = :nome_obra,
					valor_proposta 		=	:valor_proposta, 
					valor_desconto 		=	:valor_desconto, 
					valor_negociado 	=	:valor_negociado,
					data_envio 			=	:data_envio,
					valor_custo 		= 	:valor_custo

					WHERE id_comercial = :id_comercial
	        	");
				
				$sql->bindValue(":nome_obra", $nome_obra);
				$sql->bindValue(":id_comercial", $Parametros['id_' . $this->tabela]);
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

		if (isset($Parametros['id_' . $this->tabela]) && $Parametros['id_' . $this->tabela] != '') {
			try {

				$sql = $this->db->prepare("UPDATE $this->tabela SET 
					
					id_status = :id_status

					WHERE id_$this->tabela = :id
				
				");

				$sql->bindValue(":id_status", $id_status);
				$sql->bindValue(":id", $Parametros['id_' . $this->tabela]);

				if ($sql->execute()) {

					return $Parametros['id_comercial'];
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

	public function getcomercialById($id_comercial, $id_company){
		
		if($id_comercial != ''){
			$sql = $this->db->prepare("SELECT * FROM $this->tabela com
				INNER JOIN concessionaria con ON (con.id = com.id_concessionaria)
				INNER JOIN servico sev ON (sev.id = com.id_servico)
				INNER JOIN cliente cli ON (cli.id = com.id_cliente)

				WHERE com.id_company = :id_company 
				AND id_comercial = :id_comercial
			");
			$sql->bindValue(':id_comercial', $id_comercial);
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

	public function delete($id, $id_company)
	{
		$tipo = 'Deletado';
		if (isset($Parametros['id' . $this->tabela]) && $Parametros['id' . $this->tabela] != '') {
			$sql = $this->db->prepare("DELETE FROM $this->tabela WHERE id_$this->tabela = :id AND id_company = :id_company");
			$sql->bindValue(":id", $id);
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

	public function deleteHistorico($id_comercial, $id_historico, $id_company)
	{
		$tipo = 'Deletado';
		
		if (isset($id_comercial) && $id_comercial != '') {

			$sql = $this->db->prepare("DELETE FROM historico_financeiro WHERE histf_id = :id_historico AND id_comercial = :id_comercial AND id_company = :id_company");
			
			$sql->bindValue(":id_historico", $id_historico);
			$sql->bindValue(":id_comercial", $id_comercial);
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

	public function getCount($id_company)
	{
		$r = 0;
		$sql = $this->db->prepare("SELECT COUNT(*) AS count FROM $this->tabela WHERE id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();
		$row = $sql->fetch();
		$r = $row['count'];
		return $r;
	}

	public function searchByName($var, $id_company)
	{
		$sql = $this->db->prepare("SELECT * FROM $this->tabela
			WHERE id_company = :id_company AND example like :example
		");
		$sql->bindValue(':example', '%' . $var . '%');
		$sql->bindValue(':id_company', $id_company);

		$sql->execute();
		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}
		return $this->array;
	}
}
