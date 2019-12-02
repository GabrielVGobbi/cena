<?php

class obrasController extends controller
{

    public function __construct()
    {
        parent::__construct();

        $this->user = new Users();
        $this->obra = new Obras();
        $this->etapa = new Etapa('Etapa');
        $this->documento = new Documentos();


        $this->cliente = new Cliente();
        $this->concessionaria = new Concessionaria();
        $this->servico = new Servicos();


        $this->location = isset($_COOKIE['obras']) ? $_COOKIE['obras'] : 'obras';


        $this->user->setLoggedUser();

        if ($this->user->isLogged() == false) {
            header("Location: " . BASE_URL . "login");
            exit();
        }

        $this->painel = new Painel();
        $this->filtro = array();
        $this->dataInfo = array(
            'pageController' => 'obras',
            'nome_tabela'   => 'obras',
            'titlePage' => 'obras',
            'filtro' => 'array'
        );
    }

    public function index()
    {
        if ($this->user->hasPermission('obra_view')) {
            $this->dataInfo['concessionaria'] = $this->concessionaria->getAll('', $this->user->getCompany());
            $this->dataInfo['servico'] = $this->servico->getAll('0', '', $this->user->getCompany());
            $this->loadTemplate($this->dataInfo['pageController'] . "/lista", $this->dataInfo);
        } else {
            $this->loadViewError();
        }
    }

    public function getAll()
    {
        $tabela = $this->obra->getAll($_REQUEST, $this->user->getCompany());

        $data = array();

        $output = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" =>  0,
            "data" => $data,
        );


        if ($tabela) {
            foreach ($tabela as $list) {

                $etapa_concluidas = $this->obra->getEtapasConcluidas($list['id_obra']);
                $etapas_total     = count($this->obra->getEtapas($list['id_obra'], ''));


                if ($list['id_obra'] != '') {


                    if (count($this->obra->getEtapas($list['id_obra'], '')) > 0 && $this->obra->getEtapas($list['id_obra'], '')) {

                        $soma = (100) / count($this->obra->getEtapas($list['id_obra'], ''));

                        if ($this->obra->getEtapasConcluidas($list['id_obra']) != 0) {
                            $soma_etapa = $soma * $this->obra->getEtapasConcluidas($list['id_obra']);
                        } else {
                            $soma_etapa = 0;
                        }
                    } else {
                        $soma_etapa = 0;
                    }

                    if ($list['atv'] == 1) {

                        if ($this->user->hasPermission('financeiro_view')) {
                            $buttom = '
                                <a class="btn btn-info btn-sm" href="' . BASE_URL . 'obras/concluir/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-share-alt"></i></a>
                                <a data-toggle="modal" class="btn btn-info btn-sm" href="' . BASE_URL . 'obras/edit/' . $list['id_obra'] . '"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-warning btn-sm" href="' . BASE_URL . 'financeiro/obra/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-bitcoin"></i></a>
                                <a class="btn btn-danger btn-sm" href="' . BASE_URL . 'obras/deleteAlert/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-trash"></i></a>
                            ';
                        } else {
                            $buttom = '
                            <a class="btn btn-info btn-sm" href="' . BASE_URL . 'obras/concluir/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-ok"></i></a>
                            <a data-toggle="modal" class="btn btn-info btn-sm" href="' . BASE_URL . 'obras/edit/' . $list['id_obra'] . '"><i class="fa fa-fw fa-edit"></i></a>
                            <a class="btn btn-danger btn-sm" href="' . BASE_URL . 'obras/deleteAlert/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-trash"></i></a>

                        ';
                        }
                    } else {
                        if ($this->user->hasPermission('financeiro_view')) {
                            $buttom = '
                                <a class="btn bg-navy  btn-sm" href="' . BASE_URL . 'obras/desconcluir/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-share-alt"></i></a>
                                <a data-toggle="modal" class="btn btn-info btn-sm" href="' . BASE_URL . 'obras/edit/' . $list['id_obra'] . '"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-warning btn-sm" href="' . BASE_URL . 'financeiro/obra/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-bitcoin"></i></a>
                                <a class="btn btn-danger btn-sm" href="' . BASE_URL . 'obras/deleteAlert/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-trash"></i></a>
                            ';
                        } else {
                            $buttom = '
                            <a class="btn bg-navy  btn-sm" href="' . BASE_URL . 'obras/desconcluir/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-share-alt"></i></a>
                            <a data-toggle="modal" class="btn btn-info btn-sm" href="' . BASE_URL . 'obras/edit/' . $list['id_obra'] . '"><i class="fa fa-fw fa-edit"></i></a>
                            <a class="btn btn-danger btn-sm" href="' . BASE_URL . 'obras/deleteAlert/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-trash"></i></a>
                        ';
                        }
                    }




                    $row = array();
                    $row[] = $buttom;
                    $row[] = ucfirst($list['obr_razao_social']);
                    $row[] = ucfirst($list['cliente_apelido']);
                    $row[] = ucfirst($list['sev_nome']);
                    $row[] = ucfirst($list['razao_social']);
                    $row[] = ucfirst($list['obra_nota_numero']);
                    $row[] = '
                            <span> ' . $etapa_concluidas . '/' . $etapas_total . ' </span>
                            <div class="progress sm">    
                                <div class="progress-bar progress-bar-green" style="width:  ' . $soma_etapa . '%;"></div>
                            </div>';

                    #$row[] = ($list['cliente_email']);
                    $data[] = $row;
                }
            }

            $total = $this->obra->getCount($this->user->getCompany(), $_REQUEST);

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $total,
                "recordsFiltered" =>  $total,
                "data" => $data,
            );
        }

        echo json_encode($output);
    }



    public function add()
    {
        if ($this->user->hasPermission('obra_view')) {
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

        if (isset($_POST['obra_nome']) && $_POST['obra_nome'] != '') {

            $result = $this->obra->add($_POST, $this->user->getCompany());

            $this->addValicao($result);

            header('Location:' . BASE_URL . $this->location);
            exit();
        } else {
            $this->loadViewError();
        }
    }

    public function edit($id)
    {

        if ($this->user->hasPermission('obra_view') && $this->user->hasPermission('obra_edit')) {

            $this->dataInfo['obr'] = $this->obra->getInfo($id, $this->user->getCompany());


            $this->dataInfo['titlePage'] = $this->dataInfo['obr']['obra_nota_numero'];

            $this->loadTemplate($this->dataInfo['pageController'] . "/editar", $this->dataInfo);
        } else {

            $this->loadViewError();
        }
    }

    public function edit_action()
    {

        if (isset($_POST['obra_nome']) && $_POST['obra_nome'] != '') {

            $result = $this->obra->edit($_POST, $this->user->getCompany(), $_FILES);

            header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/edit/' . $_POST['id']);
            exit();
        } else {

            $this->loadViewError();
        }
    }

    public function delete($id)
    {

        if ($this->user->hasPermission('obra_view') && $this->user->hasPermission('obra_delete')) {


            

            $result = $this->obra->delete($id, $this->user->getCompany());


            header("Location: " . BASE_URL . $this->location);

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

    public function concluir($id)
    {

        if ($this->user->hasPermission('obra_view')) {

            
            $result = $this->obra->concluir($id, $this->user->getCompany());

            //aqui

            header("Location: " . BASE_URL . $this->location);
            exit();
        } else {
            $this->loadViewError();
        }
    }

    public function desconcluir($id)
    {

        if ($this->user->hasPermission('obra_view')) {

            $result = $this->obra->desconcluir($id, $this->user->getCompany());

            header("Location: " . BASE_URL . $this->location);
            exit();
        } else {
            $this->loadViewError();
        }
    }

    public function editEtapaObra($id_etapa_obra)
    {

        if ($this->user->hasPermission('obra_view') && $this->user->hasPermission('obra_delete')) {

            $result = $this->etapa->editEtapaObra($id_etapa_obra, $_POST, $_FILES, $this->user->getCompany(), $this->user->getName());

            header("Location: " . BASE_URL . $this->dataInfo['pageController'] . '/edit/' . $_POST['id_obra'] . '?tipo=' . $_POST['server']);
            exit();
        } else {
            $this->loadViewError();
        }
    }

    public function updateEtapa($id_etapa, $id_obra, $check = true)
    {

        $Parametros = array();
        $Parametros['id_obra'] = $id_obra;
        $Parametros['id_etapa'] = $id_etapa;
        $Parametros['checked'] = $check;
        $Parametros['parcial'] = true;

        $this->servico->updateEtapa($Parametros, $this->user->getCompany(), $this->user->getName());
        $this->etapa->EtapaPull2($Parametros);

        header("Location: " . BASE_URL . $this->dataInfo['pageController'] . '/edit/' . $id_obra . '?tipo=3');
    }

    public function obra_etapa_delete($id_etapa_obra, $id_obra)
    {

        if ($id_etapa_obra != '') {
            $this->etapa->delete_etapa_obra($id_etapa_obra, $this->user->getCompany(), $this->user->getId());
        }

        header("Location: " . BASE_URL . $this->dataInfo['pageController'] . '/edit/' . $id_obra);
        exit();
    }

    public function financeiro($id)
    {
        if ($id != '') {
            if (
                $this->user->hasPermission('obra_view') && $this->user->hasPermission('obra_edit')
                && $this->user->hasPermission('financeiro_view')
            ) {

                $this->dataInfo['tableDados'] = $this->obra->getInfo($id, $this->user->getCompany());

                $this->dataInfo['titlePage'] = $this->dataInfo['obr']['obra_nota_numero'];

                $this->loadTemplate($this->dataInfo['pageController'] . "/financeiro/cadastrar", $this->dataInfo);
            } else {

                $this->loadViewError();
            }
        } else {

            header("Location: " . BASE_URL . $this->location);
            exit();
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

    public function deleteAlert($id_obra)
    {


        $_SESSION['form']['delete'] = 'Tem certeza?';
        $_SESSION['form']['type'] = 'warning';
        $_SESSION['form']['mensagem'] = "Deseja deletar essa obra?";
        $_SESSION['form']['id_obra'] = $id_obra;


        header("Location: " . BASE_URL . $this->location);
        exit();

        return $_SESSION;
    }

    public function gerar($id)
    {
        $this->documento->gerarWinrarObra($id);
    }
    public function Lista()
    {

        if ($this->user->hasPermission('obra_view')) {
            if (isset($_GET['filtros'])) {
                
                $this->dataInfo['filtro']= $_GET;
            }
            $this->dataInfo['p'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $this->dataInfo['p'] = intval($_GET['p']);
                if ($this->dataInfo['p'] == 0) {
                    $this->dataInfo['p'] = 1;
                }
            }
            $this->dataInfo['tableDados'] = $this->obra->getLista($this->dataInfo, $this->user->getCompany());
            
            $this->dataInfo['getCount']   = $this->obra->getCount($this->user->getCompany(),$this->dataInfo);
            
            $this->dataInfo['p_count']    = ceil($this->dataInfo['getCount'] / 10);
            
            $this->dataInfo['clientes'] = $this->cliente->getAll(0, '', $this->user->getCompany());
            
            $this->dataInfo['concessionaria'] = $this->concessionaria->getAll('', $this->user->getCompany());
            
            $this->dataInfo['servico'] = $this->servico->getAll('0', '', $this->user->getCompany());
           
            $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
        
        } else {
            $this->loadViewError();
        }
    }
}
