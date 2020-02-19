<?php

class veiculosController extends controller
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

		$this->veiculos = new Veiculos();

		$this->dataInfo = array(
			'pageController' => 'veiculos',
			'tabela' => 'veiculos',
			'filtro' => array(),
			'titlePage' => 'Veiculos'

		);


		$company = new Companies($this->user->getCompany());

		
	}

	public function index()
	{

		if ($this->user->hasPermission($this->dataInfo['pageController'].'_view')) {
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

			$this->veiculos = new Veiculos($offset, $this->dataInfo['filtro']);

			$this->dataInfo['getCount']   = $this->veiculos->row;
			$this->dataInfo['p_count']    = ceil($this->dataInfo['getCount'] / 10);
			$this->dataInfo['tableDados'] = $this->veiculos->veiculoInfo;

			$this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);

		} else { }
	}

	public function edit($id_veiculo)
	{

		if ($this->user->hasPermission($this->dataInfo['pageController'].'_edit')) {	

			$this->veiculos = new Veiculos('','',$id_veiculo);

			$this->dataInfo['tableInfo'] = $this->veiculos->veiculoInfo;

			error_log(print_r($this->dataInfo['tableInfo'],1));

			$this->loadTemplate($this->dataInfo['pageController'] . "/editar", $this->dataInfo);

		} else { }
	}

}
