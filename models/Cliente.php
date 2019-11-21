<?php

class Cliente extends model
{

	var $table = 'cliente'; //nome da tabela
	var $column = array(0=>'',1=>'cliente_nome',2=>'cliente_nome',3=>'cliente_email'); //ordem das colunas
	var $column_search = array('cli_nome','cli_sorenome','cli_email'); //colunas para pesquisas
	var $order = array('id' => 'desc'); // order padrão

	public function __construct()
	{
		parent::__construct();
		$this->array = array();
		$this->retorno = array();
	}

	public function getAll($filtro, $id_company)
	{
		$start = isset($filtro['start']) ? $filtro['start'] : '0';
		$length = isset($filtro['length']) ? $filtro['length'] : '10';

		$order =  !empty($this->column[$filtro['order'][0]['column']]) ? " ORDER BY ".$this->column[$filtro['order'][0]['column']]." ".$filtro['order'][0]['dir'] : '';

		$where = $this->buildWhere($filtro, $id_company);

		$sql = (" SELECT * FROM `$this->table` cli WHERE " . implode(' AND ', $where). $order ." LIMIT ".$start." ,".$length);

		$sql = $this->db->prepare($sql);
	        
		$this->bindWhere($filtro, $sql);
		
        $sql->execute();

		$this->retorno = ($sql->rowCount() > 0) ? $sql->fetchAll() : '';
		
        return $this->retorno;
		
	}

	private function buildWhere($filtro, $id_company)
	{


		$where = array(
			'id_company='.$id_company
		);


		if (!empty($filtro['search']['value'])) {

			if ($filtro['search']['value'] != '') {

				$where[] = "(cli.cliente_nome LIKE :cliente_nome) OR (cli.cliente_email LIKE :cliente_nome)";
			}
		}

		return $where;
	}

	private function bindWhere($filtro, &$sql)
	{


		if (!empty($filtro['search']['value'])) {
			if ($filtro['search']['value'] != '') {
				$sql->bindValue(":cliente_nome", '%' . $filtro['search']['value'] . '%');
			}
		}
	}


	public function add($Parametros,$id_company)
	{

		$cliente_nome = controller::ReturnValor($Parametros['cliente_nome']);
		$cliente_email = mb_strtolower($Parametros['email']);
		$cliente_rg = controller::ReturnFormatLimpo($Parametros['rg']);
		$cliente_cpf = controller::ReturnFormatLimpo($Parametros['cpf']);

		$cliente_telefone = $Parametros['cliente_telefone'];


		if (isset($Parametros['cep']) && $Parametros['cep'] != '') {
			try {
				$sql = $this->db->prepare("INSERT INTO cliente_endereco SET 
            		rua = :rua, 
            		numero = :numero,
            		cidade = :cidade,
            		bairro = :bairro,
            		estado = :estado,
					cep = :cep
				");

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
						clend_id = :id_endereco,
						cliente_telefone = :cliente_telefone
					");

					$sql->bindValue(":cliente_nome", $cliente_nome);
					$sql->bindValue(":cliente_rg", $cliente_rg);
					$sql->bindValue(":cliente_cpf", $cliente_cpf);
					$sql->bindValue(":cliente_email", $cliente_email);
					$sql->bindValue(":id_company", $id_company);
					$sql->bindValue(":id_endereco", $id_endereco);
					$sql->bindValue(":cliente_telefone", $cliente_telefone);


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
            			cliente_cpf = :cliente_cpf,
						cliente_telefone = :cliente_telefone
        			");

			$sql->bindValue(":cliente_nome", $cliente_nome);
			$sql->bindValue(":cliente_rg", $cliente_rg);
			$sql->bindValue(":cliente_cpf", $cliente_cpf);
			$sql->bindValue(":cliente_email", $cliente_email);
			$sql->bindValue(":id_company", $id_company);
			$sql->bindValue(":cliente_telefone", $cliente_telefone);

			$sql->execute();

			controller::setLog($Parametros, 'cliente', 'add');

		}

		

		return $this->db->lastInsertId();
	}

	public function edit($Parametros, $id_company)
	{

		$cliente_nome = controller::ReturnValor($Parametros['cliente_nome']);
		$cliente_email = mb_strtolower($Parametros['cliente_email']);
		$cliente_responsavel = $Parametros['cliente_responsavel'];

		$cliente_telefone = $Parametros['cliente_telefone'];


		if (isset($Parametros['id_cliente']) && $Parametros['id_cliente'] != '') {

			$sql = $this->db->prepare("UPDATE cliente SET 
				cliente_nome = :cliente_nome, 
				cliente_email = :cliente_email, 
				cliente_responsavel = :cliente_responsavel,
				cliente_telefone = :cliente_telefone

				WHERE id = :id_cliente AND id_company = :id_company;
        	");

			$sql->bindValue(":cliente_nome", $cliente_nome);
			$sql->bindValue(":cliente_email", $cliente_email);
			$sql->bindValue(":cliente_responsavel", $cliente_responsavel);
			$sql->bindValue(":id_cliente", $Parametros['id_cliente']);
			$sql->bindValue(":id_company", $id_company);
			$sql->bindValue(":cliente_telefone", $cliente_telefone);


			$sql->execute();

			controller::setLog($Parametros, 'cliente', 'edit');

		}
	}

	public function addAcessoCliente($Parametros, $id_company)
	{


		$login = mb_strtolower($Parametros['login'], 'utf-8');
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

		controller::setLog($Parametros, 'acesso_usuario', 'add');



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
			controller::setLog($Parametros, 'cliente', 'delete');

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

	public function validacao($id_company, $nome)
	{

		$nome = controller::ReturnValor($nome);
		
		$sql = $this->db->prepare("SELECT * FROM cliente

			WHERE id_company = :id_company AND cliente_nome = :cliente_nome
		");

		$sql->bindValue(':cliente_nome', $nome);
		$sql->bindValue(':id_company', $id_company);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
