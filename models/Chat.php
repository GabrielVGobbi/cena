<?php

class Chat extends model
{
	private $chat;

	public function __construct()
	{
		parent::__construct();

		$sql = $this->db->prepare("SELECT * FROM chat chat 
			INNER JOIN users user ON (user.id = chat.id_user
		
		) ORDER BY id_chat ASC ");
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->chat = $sql->fetchALL();
		}
		#11
	}

	public function getMensage()
	{

		return isset($this->chat) ? $this->chat : 'Não existe Mensagem';
	}

	public function getMensageNaoLidas($id_user)
	{

		$r = 0;

		$sql = $this->db->prepare("SELECT COUNT(*) AS count FROM notificacao_usuario WHERE id_user = :id_user AND lido = 0");
		$sql->bindValue(":id_user", $id_user);

		$sql->execute();

		$row = $sql->fetch();

		$r = $row['count'];

		return $r;
	}

	public function lerMensagesALL($id_user)
	{

		if ($id_user)
			$sql = $this->db->prepare(
				"UPDATE notificacao_usuario SET 
							
					lido = '1'
					WHERE id_user = :id_user
				"
			);

		$sql->bindValue(":id_user", $id_user);
		$sql->execute();

		return $id_user;
	}


	public function newMensage($Parametros, $id_user)
	{
		try {
			$datenow = date('Y-m-d H:i:s', strtotime('-1 Hours'));

			$sql = $this->db->prepare("INSERT INTO chat SET 
				chat_mensagem = :chat_mensagem,
				id_user = :id_user,
				created_date = :datenow
			");

			$sql->bindValue(":chat_mensagem", $Parametros['message']);
			$sql->bindValue(":id_user", $id_user);
			$sql->bindValue(":datenow", $datenow);

			if ($sql->execute()) {

				$id_chat = $this->db->lastInsertId();

				$u = new Users();

				$arrayUsuario = $u->getList(0, '', 1);

				foreach ($arrayUsuario as $usu) {

					$id_user_add = $usu['id'];

					if ($id_user_add == $id_user)
						continue;

					$sql = $this->db->prepare("INSERT INTO notificacao_usuario SET 
						id_user = :id_user,
						id_notificacao = :id_notificacao
					");

					$sql->bindValue(":id_notificacao", $id_chat);
					$sql->bindValue(":id_user", $id_user_add);

					$sql->execute();
				}
			}

			return $id_chat;

		} catch (PDOExecption $e) {

			$sql->rollback();
			error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
		}
	}
}
