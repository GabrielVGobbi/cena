<?php

class concessionariasController extends controller
{

    public function __construct()
    {
        parent::__construct();

        $this->user = new Users();
        $this->concessionaria = new Concessionaria();
        $this->servico = new Servicos();
        $this->documento = new Documentos();
        $this->painel = new Painel();
        $this->etapa = new Etapa('etapa');


        $this->user->setLoggedUser();

        if ($this->user->isLogged() == false) {
            header("Location: " . BASE_URL . "login");
            exit();
        }

        $this->filtro = array();
        $this->dataInfo = array(
            'pageController' => 'concessionarias',
            'nome_tabela'   => 'concessionaria',
            'titlePage' => 'concessionaria'
        );
    }

    public function index()
    {

        if ($this->user->hasPermission('concessionaria_view')) {

            if (isset($_GET['filtros'])) {
                $this->filtro = $_GET['filtros'];
            }

            $this->dataInfo['p'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $this->dataInfo['p'] = intval($_GET['p']);
                if ($this->dataInfo['p'] == 0) {
                    $this->dataInfo['p'] = 1;
                }
            }

            $this->dataInfo['tableDados'] = $this->concessionaria->getAll($this->filtro, $this->user->getCompany());
            $this->dataInfo['getCount']   = $this->concessionaria->getCount($this->user->getCompany());
            $this->dataInfo['p_count']    = ceil($this->dataInfo['getCount'] / 10);

            $this->dataInfo['servico']    = $this->servico->getAll('0', '', $this->user->getCompany());
            $this->dataInfo['documento']  = $this->documento->getAll('', $this->user->getCompany());

            $this->dataInfo['titlePage'] = 'Concessionaria';

            $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
        } else {
            $this->loadViewError();
        }
    }


    public function add()
    {
        if ($this->user->hasPermission('concessionaria_view')) {

            if (isset($_SESSION['formError']) && count($_SESSION['formError']) > 0) {

                $this->dataInfo['errorForm'] = $_SESSION['formError'];
                unset($_SESSION['formError']);
            }

            $this->dataInfo['servico']    = $this->servico->getAll('0', '', $this->user->getCompany());

            $this->dataInfo['titlePage'] = 'Cadastro de Concessionaria';

            $this->loadTemplate($this->dataInfo['pageController'] . "/cadastrar", $this->dataInfo);
        } else {
            $this->loadViewError();
        }
    }

    public function add_action()
    {
        if (isset($_POST['razao_social']) && $_POST['razao_social'] != '') {

            $id = $this->concessionaria->add($this->user->getCompany(), $_POST);

            header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/editService' . '/' . $id . '/' . $_POST['servico']);
            exit();
        } else {
            echo "erro faltando o razao social";
        }
    }

    public function edit($id)
    {


        if ($this->user->hasPermission('concessionaria_view') && $this->user->hasPermission('concessionaria_edit')) {

            $this->dataInfo['tableInfo']                    = $this->concessionaria->getInfo($id, $this->user->getCompany());
            $this->dataInfo['servicos_concessionaria']      = $this->concessionaria->getServicoByConc($id, $this->user->getCompany());
            $this->dataInfo['servico']                      = $this->servico->getAll('0', '', $this->user->getCompany());

            if (isset($_POST['razao_social']) && isset($_POST['id'])) {

                $result = $this->concessionaria->edit($this->user->getCompany(), $_POST, $_FILES);

                $this->addValicao($result);

                header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/edit' . '/' . $id);
                exit();
            }
            $this->loadTemplate($this->dataInfo['pageController'] . "/editar", $this->dataInfo);
        } else {

            $this->loadViewError();
        }
    }

    public function editService($id, $id_servico)
    {


        if ($this->user->hasPermission('concessionaria_view') && $this->user->hasPermission('concessionaria_edit')) {

            
            $this->dataInfo['tableInfo'] = $this->concessionaria->getConcessionariaByService($id, $id_servico, $this->user->getCompany());

            $this->dataInfo['titlePage'] = $this->dataInfo['tableInfo']['razao_social'] . ' x ' . $this->dataInfo['tableInfo']['sev_nome'];

            $this->dataInfo['fluid'] = true;

            if(isset($_POST['nome_etapa'])){
                $this->etapa->edit($this->user->getCompany(), $_POST);

                header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/editService' . '/' . $_POST['id_concessionaria'] . '/' . $_POST['id_servico'] . '?tipo=' . 'compra');
                exit();
                
            }

            $this->loadTemplate($this->dataInfo['pageController'] . "/edit_servico", $this->dataInfo);
        } else {

            $this->loadViewError();
        }
    }


    public function delete($id)
    {

        if ($this->user->hasPermission('concessionaria_view') && $this->user->hasPermission('concessionaria_delete')) {

            $result = $this->concessionaria->delete($id, $this->user->getCompany());

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

    public function delete_etapa($id, $id_concessionaria, $id_servico, $tipo)
    {

        if ($this->user->hasPermission('concessionaria_view') && $this->user->hasPermission('concessionaria_delete')) {

            if ($id != '') {
                $result = $this->etapa->delete($id, $this->user->getCompany());
            }

            header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/editService' . '/' . $id_concessionaria . '/' . $id_servico . '?tipo=' . $tipo);
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

    public function add_etapa($id_concessionaria, $id_servico, $id_etapa, $tipo)
    {

        $id = $this->etapa->addEtapaConcessionariaByService($id_concessionaria, $id_servico, $id_etapa, $tipo);

        header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/editService' . '/' . $id_concessionaria . '/' . $id_servico . '?tipo=' . $tipo);
        exit();
    }

    public function remove_etapa($id_concessionaria, $id_servico, $id_etapa, $tipo)
    {

        $id = $this->etapa->removeEtapaConcessionariaByService($id_concessionaria, $id_servico, $id_etapa);

        header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/editService' . '/' . $id_concessionaria . '/' . $id_servico . '?tipo=' . $tipo);
        exit();
    }

    public function order($id_concessionaria, $id_servico, $id_ord_m, $tipo, $orderType)
    {

        $id = $this->painel->orderItem($orderType,$id_ord_m, $tipo);

        header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/editService' . '/' . $id_concessionaria . '/' . $id_servico . '?tipo=' . $tipo);
        exit();
    }


    public function edit_etapa($id_concessionaria,$id_servico, $tipo )
    {
        if ($this->user->hasPermission('concessionaria_view') && $this->user->hasPermission('concessionaria_edit')) {

            if (isset($_POST['nome_etapa']) && isset($_POST['id_etapa'])) {

                $this->etapa->edit($this->user->getCompany(), $_POST, $_FILES);

                header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/editService' . '/' . $id_concessionaria . '/' . $id_servico . '?tipo=' . $tipo);
                exit();
            }

        } else {

            $this->loadViewError();
        }
    }

    public function duplicarEtapa(){

		$etp = new Etapa('');
        $array = array();
        
        if(isset($_POST)){
            $Parametros = $_POST;
        }

        $etp->duplicarEtapaByServicoxConcessionaria($Parametros);
        
        header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/edit' . '/' . $Parametros['id_concessionaria']);
        exit();
	}
}
