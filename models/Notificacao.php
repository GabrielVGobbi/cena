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
					notificacao_usuario notFi
				INNER JOIN users usr ON (usr.id = notFi.id_user)
				INNER JOIN tarefas tar ON  (tar.id_tarefa = notFi.id_tarefa)
				WHERE id_user = {$id_user} AND notFi.id_tarefa IS NOT NULL AND lido <> 1
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
			'notifu.id_user=' . $id_user,
			'notifu.id_notificacao IS NOT NULL' 
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
			WHERE id_not_user = :id AND id_user = :id_user AND id_notificacao IS NOT NULL
	    "
		);

		$sql->bindValue(":id", $id_notificao);
		$sql->bindValue(":id_user", $id_user);


		$sql->execute();

		return $id_notificao;
	}

	public function checkToDo($id_notificao, $id_user, $lido)
	{

		
		$sql = $this->db->prepare(
			"UPDATE notificacao_usuario SET 
					
			lido = :lido
			WHERE id_not_user = :id AND id_user = :id_user
	    "
		);

		$sql->bindValue(":id", $id_notificao);
		$sql->bindValue(":id_user", $id_user);
		$sql->bindValue(":lido", $lido);



		$sql->execute();

		return $id_notificao;
	}

	public function LerTudo($id_user)
	{

		$sql = $this->db->prepare(
			"UPDATE notificacao_usuario SET 
					
			lido = '1'
			WHERE id_user = :id_user AND id_notificacao IS NOT NULL 
	    "
		);

		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return true;
	}


	public function addToDoNewObra($Parametros, $id_company, $id_user, $type)
	{

		$u = new Users();
		$u->setLoggedUser();
		$obr = new Obras();

		$json = array();
		$json['type'] = $type;
		$json['id_obra'] = $Parametros['id'];

		$nomeObra = $obr->getNameObra($Parametros['id']);

		$tar_titulo = 'Nova Obra';
		$tar_descricao = $nomeObra .' criado por '.$u->getName();
		$tar_prioridade = 'ALTA';
		$tar_prazo = '';
		$tar_dataJson = json_encode($json,1);

		try {
			$datenow = date('Y-m-d H:i:s', strtotime('-1 Hours'));

			$sql = $this->db->prepare("INSERT INTO tarefas SET 
				tar_titulo = :tar_titulo,
				tar_descricao = :tar_descricao,
				tar_prazo = :tar_prazo,
				tar_prioridade = :tar_prioridade,
				tar_dataJson = :tar_dataJson,

				created_date = :datenow
			");

			$sql->bindValue(":tar_titulo", 	$tar_titulo);
			$sql->bindValue(":tar_descricao", $tar_descricao);
			$sql->bindValue(":tar_prazo", $tar_prazo);
			$sql->bindValue(":tar_dataJson", $tar_dataJson);
			$sql->bindValue(":tar_prioridade", $tar_prioridade);

			$sql->bindValue(":datenow", $datenow);

			if ($sql->execute()) {

				$id_tarefa = $this->db->lastInsertId();

				$u = new Users();

				$arrayUsuario = $u->getList(0, '', 1);

				foreach ($arrayUsuario as $usu) {

					$id_user_add = $usu['id'];

					$sql = $this->db->prepare("INSERT INTO notificacao_usuario SET 
						id_user = :id_user,
						id_tarefa = :id_tarefa
					");

					$sql->bindValue(":id_tarefa", $id_tarefa);
					$sql->bindValue(":id_user", $id_user_add);

					$sql->execute();
				}
			}

			return $id_tarefa;

		} catch (PDOExecption $e) {

			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}
	}

	public function concluirToDo($Parametros, $id_user){


		$lido = $lido;

		$id_obra = '';

		$sql = $this->db->prepare("UPDATE notificacao_usuario  SET

			lido = :lido

			WHERE (id_user = :id_user) AND (id_obra = :id_obra)

		");

		$sql->bindValue(':lido',   $lido);
		$sql->bindValue(':id_obra',   $id_obra);
		$sql->bindValue(':id_user',   $id_user);
		$sql->execute();


	}
}
