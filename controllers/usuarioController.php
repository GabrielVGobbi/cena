<?php

class usuarioController extends controller
{

	public function __construct()
	{
		parent::__construct();

		$this->user = new Users();
		$this->user->setLoggedUser();

		if ($this->user->isLogged() == false) {

			header("Location: " . BASE_URL . "login");
			exit();
		}

		$this->permission = new Permissions();
		$this->painel = new Painel();

		$company = new Companies($this->user->getCompany());


		$this->dataInfo = array(
			'pageController' => 'usuarios',
			'user' => $this->user->getInfo($this->user->getId(), $this->user->getCompany()),
			'tabela' => 'users',
			'filtro' => array(),
			'titlePage' => 'Usuarios'

		);
	}

	public function index()
	{

		if ($this->user->hasPermission('user_view')) {
			if (isset($_GET['filtros'])) {
				$this->dataInfo['filtro'] = $_GET['filtros'];
			}

			$this->dataInfo['p'] = 1;
			if (isset($_GET['p']) && !empty($_GET['p'])) {
				$this->dataInfo['p'] = intval($_GET['p']);
				if ($this->dataInfo['p'] == 0) {
					$this->dataInfo['p'] = 1;
				}
			}

			$offset = (10 * ($this->dataInfo['p'] - 1));

			$this->dataInfo['user_cont'] = 		$this->user->getCountUsuario($this->user->getCompany(), $this->dataInfo['filtro']);
			$this->dataInfo['p_count']   =      ceil($this->dataInfo['user_cont'] / 10);
			$this->dataInfo['tableDados'] =      $this->user->getList($offset, $this->dataInfo['filtro'], $this->user->getCompany());

			$this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
		} else { }
	}


	public function add()
	{

		if (isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {
			$this->dataInfo['errorForm'] = $_SESSION['formError'];
			unset($_SESSION['formError']);
		}
	}

	public function add_action()
	{

		if (isset($_POST['login']) && $_POST['login'] != '') {

			$result = $this->user->add($_POST,$this->user->getCompany());
			$this->addValicao($result);


			header('Location:' . BASE_URL . 'usuario');
			exit();
		}
	}


	public function edit($id)
	{

		if ($this->user->hasPermission('user_view') && $this->user->hasPermission('user_edit')) {

			$this->dataInfo['tableInfo'] = $this->user->getInfo($id, $this->user->getCompany());
			$this->dataInfo['permission'] = $this->permission->getPermissions();
			$this->dataInfo['permission_usuario'] = $this->permission->getPermissionsName($id, $this->user->getCompany());

			if (isset($_POST['login']) && isset($_POST['id_usuario'])) {
				if (!isset($_POST['permission_check'])) { 
					controller::alert('danger','por favor, selecione ao menos um parametro de permissão');
				} else {
					$result = $this->user->edit($this->user->getCompany(), $_POST);
					$this->addValicao($result);

					header('Location:' . BASE_URL . 'usuario');
					exit();
				}
			}


			$this->loadTemplate($this->dataInfo['pageController'] . "/editar", $this->dataInfo);
		} else {

			$this->loadViewError();
		}
	}

	public function delete($id)
	{

		if ($this->user->hasPermission('user_view') && $this->user->hasPermission('user_delet')) {

			$result = $this->user->delete($id, $this->user->getCompany());


			header('Location:' . BASE_URL . 'usuario');
			exit();
		} else {

			$this->loadViewError();
		}
	}


	public function addValicao($result)
	{

		if ($result == 'sucess') {
			$_SESSION['form']['success'] = 'Success';
			$_SESSION['form']['type'] = 'success';
			$_SESSION['form']['mensagem'] = "Efetuado com sucesso!!";
		} elseif ($result == 'error') {
			$_SESSION['form']['success'] = 'Oops!!';
			$_SESSION['form']['type'] = 'error';
			$_SESSION['form']['mensagem'] = "Algo deu Errado, Contate o administrador do sistema";
		}

		return $_SESSION['form'];
	}
}
