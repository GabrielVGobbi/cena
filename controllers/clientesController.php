<?php

class ClientesController extends controller
{

    public function __construct()
    {
        parent::__construct();

        $this->user = new Users();
        $this->cliente = new Cliente();
        $this->painel = new Painel();
        $this->user->setLoggedUser();

        if ($this->user->isLogged() == false) {
            header("Location: " . BASE_URL . "login");
            exit();
        }



        $this->filtro = array();
        $this->dataInfo = array(
            'pageController' => 'clientes',
            'nome_tabela'   => 'cliente',
            'titlePage' => 'cliente'
        );
    }

    public function index()
    {

        if ($this->user->hasPermission('cliente_view')) {

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

            $this->dataInfo['tableDados'] = $this->cliente->getAll($this->filtro, $this->user->getCompany());
            $this->dataInfo['getCount']   = $this->cliente->getCount($this->user->getCompany());
            $this->dataInfo['p_count']    = ceil($this->dataInfo['getCount'] / 10);


            $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
        } else {
            $this->loadViewError();
        }
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

        if (isset($_POST['cliente_nome']) && $_POST['cliente_nome'] != '') {

            $result = $this->painel->insert($_POST, $this->dataInfo['nome_tabela'], $this->user->getCompany());

            $this->addValicao($result);

            header('Location:' . BASE_URL . 'clientes');
            exit();
        } else {
            $this->loadViewError();
        }
    }

    public function edit($id)
    {

        if ($this->user->hasPermission('cliente_view') && $this->user->hasPermission('cliente_edit')) {

            $this->dataInfo['tableInfo'] = $this->cliente->getClienteById($id, $this->user->getCompany());

            if (isset($_POST['cliente_nome']) && isset($_POST['id'])) {

                $result = $this->painel->edit($_POST, $this->dataInfo['nome_tabela'], $this->user->getCompany());
                
                header('Location:' . BASE_URL . 'clientes');
                exit();
            }
            $this->loadTemplate($this->dataInfo['pageController'] . "/editar", $this->dataInfo);
        } else {

            $this->loadViewError();
        }
    }

    public function add_acesso($id_cliente){

        if ($this->user->hasPermission('cliente_view') && $this->user->hasPermission('cliente_edit')) {

            if (isset($_POST['login']) && isset($_POST['id'])) {

                $result = $this->cliente->addAcessoCliente($_POST,$this->user->getCompany());
                
                header('Location:' . BASE_URL . 'clientes');
                exit();
            }
        } else {

            $this->loadViewError();
        }

    }

    public function desativar($id_cliente){

        if ($this->user->hasPermission('cliente_view') && $this->user->hasPermission('cliente_edit')) {

            

                $result = $this->cliente->desativar($id_cliente,$this->user->getCompany());
                
                header('Location:' . BASE_URL . 'clientes');
                exit();
           
        } else {

            $this->loadViewError();
        }

    }

    public function ativar($id_cliente){

        if ($this->user->hasPermission('cliente_view') && $this->user->hasPermission('cliente_edit')) {

            

                $result = $this->cliente->ativar($id_cliente,$this->user->getCompany());
                
                
                header('Location:' . BASE_URL . 'clientes');
                exit();
           
        } else {

            $this->loadViewError();
        }

    }

    public function delete($id)
    {
        if ($this->user->hasPermission('cliente_view') && $this->user->hasPermission('cliente_delete')) {

            $result = $this->cliente->delete($id, $this->user->getCompany());

            header("Location: " . BASE_URL . "clientes");

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
