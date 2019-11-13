<?php

class Concessionaria extends model
{

	public function __construct()
	{
		parent::__construct();
		$this->array = array();
		$this->retorno = array();

		$this->servicos_concessionaria = array();
		$this->documentos_concessionaria = array();
	}

	//selecionar todos
	public function getAll($filtro, $id_company)
	{

		$where = $this->buildWhere($filtro, $id_company);

		$sql = "SELECT * FROM  
			concessionaria con		
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
			'id_company=' . $id
		);


		if (!empty($filtro['razao_social'])) {

			if ($filtro['razao_social'] != '') {

				$where[] = "con.razao_social LIKE :razao_social";
			}
		}

		if (!empty($filtro['id'])) {

			if ($filtro['id'] != '') {

				$where[] = "con.id = :id";
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
		$sql = $this->db->prepare("SELECT COUNT(*) AS c FROM concessionaria WHERE id_company = :id_company");
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

		$sql = $this->db->prepare("SELECT * FROM concessionaria WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();


		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetch();

			$sql = $this->db->prepare(
				"SELECT * FROM concessionaria_servico cons
				INNER JOIN concessionaria con ON (con.id = cons.id_concessionaria)
				INNER JOIN servico ser ON (ser.id = cons.id_servico)
	
				WHERE cons.id_concessionaria = :id
			"
			);
			$sql->bindValue(':id', $this->array['id']);
			$sql->execute();

			if ($sql->rowCount() > 0) {
				$this->array['servicos_concessionaria'] = $sql->fetchALL();

				$sql = $this->db->prepare("SELECT * FROM servico WHERE id NOT IN(

						SELECT sev.id FROM servico sev
						INNER JOIN concessionaria_servico cons ON (sev.id = cons.id_servico)
						WHERE cons.id_concessionaria = :id_concessionaria
						
						
						)");
				$sql->bindValue(':id_concessionaria', $id);

				$sql->execute();

				$this->array['servico_not_concessionaria'] = $sql->fetchALL();
			}
		}

		return $this->array;
	}

	public function delete($id, $id_company)
	{

		$sql = $this->db->prepare("DELETE FROM concessionaria WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		if ($sql->execute()) {
			controller::alert('danger', 'Concessionaria deletado com sucesso!!');
		} else {
			controller::alert('error', 'Usuario desativado com sucesso!!');
		}
	}

	public function getServicoByConc($id)
	{
		$array = array();
		$array['count']['r'] = array();

		$sql = $this->db->prepare(
			"SELECT * FROM concessionaria_servico cons
			INNER JOIN concessionaria con ON (con.id = cons.id_concessionaria)
			INNER JOIN servico ser ON (ser.id = cons.id_servico)
			

			WHERE cons.id_concessionaria = :id 
		"
		);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchALL();

		}
		
		
		return $array;
	}


	public function getDocumentoByConc($id)
	{

		$sql = $this->db->prepare(
			"SELECT * FROM documentos_concessionaria docscom
			INNER JOIN concessionaria con ON (con.id = docscom.id_concessionaria)
			INNER JOIN documentos docs ON (docs.id = docscom.id_documento)

			WHERE docscom.id_concessionaria = :id
		"
		);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->documentos_concessionaria = $sql->fetchALL();
		}

		return $this->documentos_concessionaria;
	}

	public function add($id_company, $Parametros)
	{
		
		try {
			$sql = $this->db->prepare("INSERT INTO concessionaria SET 
					razao_social = :razao_social,
					id_company = :id_company
			
			");

			$sql->bindValue(":razao_social", $Parametros['razao_social']);
			$sql->bindValue(":id_company", $id_company);


			$sql->execute();

			$id = $this->db->lastInsertId();

			if (isset($Parametros['servico'])) {
				$this->setServico($Parametros, $id, $id_company);
			}

			controller::setLog($Parametros, 'concessionaria', 'add');
			
			return $id;
		
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}	

	}

	public function setServico($Parametros, $id_concessionaria, $id_company)
	{

		$sql = $this->db->prepare("
			INSERT INTO concessionaria_servico (id_concessionaria,id_servico) VALUES (:id_concessionaria, :id_servico)
		");

		$sql->bindValue(":id_servico", $Parametros['servico']);
		$sql->bindValue(":id_concessionaria", $id_concessionaria);
		$sql->execute();


	}


	public function setDocumentoAdd($Parametros, $id_concessionaria, $id_company, $arquivos)
	{
		$tmpname =  $arquivos['documento_arquivo']['name'];

		//move_uploaded_file($arquivos['documento']['tmp_name'], 'assets/documentos/nome_documento/'.$arquivos['documento']['name'] );
		for ($b = 0; $b < count($arquivos['documento_arquivo']['name']); $b++) {
			if (is_dir("assets/documentos/")) {
				$subiu = move_uploaded_file($arquivos['documento_arquivo']['tmp_name'][$b], 'assets/documentos/' . '/' . $arquivos['documento_arquivo']['name'][$b]);
			} else {
				mkdir("assets/documentos/");
				$subiu = move_uploaded_file($arquivos['documento_arquivo']['tmp_name'][$b], 'assets/documentos/' . '/' . $arquivos['documento_arquivo']['name'][$b]);
			}
		}

		try {
			if (isset($arquivos)) {
				if (count($arquivos) > 0) {
					for ($q = 0; $q < count($arquivos['documento_arquivo']['name']); $q++) {

						$sql = $this->db->prepare("INSERT INTO documentos (docs_nome,id_company)
								VALUES (:nome_documento, :id_company)
						");

						$sql->bindValue(":nome_documento", $arquivos['documento_arquivo']['name'][$q]);
						$sql->bindValue(":id_company", $id_company);
						$sql->execute();

						$id_documento = $this->db->lastInsertId();

						$sql = $this->db->prepare("INSERT INTO documentos_concessionaria (id_documento,id_concessionaria)
								VALUES (:id_documento, :id_concessionaria)
								");
						$sql->bindValue(":id_documento", $id_documento);
						$sql->bindValue(":id_concessionaria", $id_concessionaria);
						$sql->execute();
					}
				}
			} else {

				error_log(print_r('erro no documento', 1));
			}
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}
	}


	public function setDocumentoID($Parametros, $id_concessionaria, $id_company)
	{


		try {

			if (isset($Parametros)) {
				if (count($Parametros) > 0) {
					for ($q = 0; $q < count($Parametros['documento_id']); $q++) {

						$sql = $this->db->prepare("INSERT INTO documentos_concessionaria (id_concessionaria,id_documento)
								VALUES (:id_concessionaria, :id_documento)
								");
						$sql->bindValue(":id_documento", $Parametros['documento_id'][$q]);
						$sql->bindValue(":id_concessionaria", $id_concessionaria);
						$sql->execute();
					}
				}
			} else {

				error_log(print_r('erro na foto', 1));
			}
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}
	}

	public function edit($id_company, $Parametros)
	{


		$razaoSocial = $Parametros['razao_social'];
		$id = $Parametros['id'];

		try {

			$sql = $this->db->prepare("UPDATE concessionaria SET
                id_company          	= :id_company, 
				razao_social          	= :razao_social
				
				WHERE id = :id
        
            ");

			$sql->bindValue(':id_company',   $id_company);
			$sql->bindValue(':razao_social',   $razaoSocial);
			$sql->bindValue(':id',   $id);
			$sql->execute();


			if (isset($Parametros['servico'])) {
				$this->setServico($Parametros, $id, $id_company);
			}

			controller::setLog($Parametros, 'concessionaria', 'edit');

		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}

		return $this->retorno;
	}

	public function setEtapas($Parametros, $id_concessionaria, $id_company)
	{

		if (isset($Parametros)) {
			if (count($Parametros) > 0) {
				for ($q = 0; $q < count($Parametros['etapas']['nome_etapa']); $q++) {
					if ($Parametros['etapas']['nome_etapa'][$q] != '') {
						$sql = $this->db->prepare("INSERT INTO etapa (etp_nome, prazo_etapa)
							VALUES (:etapa_nome, :prazo_etapa)
							");
						$sql->bindValue(":etapa_nome", $Parametros['etapas']['nome_etapa'][$q]);
						$sql->bindValue(":prazo_etapa", $Parametros['etapas']['prazo_etapa'][$q]);

						$sql->execute();

						$id = $this->db->lastInsertId();

						$sql = $this->db->prepare("INSERT INTO etapas_servico_concessionaria (id_concessionaria, id_servico, id_etapa)
							VALUES (:id_concessionaria, :id_servico, :id_etapa)
							");
						$sql->bindValue(":id_concessionaria", $id_concessionaria);
						$sql->bindValue(":id_servico", $Parametros['servico'][0]);
						$sql->bindValue(":id_etapa", $id);

						$sql->execute();
					}
				}
			}
		} else {

			error_log(print_r('erro na foto', 1));
		}
	}

	public function getConcessionariaByService($id_concessionaria, $id_servico, $id_company)
	{

		$sql = $this->db->prepare(
			"SELECT * FROM concessionaria_servico cons
			INNER JOIN concessionaria con ON (con.id = cons.id_concessionaria)
			INNER JOIN servico ser ON (ser.id = cons.id_servico)

			WHERE cons.id_concessionaria = :id_concessionaria AND cons.id_servico = :id_servico
		"
		);
		$sql->bindValue(':id_concessionaria', $id_concessionaria);
		$sql->bindValue(':id_servico', $id_servico);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetch();
		}

		return $this->array;
	}
}
