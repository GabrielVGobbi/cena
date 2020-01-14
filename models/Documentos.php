<?php

class Documentos extends model
{

	public function __construct()
	{
		parent::__construct();
		$this->array = array();
		$this->retorno = array();
	}

	//selecionar todos
	public function getAll($filtro, $id_company)
	{

		$where = $this->buildWhere($filtro, $id_company);

		$sql = "SELECT * FROM  
			documentos docs		
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

				$where[] = "docs.docs_nome LIKE :razao_social";
			}
		}

		if (!empty($filtro['id'])) {

			if ($filtro['id'] != '') {

				$where[] = "docs.id = :id";
			}
		}

		if (!empty($filtro['id'])) {

			if ($filtro['id'] != '') {

				$where[] = "docs.id = :id";
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
		$sql = $this->db->prepare("SELECT COUNT(*) AS c FROM documentos WHERE id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$row = $sql->fetch();
		}

		$r = $row['c'];

		return $r;
	}

	public function add($arquivos, $id_company, $id_obra = 0, $nome_documento = '', $type = '.pdf')
	{

		$nome_documento = strtolower($nome_documento);

		$type = '.'.str_replace('application/','',$arquivos['documento_arquivo']['type']);
		
		if (is_dir("assets/documentos/")) {
			$subiu = move_uploaded_file($arquivos['documento_arquivo']['tmp_name'], 'assets/documentos/' . '/' . $nome_documento . $type);
		} else {
			mkdir("assets/documentos/");
			$subiu = move_uploaded_file($arquivos['documento_arquivo']['tmp_name'], 'assets/documentos/' . '/' . $nome_documento . $type);
		}


		try {


			$sql = $this->db->prepare("INSERT INTO documentos (docs_nome,id_company)
								VALUES (:nome_documento, :id_company)
						");

			$sql->bindValue(":nome_documento", strtolower($nome_documento . $type));
			$sql->bindValue(":id_company", $id_company);
			if ($sql->execute()) {
				controller::alert('success', 'documento adicionado com sucesso!!');

				$id = $this->db->lastInsertId();
	
				if((isset($id_obra) && $id_obra != '')){
					$this->addDocumentoObra($id_obra, $id);
				}

			} else {
				controller::alert('error', 'Contate o administrador do sistema!!');
			}
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}

		return $id;
	}

	public function addByDropeZone($arquivos, $id_company, $id_obra = 0, $nome_documento = '', $type = '.pdf')
	{

		$nome_documento = strtolower($nome_documento);

		
		if (is_dir("assets/documentos/")) {
			$subiu = move_uploaded_file($arquivos['file']['tmp_name'], 'assets/documentos/' . '/' . $nome_documento . $type);
		} else {
			mkdir("assets/documentos/");
			$subiu = move_uploaded_file($arquivos['file']['tmp_name'], 'assets/documentos/' . '/' . $nome_documento . $type);
		}


		try {


			$sql = $this->db->prepare("INSERT INTO documentos (docs_nome,id_company)
								VALUES (:nome_documento, :id_company)
						");

			$sql->bindValue(":nome_documento", strtolower($nome_documento . $type));
			$sql->bindValue(":id_company", $id_company);
			if ($sql->execute()) {

				$id = $this->db->lastInsertId();
	
				if((isset($id_obra) && $id_obra != '')){
					$this->addDocumentoObra($id_obra, $id);
				}

			} else {
				controller::alert('error', 'Contate o administrador do sistema!!');
			}
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}

		return $id;
	}

	public function delete($id, $id_company)
	{

		$sql = $this->db->prepare("DELETE FROM documentos WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		if ($sql->execute()) {
			controller::alert('danger', 'documento deletado com sucesso!!');
		} else {
			controller::alert('error', 'Usuario desativado com sucesso!!');
		}
	}

	public function getDocumentoById($id, $id_company)
	{

		$sql = $this->db->prepare("
			SELECT * FROM documentos
			WHERE id_company = :id_company AND id = :id
		");

		$sql->bindValue(':id', $id);
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetch();
		}

		return $this->array;
	}

	public function deleteDocFromEtapa($id_etapa, $id_documento)
	{

		$documentoArray = $this->getDocumentoById($id_documento, 1);

		$documento =  'assets/documentos/'.$documentoArray['docs_nome'];

		$sql = $this->db->prepare("DELETE FROM documento_etapa WHERE id_etapa_obra = :id_etapa AND id_documento = :id_documento");
		$sql->bindValue(":id_etapa", $id_etapa);
		$sql->bindValue(":id_documento", $id_documento);
		$sql->execute();

		unlink($documento);
	}

	public function getDocumentoObra($id_obra)
	{

		$sql = $this->db->prepare("
			SELECT * FROM documentos_obra docbr
			INNER JOIN documentos doc ON (doc.id = docbr.id_documento)
			WHERE  id_obra = :id_obra
		");

		$sql->bindValue(':id_obra', $id_obra);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	public function getDocumentoEtapa($id_etapa_obra)
	{

		$sql = $this->db->prepare("
			SELECT * FROM documento_etapa docet
			INNER JOIN documentos doc ON (doc.id = docet.id_documento)
			WHERE  id_etapa_obra = :id_etapa_obra LIMIT 1
		");

		$sql->bindValue(':id_etapa_obra', $id_etapa_obra);

		$sql->execute();

		if ($sql->rowCount() == 1) {
			$this->array = $sql->fetch();
			$this->db = null;
		}

		return $this->array;
		exit();
	}



	public function getDocumentoEtapaALL($id_etapa_obra)
	{

		$sql = $this->db->prepare("
			SELECT * FROM documento_etapa docet
			INNER JOIN documentos doc ON (doc.id = docet.id_documento)
			WHERE  id_etapa_obra = :id_etapa_obra 
		");

		$sql->bindValue(':id_etapa_obra', $id_etapa_obra);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchALL();
		}

		return $this->array;
		exit();
	}

	public function addDocumentoObra($id_obra, $id)
	{

		try {


			$sql = $this->db->prepare("INSERT INTO documentos_obra (id_obra,id_documento)
								VALUES (:id_obra, :id_documento)
						");

			$sql->bindValue(":id_documento", $id);
			$sql->bindValue(":id_obra", $id_obra);
			$sql->execute();
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}
	}

	public function addDocumentoEtapa($id_etapa, $arquivos, $nome_documento, $id_company, $id_obra)
	{



		$id_documento = $this->add($arquivos, $id_company, '', $nome_documento);

		try {


			$sql = $this->db->prepare("INSERT INTO documento_etapa (id_etapa_obra,id_documento)
								VALUES (:id_etapa, :id_documento)
						");

			$sql->bindValue(":id_documento", $id_documento);
			$sql->bindValue(":id_etapa", $id_etapa);
			$sql->execute();


			$this->addDocumentoObra($id_obra, $id_documento);
			

		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}
	}

	public function gerarWinrarEmail($id)
	{
		$params = implode(',', $id);

		$fileName  = 'documentos.zip';
		$path      = 'assets/documentos';
		$fullPath  = $path . '/' . $fileName;

		$scanDir = array();

		$sql = $this->db->prepare("SELECT docs_nome FROM documentos WHERE id IN ($params)");
		$sql->execute();

		if ($sql->rowCount() > 0) {

			foreach ($sql->fetchAll() as $doc) {
				$scanDir[] = $doc['docs_nome'];
			}
		}

		$zip = new \ZipArchive();

		// Criamos o arquivo e verificamos se ocorreu tudo certo
		if ($zip->open($fullPath, \ZipArchive::CREATE)) {
			// adiciona ao zip todos os arquivos contidos no diretório.
			foreach ($scanDir as $file) {

				$zip->addFile($path . '/' . $file, $file);
			}
			// fechar o arquivo zip após a inclusão dos arquivos desejados
			$zip->close();
		}

		if (file_exists($fullPath)) {
			// Forçamos o donwload do arquivo.
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename="' . $fileName . '"');
			readfile($fullPath);
			//removemos o arquivo zip após download
			unlink($fullPath);
		}
	}

	public function gerarWinrarObra($id_obra)
	{

		$fileName  = 'documentos.zip';
		$path      = 'assets/documentos';
		$fullPath  = $path . '/' . $fileName;

		$scanDir = array();

		$sql = $this->db->prepare("SELECT doc.docs_nome FROM documentos_obra docsO
			INNER JOIN documentos doc ON (doc.id = docsO.id_documento)
			WHERE docsO.id_obra = :id_obra
		");

		$sql->bindValue(':id_obra', $id_obra);
		$sql->execute();

		if ($sql->rowCount() > 0) {

			foreach ($sql->fetchAll() as $doc) {
				$scanDir[] = $doc['docs_nome'];
			}

			$zip = new \ZipArchive();

			// Criamos o arquivo e verificamos se ocorreu tudo certo
			if ($zip->open($fullPath, \ZipArchive::CREATE)) {
				// adiciona ao zip todos os arquivos contidos no diretório.
				foreach ($scanDir as $file) {

					$zip->addFile($path . '/' . $file, $file);
				}
				// fechar o arquivo zip após a inclusão dos arquivos desejados
				$zip->close();
			}

			if (file_exists($fullPath)) {
				// Forçamos o donwload do arquivo.
				header('Content-Type: application/zip');
				header('Content-Disposition: attachment; filename="' . $fileName . '"');
				readfile($fullPath);
				//removemos o arquivo zip após download
				unlink($fullPath);
			} else {
				$var = "<script>javascript:history.back(-2)</script>";
				echo $var;
				controller::alert('warning', 'Não foram encontrado(s) documento(s) nessa obra!!');
			}
		} else {
			$var = "<script>javascript:history.back(-2)</script>";
			echo $var;
			controller::alert('warning', 'Não foram encontrado(s) documento(s) nessa obra!!');
		}
	}
}
