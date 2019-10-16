<?php

class documentosController extends controller
{

    public function __construct()
    {
        parent::__construct();

        $this->user = new Users();
        $this->documento = new Documentos();
        $this->user->setLoggedUser();

        if ($this->user->isLogged() == false) {
            header("Location: " . BASE_URL . "login");
            exit();
        }

        $this->painel = new Painel();
        $this->filtro = array();
        $this->dataInfo = array(
            'pageController' => 'documentos',
            'nome_tabela'   => 'documentos',
            'titlePage' => 'documentos'
            
        );
    }

    public function index()
    {

        if ($this->user->hasPermission('documento_view')) {

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

            $this->dataInfo['tableDados'] = $this->documento->getAll($this->filtro, $this->user->getCompany());
            $this->dataInfo['getCount']   = $this->documento->getCount($this->user->getCompany());
            $this->dataInfo['p_count']    = ceil($this->dataInfo['getCount'] / 10);


            $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
        } else {
            $this->loadViewError();
        }
    }


    public function add()
    {
        if ($this->user->hasPermission('documento_view')) {
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

        if (isset($_POST['docs_nome']) && $_POST['docs_nome'] != '') {

            //$result = $this->painel->insert($_POST, $this->dataInfo['nome_tabela'], $this->user->getCompany());
            $result = $this->documento->add($_FILES, $this->user->getCompany(), '', $_POST['docs_nome']);

            $this->addValicao($result);

            header('Location:' . BASE_URL . $this->dataInfo['pageController']);
            exit();
        } else {
            $this->loadViewError();
        }
    }

    public function edit($id)
    {

        if ($this->user->hasPermission('documento_view') && $this->user->hasPermission('documento_edit')) {

            $this->dataInfo['tableInfo'] = $this->documento->getInfo($id, $this->user->getCompany());

            if (isset($_POST['doc_nome']) && isset($_POST['id'])) {

                $result = $this->painel->edit($_POST, $this->dataInfo['nome_tabela'], $this->user->getCompany());
                $this->addValicao($result);

                header('Location:' . BASE_URL . $this->dataInfo['pageController']);
                exit();
            }
            $this->loadTemplate($this->dataInfo['pageController'] . "/editar", $this->dataInfo);
        } else {

            $this->loadViewError();
        }
    }

    public function delete($id, $id_obra = '', $id_etapa = '')
    {

        if ($this->user->hasPermission('documento_view') && $this->user->hasPermission('documento_delete')) {
            

            if($id_etapa != ''){
                $this->documento->deleteDocFromEtapa($id_etapa, $id);
            }

            $result = $this->documento->delete($id, $this->user->getCompany());

            if($id_obra == ''){
                header("Location: " . BASE_URL . $this->dataInfo['pageController']);
            }else {
                header("Location: " . BASE_URL . 'obras/edit/'. $id_obra);

            }

            

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

    public function importar(){

        if(isset($_POST)){

            $id = [];

            foreach ($_POST['documentos'] as $doc) {
                $id[] = $doc;
            }


            $this->documento->gerarWinrarEmail($id);

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
