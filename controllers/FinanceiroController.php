<?php

class financeiroController extends controller
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

        $this->painel = new Painel();
        $this->filtro = array();
        $this->dataInfo = array(
            'pageController' => 'obras/financeiro',
            'nome_tabela'   => 'financeiro',
            'titlePage' => 'Financeiro'
            
        );
        $this->financeiro = new Financeiro($this->dataInfo['nome_tabela']);
        $this->obra = new Obras();


    }

    public function index()
    {

        $this->loadTemplate('obras', $this->dataInfo);

    }


    public function obra($id)
    {
        if ($this->user->hasPermission('financeiro_view')) {
            

            $this->dataInfo['tableInfo'] = $this->financeiro->getFinanceirobyObra($id, $this->user->getCompany()); 

            if(count($this->dataInfo['tableInfo']) == 0){
                $_SESSION['form']['success'] = 'Oops!!';
                $_SESSION['form']['type'] = 'error';
                $_SESSION['form']['mensagem'] = "Não consta um financeiro desta obra, deseja criar?";
                $_SESSION['form']['buttons'] = true;
                $_SESSION['form']['id_obra'] = $id;

                
                header('Location:' . BASE_URL . 'obras');
                exit();
            
            }else {
                
                $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
            }
            

        } else {
            $this->loadViewError();
        }
    }

    
    public function edit($id)
    {

        if ($this->user->hasPermission('financeiro_view') && $this->user->hasPermission('documento_edit')) {

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

    public function add($id)
    {

        if ($this->user->hasPermission('financeiro_view') && $this->user->hasPermission('documento_edit')) {

            $this->dataInfo['titlePage'] = 'Cadastro Financeiro/Obra';

            $this->dataInfo['tableInfo'] = $this->obra->getInfo($id, $this->user->getCompany());

            if (isset($_POST['doc_nome']) && isset($_POST['id'])) {

                header('Location:' . BASE_URL . $this->dataInfo['pageController']);
                exit();
            }

            $this->loadTemplate($this->dataInfo['pageController'] . "/cadastrar", $this->dataInfo);
        } else {

            $this->loadViewError();
        }
    }

    public function delete($id)
    {

        if ($this->user->hasPermission('financeiro_view') && $this->user->hasPermission('documento_delete')) {

            $result = $this->documento->delete($id, $this->user->getCompany());

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
