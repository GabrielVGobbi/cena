<?php
class parametrosController extends controller {

	private $user;

	public function __construct() {
		parent::__construct();
		$UserDashboard = array();

		$this->user = new Users();
		$this->parametro = new Parametros();
		$this->artista = new Artista();
		$this->user->setLoggedUser();
		$this->dataInfo = array();

		if($this->user->isLogged() == false){

			header("Location: ".BASE_URL."login");
			exit();
		}


		$this->dataInfo = array(
			'pageController' => 'parametros',
			'user' => $this->user->getInfo($this->user->getId(), $this->user->getCompany()),

		);
	}

	public function index() {


		$this->dataInfo['getSituacaoAll']    	= $this->parametro->getSituacaoAll();
		$this->dataInfo['getProcedenciaAll']    = $this->parametro->getProcedenciaAll();

		if(isset($_POST['descricao_situacao'])){
			$this->parametro->add($_POST);
			header("Location: ".BASE_URL."parametros");
			exit();
		}


		$this->loadTemplate($this->dataInfo['pageController']."/index", $this->dataInfo);
	}

	public function getDashboardUsuario($UserDashboard) {


	}

}