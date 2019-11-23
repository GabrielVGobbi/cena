<?php

class Cliente extends model
{

	public function __construct()
	{
		parent::__construct();

		$this->array = array();
		$this->retorno = array();
	}

	public function getAll($offset, $filtro, $id_company)
	{

		$where = $this->buildWhere($filtro, $id_company);

		$sql = "SELECT *, cli.id as id_cliente  FROM  
			cliente cli
		LEFT JOIN cliente_endereco cled ON (cli.clend_id = cled.id_endereco)
		
		WHERE " . implode(' AND ', $where) . " GROUP BY cli.id ORDER BY cli.cliente_nome ASC LIMIT $offset, 10";

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


	public function add($Parametros, $id_company)
	{

		$id_endereco = $this->setEnderecoCliente($Parametros, $id_company);

		$cliente_nome = controller::ReturnValor($Parametros['cliente_nome']);
		$cliente_apelido = controller::ReturnValor($Parametros['cliente_apelido']);

		$cliente_cnpj = !empty($Parametros['cliente_cnpj']) ? controller::ReturnFormatLimpo($Parametros['cliente_cnpj']) : '';

		$sql = $this->db->prepare("INSERT INTO cliente SET 
			
			cliente_nome = :cliente_nome, 
			cliente_cnpj = :cliente_cnpj,
			cliente_apelido = :cliente_apelido,
			created_at = NOW(),
			clend_id = :id_endereco,
			id_company = :id_company
		
		");

		$sql->bindValue(":cliente_nome", $cliente_nome);
		$sql->bindValue(":id_company", $id_company);
		$sql->bindValue(":id_endereco", $id_endereco);
		$sql->bindValue(":cliente_cnpj", $cliente_cnpj);
		$sql->bindValue(":cliente_apelido", $cliente_apelido);


		if ($sql->execute()) {

			$id_cliente = $this->db->lastInsertId();

			if (!empty($Parametros['dep_responsavel']))
				$this->setDepartamentoCliente($Parametros, $id_company, $id_cliente);

			controller::setLog($Parametros, 'cliente', 'add');

			controller::alert('success', 'Cadastrado com sucesso');

			return $id_cliente;
		}

		controller::alert('warning', 'Não foi possivel cadastrar o cliente, contate o administrador da empresa');
	}

	public function edit($Parametros, $id_company)
	{

		$id_endereco = isset($Parametros['id_endereco'])
			? $this->setEnderecoCliente($Parametros, $id_company, $Parametros['id_endereco'])
			: $this->setEnderecoCliente($Parametros, $id_company);

		$cliente_nome = controller::ReturnValor($Parametros['cliente_nome']);
		$cliente_apelido = controller::ReturnValor($Parametros['cliente_apelido']);
		$cliente_cnpj = !empty($Parametros['cliente_cnpj']) ? controller::ReturnFormatLimpo($Parametros['cliente_cnpj']) : '';

		$id_departamento = !empty($Parametros['id_departamento']) ? $Parametros['id_departamento'] : '';

		if (isset($Parametros['id_cliente']) && $Parametros['id_cliente'] != '') {

			$sql = $this->db->prepare("UPDATE cliente SET 
				
				cliente_nome = :cliente_nome, 
				cliente_apelido = :cliente_apelido,
				cliente_cnpj = :cliente_cnpj,
				created_at = NOW(),
				id_company = :id_company,
				clend_id = :id_endereco


				WHERE id = :id_cliente AND id_company = :id_company;
        	");

			$sql->bindValue(":cliente_nome", $cliente_nome);
			$sql->bindValue(":cliente_apelido", $cliente_apelido);
			$sql->bindValue(":id_company", $id_company);
			$sql->bindValue(":cliente_cnpj", $cliente_cnpj);
			$sql->bindValue(":id_cliente", $Parametros['id_cliente']);
			$sql->bindValue(":id_endereco", $id_endereco);

			$sql->execute()
				? controller::alert('success', 'Editado com sucesso')
				: controller::alert('error', 'Ops!! deu algum erro');

			#if (!empty($Parametros['dep_responsavel']))
				$this->setDepartamentoCliente($Parametros, $id_company, $Parametros['id_cliente'], $id_departamento);

			controller::setLog($Parametros, 'cliente', 'edit');
		}
	}

	public function setEnderecoCliente($Parametros, $id_company, $id_endereco = false)
	{

		if ($id_endereco == false && !empty($Parametros['cep'])) {

			$sql = $this->db->prepare("INSERT INTO cliente_endereco SET 
				rua = :rua, 
				numero = :numero,
				cidade = :cidade,
				bairro = :bairro,
				estado = :estado,
				complemento = :complemento,
				inscEstado = :inscEstado,
				cep = :cep
			");

			$sql->bindValue(":rua", $Parametros['rua']);
			$sql->bindValue(":numero", $Parametros['numero']);
			$sql->bindValue(":cidade", $Parametros['cidade']);
			$sql->bindValue(":bairro", $Parametros['bairro']);
			$sql->bindValue(":inscEstado", $Parametros['inscEstado']);
			$sql->bindValue(":complemento", $Parametros['complemento']);
			$sql->bindValue(":estado", $Parametros['estado']);

			$sql->bindValue(":cep", $Parametros['cep']);

			$sql->execute();

			$id_endereco = $this->db->lastInsertId();
			
		} else {

			$sql = $this->db->prepare("UPDATE `cliente_endereco` SET  
				rua = :rua, 
				numero = :numero,
				cidade = :cidade,
				bairro = :bairro,
				estado = :estado,
				complemento = :complemento,
				inscEstado = :inscEstado,
				cep = :cep

				WHERE id_endereco = :id_endereco
			");

			$sql->bindValue(":rua", $Parametros['rua']);
			$sql->bindValue(":numero", $Parametros['numero']);
			$sql->bindValue(":cidade", $Parametros['cidade']);
			$sql->bindValue(":bairro", $Parametros['bairro']);
			$sql->bindValue(":inscEstado", $Parametros['inscEstado']);
			$sql->bindValue(":complemento", $Parametros['complemento']);
			$sql->bindValue(":estado", $Parametros['estado']);
			$sql->bindValue(":id_endereco", $id_endereco);

			$sql->bindValue(":cep", $Parametros['cep']);


			$sql->execute()
				? controller::alert('success', 'Editado com sucesso')
				: controller::alert('error', 'Ops!! deu algum erro');
		}

		return $id_endereco;
	}

	public function setDepartamentoCliente($Parametros, $id_company, $id_cliente, $id_departamento = false)
	{


		if (isset($Parametros['dep'])) {
			if (count($Parametros['dep']['id_departamento']) > 0) {
				for ($q = 0; $q < count($Parametros['dep']['id_departamento']); $q++) {

					if ($Parametros['dep']['id_departamento'][$q] != '') {

						$sql = $this->db->prepare("UPDATE `departamento` SET
							
							dep_responsavel = :dep_responsavel,
							dep_telefone_celular = :dep_telefone_celular,
							dep_telefone_fixo = :dep_telefone_fixo,
							dep_email = :dep_email
                            
							WHERE id_departamento = :id_departamento
                        ");

						$sql->bindValue(":dep_responsavel", 	 $Parametros['dep']['dep_responsavel'][$q]);
						$sql->bindValue(":dep_telefone_celular", $Parametros['dep']['dep_telefone_celular'][$q]);
						$sql->bindValue(":dep_email", 	 		 $Parametros['dep']['dep_email'][$q] );
						$sql->bindValue(":dep_telefone_fixo", 	 $Parametros['dep']['dep_telefone_fixo'][$q] );
						$sql->bindValue(":id_departamento", 	 $Parametros['dep']['id_departamento'][$q] );

						$sql->execute();

					} else {

						$sql = $this->db->prepare("INSERT `departamento` SET
							
							dep_responsavel = :dep_responsavel,
							dep_telefone_celular = :dep_telefone_celular,
							dep_telefone_fixo = :dep_telefone_fixo,
							dep_email = :dep_email
                        ");

						$sql->bindValue(":dep_responsavel", 	 $Parametros['dep']['dep_responsavel'][$q]);
						$sql->bindValue(":dep_telefone_celular", $Parametros['dep']['dep_telefone_celular'][$q]);
						$sql->bindValue(":dep_email", 	 		 $Parametros['dep']['dep_email'][$q] );
						$sql->bindValue(":dep_telefone_fixo", 	 $Parametros['dep']['dep_telefone_fixo'][$q] );

						if($sql->execute())
							$id_departamento = $this->db->lastInsertId();
							
							$sql = $this->db->prepare("INSERT `departamento_cliente` SET
							
								id_cliente = :id_cliente,
								id_departamento = :id_departamento,
								id_company = :id_company

                        	");
							$sql->bindValue(":id_cliente", 	 		 $id_cliente);
							$sql->bindValue(":id_departamento", 	 $id_departamento);
							$sql->bindValue(":id_company", 	 		 $id_company);
							$sql->execute();

					}
				}
			}
		} else { }

		return $id_departamento;
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

		$id = $this->db->lastInsertId();

		return $id;
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
			SELECT * FROM cliente cli
			LEFT JOIN cliente_endereco cled ON (cli.clend_id = cled.id_endereco)
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

	public function validacao($id_company, $nome, $id = '')
	{

		$nome = controller::ReturnValor($nome);

		$sql = $this->db->prepare("SELECT * FROM cliente

			WHERE id_company = :id_company AND cliente_nome = :cliente_nome AND id <> :id
		");

		$sql->bindValue(':cliente_nome', $nome);
		$sql->bindValue(':id_company', $id_company);
		$sql->bindValue(':id', $id);

		$sql->execute();

		if ($sql->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getDepartamentoClienteById($id_cliente)
	{

		$sql = $this->db->prepare("SELECT * FROM departamento_cliente depcli
			INNER JOIN departamento dep ON (dep.id_departamento = depcli.id_departamento)

			WHERE depcli.id_cliente = :id_cliente
		");
		$sql->bindValue(':id_cliente', $id_cliente);
		$sql->execute();

		return $array = ($sql->rowCount() > 0) ? $sql->fetchAll() : array();
	}
}
