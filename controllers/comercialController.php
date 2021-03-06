<?php

class ComercialController extends controller
{

    public function __construct()
    {
        parent::__construct();

        $this->user = new Users();
        $this->comercial = new Comercial('comercial');
        $this->painel = new Painel();
        $this->user->setLoggedUser();

        $this->etapa = new Etapa('etp');

        
        $this->cliente = new Cliente();
        $this->concessionaria = new Concessionaria();
        $this->servico = new Servicos();

        if ($this->user->isLogged() == false) {
            header("Location: " . BASE_URL . "login");
            exit();
        }



        $this->filtro = array();
        $this->dataInfo = array(
            'pageController' => 'comercial',
            'nome_tabela'   => 'comercial',
            'titlePage' => 'comercial'
        );
    }

    public function index()
    {

        if ($this->user->hasPermission('comercial_view')) {

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

            $offset = (10 * ($this->dataInfo['p'] - 1));

            $this->dataInfo['tableDados'] = $this->comercial->getAll($offset, $this->filtro, $this->user->getCompany());
            $this->dataInfo['getCount']   = $this->comercial->getCount($this->user->getCompany());
            $this->dataInfo['p_count']    = ceil($this->dataInfo['getCount'] / 10);

            $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
        } else {
            
            $this->loadViewError();
        }
    }


    public function add()
    {

        if ($this->user->hasPermission('comercial_add')) {

            $this->dataInfo['titlePage'] = 'Cadastro de Proposta';

            $this->dataInfo['clientes'] = $this->cliente->getAll(0,'', $this->user->getCompany());
            $this->dataInfo['concessionaria'] = $this->concessionaria->getAll('', $this->user->getCompany());
            $this->dataInfo['servico'] = $this->servico->getAll('0', '', $this->user->getCompany());

            $this->loadTemplate($this->dataInfo['pageController'] . "/cadastrar", $this->dataInfo);

        } else {
            
            $this->loadViewError();
        }
    }

    public function add_action()
    {

        if (isset($_POST['obra_nome']) && $_POST['obra_nome'] != '') {

            $_POST['valor_proposta'] =  str_replace(' ', '', $_POST['valor_proposta']);

            $result = $this->comercial->add($this->user->getCompany(),$_POST);
            
            header('Location:' . BASE_URL . 'comercial/edit/'.$result);
            exit();

        } else {
            $this->loadViewError();
        }
    }

    public function edit($id)
    {

        if ($this->user->hasPermission('comercial_view') && $this->user->hasPermission('comercial_edit')) {

            $this->dataInfo['tableInfo']            = $this->comercial->getcomercialById($id, $this->user->getCompany());
            $this->dataInfo['compras']              = $this->etapa->getEtapasByTipoByObra($this->dataInfo['tableInfo']['id_obra']);

            if (isset($_POST['nome_obra']) && isset($_POST['id_obra'])) {

                $result = $this->comercial->edit($_POST, $this->user->getCompany());
                
                header('Location:' . BASE_URL . 'comercial/edit/'.$id);
                exit();
            }

            $this->loadTemplate($this->dataInfo['pageController'] . "/editar", $this->dataInfo);

        } else {

            $this->loadViewError();
        }
    }

    public function delete($id)
    {
        if ($this->user->hasPermission('comercial_view') && $this->user->hasPermission('comercial_delete')) {

            $result = $this->comercial->delete($id, $this->user->getCompany());

            header("Location: " . BASE_URL . "comercial");

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

    public function deleteHistorico($id_obra, $id_historico)
    {
        if ($this->user->hasPermission('comercial_view') && $this->user->hasPermission('comercial_delete')) {

            $result = $this->comercial->deleteHistorico($id_obra,$id_historico, $this->user->getCompany());

            header("Location: " . BASE_URL . "comercial/edit/".$id_obra);
            exit();

        } else {
            $this->loadViewError();
        }
    }

    public function deleteEtapa($id_obra, $id_etapa_obra)
    {
        if ($this->user->hasPermission('comercial_view') && $this->user->hasPermission('comercial_delete')) {

            $result = $this->comercial->deleteEtapaObra($id_obra,$id_etapa_obra, $this->user->getCompany());

            header("Location: " . BASE_URL . "comercial/edit/".$id_obra.'?list');
            exit();

        } else {
            $this->loadViewError();
        }
    }


}
