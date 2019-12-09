<?php

class Servicos extends model
{

	public function __construct()
	{
		parent::__construct();
		$this->array = array();
		$this->retorno = array();

		$this->notificacao = new Notificacao('notificacoes');
	}

	//selecionar todos
	public function getAll($offset, $filtro, $id_company)
	{

		$where = $this->buildWhere($filtro, $id_company);

		$sql = "SELECT * FROM  
			servico sev		
		WHERE " . implode(' AND ', $where) . " LIMIT $offset, 10";

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
			'id_company=' . $id
		);


		if (!empty($filtro['razao_social'])) {

			if ($filtro['razao_social'] != '') {

				$where[] = "sev.sev_nome LIKE :razao_social";
			}
		}

		if (!empty($filtro['id'])) {

			if ($filtro['id'] != '') {

				$where[] = "sev.id = :id";
			}
		}

		return $where;
	}

	private function bindWhere($filtro, &$sql)
	{

		if (!empty($filtro['razao_social'])) {
			if ($filtro['razao_social'] != '') {
				$sql->bindValue(":razao_social", '%' . $filtro['razao_social'] . '%');
			}
		}

		if (!empty($filtro['id'])) {
			if ($filtro['id'] != '') {
				$sql->bindValue(":id", $filtro['id']);
			}
		}
	}

	//Contagem de quantos Registros
	public function getCount($id_company)
	{

		$r = 0;
		$sql = $this->db->prepare("SELECT COUNT(*) AS c FROM servico WHERE id_company = :id_company");
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

		$sql = $this->db->prepare("SELECT * FROM servico WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();


		if ($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function delete($id, $id_company)
	{

		$sql = $this->db->prepare("DELETE FROM servico WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		if ($sql->execute()) {
			controller::alert('danger', 'servico deletado com sucesso!!');
		} else {
			controller::alert('error', 'Usuario desativado com sucesso!!');
		}
	}

	public function getEtapas($id_concessionaria, $id_servico, $tipo = false)
	{

		if ($tipo == false) {
			$sql = "SELECT * FROM  
				etapas_servico_concessionaria etpsc
				INNER JOIN etapa etp ON (etpsc.id_etapa = etp.id)		
				WHERE etpsc.id_concessionaria = :id_concessionaria 
				AND etpsc.id_servico = :id_servico 
				ORDER BY etpsc.order_id ASC";

			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_concessionaria", $id_concessionaria);
			$sql->bindValue(":id_servico", $id_servico);
			$sql->execute();

			if ($sql->rowCount() > 0) {
				$this->array = $sql->fetchAll();
			}

			return $this->array;
		} else {
			$sql = "SELECT * FROM  
				etapas_servico_concessionaria etpsc
				INNER JOIN etapa etp ON (etpsc.id_etapa = etp.id)		
				WHERE etpsc.id_concessionaria = :id_concessionaria 
				AND etpsc.id_servico = :id_servico 
				AND etp.tipo = 4
				ORDER BY etpsc.order_id ASC";

			$sql = $this->db->prepare($sql);
			$sql->bindValue(":id_concessionaria", $id_concessionaria);
			$sql->bindValue(":id_servico", $id_servico);
			$sql->execute();

			if ($sql->rowCount() > 0) {
				$this->array = $sql->fetchAll();

				for ($q = 0; $q < count($this->array); $q++) {
				
					$sql = $this->db->prepare("SELECT * FROM variavel_etapa WHERE id_etapa = :id_etapa");
					$sql->bindValue(':id_etapa', $this->array[$q]['id']);
					$sql->execute();

					if ($sql->rowCount() > 0) {
						
						$arrayVariavel = $sql->fetchAll();

						$this->array[$q]['variavel'] = array();

						foreach ($arrayVariavel as $var) {
							array_push($this->array[$q]['variavel'], $var);

						}

						
					}
				}
			}	

			return $this->array;
		}
	}

	public function getServicoByConcessionaria($id_concessionaria)
	{

		$sql = "SELECT *, sev.id AS id_servico FROM concessionaria_servico consev
		INNER JOIN servico sev ON(sev.id = consev.id_servico) WHERE id_concessionaria = :id_concessionaria";

		$sql = $this->db->prepare($sql);
		$sql->bindValue(":id_concessionaria", $id_concessionaria);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	public function add($Parametros, $id_company)
	{



		try {
			$sql = $this->db->prepare("INSERT INTO servico SET 
					id_company = :id_company,
					sev_nome = :sev_nome
			");

			$sql->bindValue(":sev_nome", $Parametros['sev_nome']);
			$sql->bindValue(":id_company", $id_company);


			if ($sql->execute()) {
				controller::alert('success', 'ok');
			} else {
				controller::alert('error', 'erro');
			}
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}


		return $this->retorno;
	}

	public function updateEtapa($Parametros, $id_company, $id_user)
	{
		
		if ($Parametros['checked'] == 1) {

			$check = 1;
			$status = 6;
		} else {
			$status = 5;
			$check = 0;
		}

		$sql = $this->db->prepare("UPDATE obra_etapa obr SET

			obr.check          	= :checked, 
			obr.id_status 		= :id_status

			WHERE (id_etapa = :id) AND (id_obra = :id_obra)

		");

		$sql->bindValue(':checked',   $check);
		$sql->bindValue(':id',   $Parametros['id_etapa']);
		$sql->bindValue(':id_obra',   $Parametros['id_obra']);
		$sql->bindValue(':id_status',   $status);


		$sql->execute();

		if ($check == 1) {

			$array = array();

			$sql = $this->db->prepare("UPDATE historico_financeiro  SET

				histf_id_status 		= :id_status

			WHERE (id_etapa = :id) AND (id_obra = :id_obra)

		");

		$sql->bindValue(':id',   $Parametros['id_etapa']);
		$sql->bindValue(':id_obra',   $Parametros['id_obra']);
		$sql->bindValue(':id_status',   $status);


		$sql->execute();

			$sql = $this->db->prepare("SELECT * FROM 
				obra_etapa obrt 
				INNER JOIN etapa etp ON (etp.id = obrt.id_etapa)
				WHERE id_obra = :id_obra AND id_etapa = :id_etapa
				
			");
			$sql->bindValue(':id_obra',  $Parametros['id_obra']);
			$sql->bindValue(':id_etapa', $Parametros['id_etapa']);
			$sql->execute();


			if ($sql->rowCount() > 0) {
				$array = $sql->fetch();

				$ParametrosNotificacao = array(
					'props' => array(
						'msg' => $array['etp_nome'] . ' Foi Concluido',
						'etapa' => ADMINISTRATIVA,
						'id_obra' => $Parametros['id_obra']
					),
					'usuario' => $id_user,
					'tipo' => 'CONCLUIDO',
					'id_company' => $id_company,
					'link' => BASE_URL . 'obras/edit/' . $Parametros['id_obra']
				);

				//$this->notificacao->insert($id_company, $ParametrosNotificacao);
			}
		}
	}

	public function validacao($id_company, $nome)
	{

		$nome = controller::ReturnFormatLimpo($nome);

		$sql = $this->db->prepare("SELECT * FROM servico

			WHERE id_company = :id_company AND sev_nome = :sev_nome
		");

		$sql->bindValue(':sev_nome', $nome);
		$sql->bindValue(':id_company', $id_company);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
