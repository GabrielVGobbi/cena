<?php

class Cliente extends model
{

	public function __construct()
	{
		parent::__construct();
		$this->array = array();
		$this->retorno = array();
	}

	public function getAll($filtro, $id_company)
	{

		$where = $this->buildWhere($filtro, $id_company);

		$sql = "SELECT * FROM  
			cliente cli
		LEFT JOIN cliente_endereco cled ON (cli.clend_id = cled.id_endereco)
		
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


		if (!empty($filtro['cliente_nome'])) {

			if ($filtro['cliente_nome'] != '') {

				$where[] = "cli.cliente_nome LIKE :cliente_nome";
			}
		}

		if (!empty($filtro['cliente_responsavel'])) {

			if ($filtro['cliente_responsavel'] != '') {

				$where[] = "cli.cliente_responsavel LIKE :cliente_responsavel";
			}
		}

		if (!empty($filtro['id'])) {

			if ($filtro['id'] != '') {

				$where[] = "cli.id = :id";
			}
		}
		return $where;
	}

	private function bindWhere($filtro, &$sql)
	{
		if (!empty($filtro['id'])) {
			if ($filtro['id'] != '') {
				$sql->bindValue(":id", $filtro['id']);
			}
		}
		if (!empty($filtro['cliente_nome'])) {
			if ($filtro['cliente_nome'] != '') {
				$sql->bindValue(":cliente_nome", '%' . $filtro['cliente_nome'] . '%');
			}
		}
		if (!empty($filtro['cliente_responsavel'])) {
			if ($filtro['cliente_responsavel'] != '') {
				$sql->bindValue(":cliente_responsavel", '%' . $filtro['cliente_responsavel'] . '%');
			}
		}
	}


	public function add($id_company, $Parametros)
	{

		$cliente_nome = controller::ReturnValor($Parametros['cliente_nome']);
		$cliente_email = mb_strtolower($Parametros['email']);
		$cliente_rg = controller::ReturnFormatLimpo($Parametros['rg']);
		$cliente_cpf = controller::ReturnFormatLimpo($Parametros['cpf']);

		if (isset($Parametros['cep']) && $Parametros['cep'] != '') {
			try {
				$sql = $this->db->prepare("INSERT INTO cliente_endereco SET 
            		rua = :rua, 
            		numero = :numero,
            		cidade = :cidade,
            		bairro = :bairro,
            		estado = :estado,
					cep = :cep");

				$sql->bindValue(":rua", $Parametros['rua']);
				$sql->bindValue(":numero", $Parametros['numero']);
				$sql->bindValue(":cidade", $Parametros['cidade']);
				$sql->bindValue(":bairro", $Parametros['bairro']);
				$sql->bindValue(":estado", $Parametros['estado']);
				$sql->bindValue(":cep", $Parametros['cep']);
				$sql->execute();

				$id_endereco = $this->db->lastInsertId();

				if ($id_endereco != 0) {
					$sql = $this->db->prepare("INSERT INTO cliente SET 
            			cliente_nome = :cliente_nome, 
            			cliente_email = :cliente_email,
            			id_company = :id_company,
            			cliente_rg = :cliente_rg,
            			cliente_cpf = :cliente_cpf,
						clend_id = :id_endereco
					");

					$sql->bindValue(":cliente_nome", $cliente_nome);
					$sql->bindValue(":cliente_rg", $cliente_rg);
					$sql->bindValue(":cliente_cpf", $cliente_cpf);
					$sql->bindValue(":cliente_email", $cliente_email);
					$sql->bindValue(":id_company", $id_company);
					$sql->bindValue(":id_endereco", $id_endereco);

					if ($sql->execute()) {
						$this->retorno['cliente_add']['mensagem']['sucess'] = 'sucesso';
					} else {
						$this->retorno['cliente_add']['mensagem']['error'] = 'erro ao cadastrar';
					}
				}
			} catch (PDOExecption $e) {
				$sql->rollback();
				error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
			}
		} else {
			$sql = $this->db->prepare("INSERT INTO cliente SET 
            			cliente_nome = :cliente_nome, 
            			cliente_email = :cliente_email,
            			id_company = :id_company,
            			cliente_rg = :cliente_rg,
            			cliente_cpf = :cliente_cpf
        			");

			$sql->bindValue(":cliente_nome", $cliente_nome);
			$sql->bindValue(":cliente_rg", $cliente_rg);
			$sql->bindValue(":cliente_cpf", $cliente_cpf);
			$sql->bindValue(":cliente_email", $cliente_email);
			$sql->bindValue(":id_company", $id_company);

			$sql->execute();
		}

		return $this->db->lastInsertId();
	}

	public function edit($Parametros)
	{

		$cliente_nome = controller::ReturnValor($Parametros['cliente_nome']);
		$cliente_email = strtolower($Parametros['email']);

		if (isset($Parametros['id_cliente']) && $Parametros['id_cliente'] != '') {

			$sql = $this->db->prepare("UPDATE cliente SET 
				cliente_nome = :cliente_nome, 
				cliente_email = :cliente_email
				WHERE id_cliente = :id_cliente
        	");

			$sql->bindValue(":cliente_nome", $cliente_nome);
			$sql->bindValue(":cliente_email", $cliente_email);
			$sql->bindValue(":id_cliente", $Parametros['id_cliente']);
			$sql->execute();
		}
	}

	public function addAcessoCliente($Parametros, $id_company)
	{


		$login = lcfirst($Parametros['login']);
		$pass  = ($Parametros['password']);

		$sql = $this->db->prepare("INSERT INTO users SET 
            			login = :login,
            			id_company = :id_company,
						password = :password,
						usr_info = :cliente,
						id_cliente = :id_cliente	
        			");

		$sql->bindValue(":login", $login);
		$sql->bindValue(":password", md5($pass));
		$sql->bindValue(":id_company", $id_company);
		$sql->bindValue(":cliente", 'cliente');
		$sql->bindValue(":id_cliente", $Parametros['id']);



		$sql->execute();

		$sql = $this->db->prepare("UPDATE cliente SET 
				acesso = :acesso,
				acesso_criado = :acesso_criado

				WHERE id = :id_cliente
        	");

		$sql->bindValue(":id_cliente", $Parametros['id']);
		$sql->bindValue(":acesso", '1');
		$sql->bindValue(":acesso_criado", '1');

		$sql->execute();


		return $id = $this->db->lastInsertId();
	}

	public function desativar($id_cliente, $id_company)
	{


		$sql = $this->db->prepare("UPDATE cliente SET 
				acesso = :acesso

				WHERE id = :id_cliente
        	");

		$sql->bindValue(":id_cliente", $id_cliente);
		$sql->bindValue(":acesso", '0');
		$sql->execute();


		$sql = $this->db->prepare("UPDATE users SET usu_ativo = 0 WHERE id_cliente = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id_cliente);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();
	}

	public function ativar($id_cliente, $id_company)
	{


		$sql = $this->db->prepare("UPDATE cliente SET 
				acesso = :acesso

				WHERE id = :id_cliente
        	");

		$sql->bindValue(":id_cliente", $id_cliente);
		$sql->bindValue(":acesso", '1');
		$sql->execute();


		$sql = $this->db->prepare("UPDATE users SET usu_ativo = 1 WHERE id_cliente = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id_cliente);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();
	}

	public function updateEnderecoCliente($Parametros)
	{
		$sql = $this->db->prepare("INSERT INTO cliente_endereco SET 
            		rua = :rua, 
            		numero = :numero,
            		cidade = :cidade,
            		bairro = :bairro,
            		estado = :estado,
					cep = :cep");

		$sql->bindValue(":rua", $Parametros['rua']);
		$sql->bindValue(":numero", $Parametros['numero']);
		$sql->bindValue(":cidade", $Parametros['cidade']);
		$sql->bindValue(":bairro", $Parametros['bairro']);
		$sql->bindValue(":estado", $Parametros['estado']);
		$sql->bindValue(":cep", $Parametros['cep']);
		$sql->execute();

		$id_endereco = $this->db->lastInsertId();

		if (isset($Parametros['id_cliente']) && $Parametros['id_cliente'] != '') {

			$sql = $this->db->prepare("UPDATE cliente SET 
				clend_id = :clen_id

				WHERE id_cliente = :id_cliente
        	");

			$sql->bindValue(":id_cliente", $Parametros['id_cliente']);
			$sql->bindValue(":clen_id", $id_endereco);
			$sql->execute();
		}
	}


	public function delete($id, $id_company)
	{

		$sql = $this->db->prepare("DELETE FROM cliente WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		if ($sql->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function getCount($id_company)
	{

		$r = 0;

		$sql = $this->db->prepare("SELECT COUNT(*) AS c FROM cliente WHERE id_company = :id_company");
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();
		$row = $sql->fetch();

		$r = $row['c'];

		return $r;
	}

	public function getClienteById($id, $id_company)
	{
		$sql = $this->db->prepare("
			SELECT * FROM cliente
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

	public function searchClienteByName($var, $id_company)
	{

		$sql = $this->db->prepare("
			SELECT * FROM cliente
			WHERE id_company = :id_company AND cliente_nome like :cliente_nome
		");

		$sql->bindValue(':cliente_nome', '%' . $var . '%');
		$sql->bindValue(':id_company', $id_company);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$this->array = $sql->fetchAll();
		}

		return $this->array;
	}
}
