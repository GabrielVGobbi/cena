<?php

class obrasController extends controller
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

        $this->obra = new Obras();
        $this->etapa = new Etapa('Etapa');
        $this->documento = new Documentos();

        $this->cliente = new Cliente();
        $this->concessionaria = new Concessionaria();
        $this->servico = new Servicos();

        $this->location = isset($_COOKIE['obras']) ? $_COOKIE['obras'] : 'obras';

        $this->type = $this->user->getId() == 63 ? '?tipo=1' : '';


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
            $this->dataInfo['fluid'] = true;
            $this->loadTemplate($this->dataInfo['pageController'] . "/lista", $this->dataInfo);
            
        } else {
            $this->loadViewError();
        }
    }

    public function getAll()
    {

        $tabela = $this->obra->getAll($_REQUEST, $this->user->getCompany(), $this->user->getId());

        $data = array();

        $output = array(
            "draw" => 0,
            "recordsTotal" => 0,
            "recordsFiltered" =>  0,
            "data" => $data,
        );


        if ($tabela) {
            foreach ($tabela as $list) {

                $etapa_concluidas = array();
                $etapa_concluidas = $this->obra->getEtapasConcluidas($list['id_obra']);
                $etapas_total     = count($this->obra->getEtapas($list['id_obra'], ''));



                if ($list['id_obra'] != '') {


                    if ($etapas_total > 0 && $etapas_total) {

                        $soma = (100) / $etapas_total;

                        if ($etapa_concluidas != 0) {
                            $soma_etapa = $soma * $etapa_concluidas;
                        } else {
                            $soma_etapa = 0;
                        }
                    } else {
                        $soma_etapa = 0;
                    }

                    if ($list['atv'] == 1) {

                        if ($this->user->hasPermission('financeiro_view')) {
                            $buttom = '
                                <a class="btn btn-info btn-sm" data-toggle="tooltip" title="" data-original-title="Concluir Obra" href="' . BASE_URL . 'obras/alertSwal/' . $list['id_obra'] . '/concluir"><i class="glyphicon glyphicon-ok"></i></a>
                                <a data-toggle="modal" data-toggle="tooltip" title="" data-original-title="Editar" class="btn btn-info btn-sm" href="' . BASE_URL . 'obras/edit/' . $list['id_obra'] . '"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="" data-original-title="Financeiro" href="' . BASE_URL . 'financeiro/obra/' . $list['id_obra'] . '"><i class="fa fa-fw fa-money"></i></a>
                                <a class="btn btn-danger btn-sm" data-toggle="tooltip" title="" data-original-title="Excluir" href="' . BASE_URL . 'obras/deleteAlert/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-trash"></i></a>
                            ';
                        } else {
                            $buttom = '
                            <a class="btn btn-info btn-sm" data-toggle="tooltip" title="" data-original-title="Concluir Obra" href="' . BASE_URL . 'obras/alertSwal/' . $list['id_obra'] . '/concluir"><i class="glyphicon glyphicon-ok"></i></a>
                            <a data-toggle="modal" class="btn btn-info btn-sm" data-toggle="tooltip" title="" data-original-title="Editar" href="' . BASE_URL . 'obras/edit/' . $list['id_obra'] . '"><i class="fa fa-fw fa-edit"></i></a>
                            <a class="btn btn-danger btn-sm" data-toggle="tooltip" title="" data-original-title="Excluir" href="' . BASE_URL . 'obras/deleteAlert/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-trash"></i></a>

                        ';
                        }
                    } else {
                        if ($this->user->hasPermission('financeiro_view')) {
                            $buttom = '
                            <a class="btn bg-navy  btn-sm" data-toggle="tooltip" title="" data-original-title="Desconcluir Obra" href="' . BASE_URL . 'obras/alertSwal/' . $list['id_obra'] . '/desconcluir"><i class="glyphicon glyphicon-share-alt"></i></a>
                            <a data-toggle="modal" data-toggle="tooltip" title="" data-original-title="Editar" class="btn btn-info btn-sm" href="' . BASE_URL . 'obras/edit/' . $list['id_obra'] . '"><i class="fa fa-fw fa-edit"></i></a>
                            <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="" data-original-title="Financeiro" href="' . BASE_URL . 'financeiro/obra/' . $list['id_obra'] . '"><i class="fa fa-fw fa-money"></i></a>
                            <a class="btn btn-danger btn-sm" data-toggle="tooltip" title="" data-original-title="Excluir" href="' . BASE_URL . 'obras/deleteAlert/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-trash"></i></a>
                            ';
                        } else {
                            $buttom = '
                      

                            <a class="btn bg-navy  btn-sm" data-toggle="tooltip" title="" data-original-title="Desconcluir Obra" href="' . BASE_URL . 'obras/alertSwal/' . $list['id_obra'] . '/desconcluir"><i class="glyphicon glyphicon-ok"></i></a>
                            <a data-toggle="modal" class="btn btn-info btn-sm" data-toggle="tooltip" title="" data-original-title="Editar" href="' . BASE_URL . 'obras/edit/' . $list['id_obra'] . '"><i class="fa fa-fw fa-edit"></i></a>
                            <a class="btn btn-danger btn-sm" data-toggle="tooltip" title="" data-original-title="Excluir" href="' . BASE_URL . 'obras/deleteAlert/' . $list['id_obra'] . '"><i class="glyphicon glyphicon-trash"></i></a>
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

                    $row[] = isset($list['urgencia']) ? $list['urgencia'] : '';
                    $data[] = $row;
                }
            }

            $total = $this->obra->getCount($this->user->getCompany(), $_REQUEST);

            $output = array(
                "draw" => $_REQUEST['draw'],
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

            $this->dataInfo['obr'] = $this->obra->getInfo($id, $this->user->getCompany(),$this->user->getId() );

            if($this->dataInfo['obr'] && count($this->dataInfo['obr'])>0){
                
                $this->dataInfo['departamento_cliente'] = $this->cliente->getDepartamentoClienteById($this->dataInfo['obr']['id_cliente']);

                $this->dataInfo['titlePage'] = $this->dataInfo['obr']['obra_nota_numero'];
    
                $this->loadTemplate($this->dataInfo['pageController'] . "/editar", $this->dataInfo);
            }
            
        } else {

            $this->loadViewError();
        }
    }

    public function edit_action()
    {

        if (isset($_POST['obra_nome']) && $_POST['obra_nome'] != '') {

            $result = $this->obra->edit($_POST, $this->user->getCompany(), $_FILES);
            
            header('Location:' . BASE_URL . $this->dataInfo['pageController'] . '/edit/' . $_POST['id'].$this->type);
            exit();
        } else {

            $this->loadViewError();
        }
    }

    public function delete($id)
    {

        if ($this->user->hasPermission('obra_view') && $this->user->hasPermission('obra_delete')) {

            $result = $this->obra->delete($id, $this->user->getCompany());


            header("Location: " . BASE_URL . $this->location.$this->type);

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

        if ($this->user->hasPermission('obra_edit')) {

            
            $result = $this->obra->concluir($id, $this->user->getCompany());

            //aqui

            header("Location: " . BASE_URL . $this->location.$this->type);
            exit();
        } else {
            $this->loadViewError();
        }
    }

    public function desconcluir($id)
    {

        if ($this->user->hasPermission('obra_edit')) {

            $result = $this->obra->desconcluir($id, $this->user->getCompany());

            header("Location: " . BASE_URL . $this->location.$this->type);
            exit();
        } else {
            $this->loadViewError();
        }
    }

    public function editEtapaObra($id_etapa_obra)
    {

        if ($this->user->hasPermission('obra_view') && $this->user->hasPermission('obra_delete')) {
            
            $result = $this->etapa->editEtapaObra($id_etapa_obra, $_POST, $_FILES, $this->user->getCompany(), $this->user->getName(), $this->user->getId());
        
            echo json_encode($result);
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
            $this->etapa->delete_etapa_obra($id_etapa_obra, $id_obra, $this->user->getCompany(), $this->user->getId());
        }

        header("Location: " . BASE_URL . $this->dataInfo['pageController'] . '/edit/' . $id_obra.$this->type);
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


        $_SESSION['form']['info'] = 'Tem certeza?';
        $_SESSION['form']['type'] = 'warning';
        $_SESSION['form']['mensagem'] = "Deseja deletar essa obra?";
        $_SESSION['form']['id_obra'] = $id_obra;
        $_SESSION['form']['buttom'] = 'delete';

        header("Location: " . BASE_URL . $this->location);
        exit();

        return $_SESSION;
    }

    public function alertSwal($id_obra, $type){
        
        $_SESSION['form']['info'] = 'Tem certeza?';
        $_SESSION['form']['type'] = 'warning';
        $_SESSION['form']['mensagem'] = "Deseja ".$type." essa obra?";
        $_SESSION['form']['id_obra'] = $id_obra;
        $_SESSION['form']['buttom'] = $type;

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
