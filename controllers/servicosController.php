<?php

class servicosController extends controller
{

    public function __construct()
    {
        parent::__construct();

        $this->user = new Users();
        $this->servico = new Servicos();
        $this->user->setLoggedUser();

        if ($this->user->isLogged() == false) {
            header("Location: " . BASE_URL . "login");
            exit();
        }

        $this->painel = new Painel();
        $this->filtro = array();
        $this->dataInfo = array(
            'pageController' => 'servicos',
            'nome_tabela'   => 'servico',
            'titlePage' => 'servicos'

        );
    }

    public function index()
    {

        if ($this->user->hasPermission('servico_view')) {
            
            $this->dataInfo['p'] = 1;
			if (isset($_GET['p']) && !empty($_GET['p'])) {
				$this->dataInfo['p'] = intval($_GET['p']);
				if ($this->dataInfo['p'] == 0) {
					$this->dataInfo['p'] = 1;
				}
            }

            if (isset($_GET['filtros'])) {
                $this->filtro = $_GET['filtros'];
            }

            $offset = (10 * ($this->dataInfo['p'] - 1));

            $this->dataInfo['tableDados'] = $this->servico->getAll($offset,$this->filtro, $this->user->getCompany());
            $this->dataInfo['getCount']   = $this->servico->getCount($this->user->getCompany());
            $this->dataInfo['p_count']    = ceil($this->dataInfo['getCount'] / 10);


            $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
        } else {
            $this->loadViewError();
        }
    }


    public function add()
    {
        if ($this->user->hasPermission('servico_view')) {
            if (isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {

                $this->dataInfo['errorForm'] = $_SESSION['formError'];
                unset($_SESSION['formError']);
            }
        } else {
            $this->loadViewError();
        }
    }

    public function add_action()
    {

        if (isset($_POST['sev_nome']) && $_POST['sev_nome'] != '') {
            
            $validator = $this->servico->validacao($this->user->getCompany(), $_POST['sev_nome']);

            if(!$validator){

                $this->painel->insert_painel($_POST, $this->dataInfo['nome_tabela'], $this->user->getCompany());

            }else {
                controller::alert('warning', 'Já existe uma serviço com esse nome');

            }

            header('Location:' . BASE_URL . $this->dataInfo['pageController']);
            exit();
        } else {
            $this->loadViewError();
        }
    }

    public function edit($id)
    {

        if ($this->user->hasPermission('servico_view') && $this->user->hasPermission('servico_edit')) {

            $this->dataInfo['tableInfo'] = $this->servico->getInfo($id, $this->user->getCompany());

            if (isset($_POST['sev_nome']) && isset($_POST['id'])) {

                $result = $this->painel->edit($_POST, $this->dataInfo['nome_tabela'], $this->user->getCompany());
        

                header('Location:' . BASE_URL . $this->dataInfo['pageController']);
                exit();
            }
            $this->loadTemplate($this->dataInfo['pageController'] . "/editar", $this->dataInfo);
        } else {

            $this->loadViewError();
        }
    }

    public function delete($id)
    {

        if ($this->user->hasPermission('servico_view') && $this->user->hasPermission('servico_delete')) {

            $result = $this->servico->delete($id, $this->user->getCompany());

            header("Location: " . BASE_URL . $this->dataInfo['pageController']);

            if ($result) {
                $this->dataInfo['success'] = 'true';
                $this->dataInfo['mensagem'] = "Exclusão feita com sucesso!!";
            } else {
                $this->dataInfo['error'] = 'true';
                $this->dataInfo['mensagem'] = "Não foi possivel excluir!";
            }
        } else {
            $this->loadViewError();
        }
    }

    public function importar()
    {

        $Parametros = array();

        if (!empty($_FILES['arquivo']['tmp_name'])) {

            $arquivo = new DomDocument();
            $arquivo->load($_FILES['arquivo']['tmp_name']);
            $linhas = $arquivo->getElementsByTagName("Row");

            $primeira_linha = true;

            foreach ($linhas as $linha) {

                if ($primeira_linha == false) {

                    $Parametros['sev_nome']           = $linha->getElementsByTagName("Data")->item(0)->nodeValue;


                    $this->servico->add($Parametros, $this->user->getCompany());
                }

                $primeira_linha = false;
            }
        }

        header('Location:' . BASE_URL . 'servicos');
        exit();
    }
}
