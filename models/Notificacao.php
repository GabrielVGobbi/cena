<?php

class Notificacao extends model
{

	public function __construct($nomeTabela)
	{
		parent::__construct();

		$this->array = array();
		$this->retorno = array();

		$this->user = new Users();
		$this->tabela = $nomeTabela;

		$this->arrayToDo = array();
	}

	public function getAllTodoByUsuario($id_user)
	{

		$sql = "SELECT * FROM  
					tarefas_usuario tafUsu
				INNER JOIN users usr ON (usr.id = tafUsu.id_user)
				INNER JOIN tarefas tar ON  (tar.id_tarefa = tafUsu.id_tarefa)
				WHERE id_user = {$id_user}
			";

		$sql = $this->db->prepare($sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->arrayToDo = $sql->fetchAll();
		}

		return $this->arrayToDo;
	}




	public function getAll($filtro, $id_company, $id_user)
	{

		$where = $this->buildWhere($filtro, $id_company, $id_user);

		$sql = "SELECT * FROM  
			notificacao_usuario notifu
		INNER JOIN notificacoes noti ON (noti.id = notifu.id_notificacao)
		INNER JOIN users usr ON (usr.id = notifu.id_user)

		WHERE " . implode(' AND ', $where) . " ORDER BY noti.id DESC";

		$sql = $this->db->prepare($sql);

		$this->bindWhere($filtro, $sql);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	private function buildWhere($filtro, $id, $id_user)
	{

		$where = array(
			'usr.id_company=' . $id,
			'notifu.id_user=' . $id_user
		);

		if (!empty($filtro['Notificacao'])) {

			if ($filtro['Notificacao'] != '') {

				$where[] = "cli.Notificacao LIKE :Notificacao";
			}
		}

		return $where;
	}

	private function bindWhere($filtro, &$sql)
	{

		if (!empty($filtro['Notificacao'])) {
			if ($filtro['Notificacao'] != '') {
				$sql->bindValue(":Notificacao", '%' . $filtro['Notificacao'] . '%');
			}
		}
	}

	public function insert_noti($id_company, $Parametros)
	{

		$encoding = 'UTF-8'; // ou ISO-8859-1...
		$tipo = mb_convert_case($Parametros['tipo'], MB_CASE_UPPER, $encoding);
		$props = $Parametros['props'];
		$link  = $Parametros['link'];
		$id_company = $Parametros['id_company'];
		$nome_usuario = $Parametros['usuario'];
		$filtro = array(
			'usr_info' => 'sistema'
		);


		try {
			$sql = $this->db->prepare("INSERT INTO notificacoes SET 
        		data_notificacao = :data_notificacao,
        		notificacao_tipo = :notificacao_tipo,
        		propriedades = :propriedades,
				link = :link,
				id_company = :id_company, 
				nome_usuario = :nome_usuario

			");

			$sql->bindValue(":data_notificacao",  date('Y-m-d H:i:s'));
			$sql->bindValue(":notificacao_tipo", $tipo);
			$sql->bindValue(":propriedades", json_encode($props, JSON_UNESCAPED_UNICODE));
			$sql->bindValue(":link", $link);
			$sql->bindValue(":id_company", $id_company);
			$sql->bindValue(":nome_usuario", $nome_usuario);

			$sql->execute();

			$id_notificacao = $this->db->lastInsertId();

			$arrayUsuario = $this->user->getList(0, $filtro, $id_company);

			foreach ($arrayUsuario as $usu) {

				$id_user = $usu['id'];

				$sql = $this->db->prepare("INSERT INTO notificacao_usuario SET 
					id_user = :id_user,
					id_notificacao = :id_notificacao
				");

				$sql->bindValue(":id_notificacao", $id_notificacao);
				$sql->bindValue(":id_user", $id_user);

				$sql->execute();
			}
		} catch (PDOExecption $e) {
			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}

		return $id_notificacao;
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

			WHERE id_company = :id_company AND Notificacao like :Notificacao
		");

		$sql->bindValue(':Notificacao', '%' . $var . '%');
		$sql->bindValue(':id_company', $id_company);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}

	public function ler($id_notificao, $id_user)
	{

		$sql = $this->db->prepare(
			"UPDATE notificacao_usuario SET 
					
			lido = '1'
			WHERE id_not_user = :id AND id_user = :id_user
	    "
		);

		$sql->bindValue(":id", $id_notificao);
		$sql->bindValue(":id_user", $id_user);


		$sql->execute();

		return $id_notificao;
	}

	public function LerTudo($id_user)
	{

		$sql = $this->db->prepare(
			"UPDATE notificacao_usuario SET 
					
			lido = '1'
			WHERE id_user = :id_user
	    "
		);

		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}
}
