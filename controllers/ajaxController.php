<?php
class ajaxController extends controller
{

    public function __construct()
    {


        $this->user = new Users();
        $this->user->setLoggedUser();

        if ($this->user->isLogged() == false) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $this->id_user = $this->user->getId();

        $this->retorno = array();
        $this->etapa = new Etapa('Etapa');
        $this->obra = new Obras();
    }

    public function index()
    {
    }

    public function getDocumentoEtapaObra($id_etapa_obra)
    {

        $doc = new Documentos();
        $array = array();
        $array = $doc->getDocumentoEtapaALL($id_etapa_obra);

        echo json_encode($array);
        exit();
    }

    public function search_servico()
    {
        $data = array();
        $u = new Users();
        $a = new Servicos();
        $u->setLoggedUser();


        $servico = $a->getALL('', '', $u->getCompany());

        foreach ($servico as $citem) {
            $data[] = array(
                'name' => $citem['sev_nome'],
                'id'   => $citem['id']
            );
        }



        echo json_encode($servico);
    }

    function deleteVariavelEtapa()
    {

        $u = new Users();
        $u->setLoggedUser();

        $e = new Etapa('');

        $etapa = $e->deleteVariavelEtapa($_POST['id']);

        echo json_encode($etapa);
    }

    function saveNotepad()
    {

        $u = new Users();
        $u->setLoggedUser();

        $notepad = $u->saveNotepad($_POST, $u->getId(), $u->getCompany());

        echo json_encode($notepad);
    }




    public function search_categoria($tipo = false)
    {
        $u = new Users();
        $u->setLoggedUser();
        $data = array();
        $variavel = array();

        $id_concessionaria = $_REQUEST['id_concessionaria'];
        $id_servico        = $_REQUEST['id_servico'];

        $a = new Servicos();

        $servico = $a->getEtapas($id_concessionaria, $id_servico, $tipo);

        foreach ($servico as $citem) {

            if (isset($citem['variavel'])) {
                $variavel = $citem['variavel'];
            } else {
                $variavel = array();
            }

            $data[] = array(
                'id'                    => $citem['id'],
                'nome_sub_categoria'    => $citem['etp_nome'],
                'quantidade'            => $citem['quantidade'],
                'preco'                 => $citem['preco'],
                'tipo_compra'           => $citem['tipo_compra'],
                'variavel'              => $variavel
            );
        }

        echo json_encode($data);
    }


    public function getHistorico($tipo = false)
    {
        $u = new Users();
        $u->setLoggedUser();
        $data = array();

        $id_obra = $_REQUEST['id_obra'];

        $a = new Comercial('comercial');

        $servico = $a->getHistoricoByComercial($id_obra, $u->getCompany());

        foreach ($servico as $citem) {


            $data[] = array(
                'id_historico'      => $citem['histf_id'],
                'etapa_nome'          => $citem['etp_nome'],
                'metodo'            => $citem['metodo'],
                'metodo_valor'      => $citem['metodo_valor'],
                'valor_receber'     => $citem['valor_receber'],


            );
        }

        echo json_encode($data);
    }

    public function getEtapa()
    {
        $u = new Users();
        $u->setLoggedUser();
        $data = array();

        $id_concessionaria = $_REQUEST['id_concessionaria'];
        $id_servico        = $_REQUEST['id_servico'];
        $id_obra        = $_REQUEST['id_obra'];


        $a = new Comercial('comercial');

        $servico = $a->getEtapasComercial($id_concessionaria, $id_servico, $id_obra);

        foreach ($servico as $citem) {

            $data[] = array(
                'id'                    => $citem['id'],
                'nome_sub_categoria'    => $citem['etp_nome']
            );
        }

        echo json_encode($data);
    }

    public function addHistoricoComercial()
    {

        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Comercial('comercial');
        $Parametros = array();

        if (isset($_POST['id_etapa']) && !empty($_POST['id_etapa'])) {

            $data['id'] = $a->addHistoricoComercial($u->getCompany(), $_POST);
        }

        echo json_encode($data['id']);
    }

    public function duplicarEtapa()
    {

        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Etapa('');
        $Parametros = array();


        if (isset($_POST['id_etapa']) && !empty($_POST['id_etapa'])) {

            $data['id'] = $a->duplicarEtapa($u->getCompany(), $_POST);
        }

        echo json_encode($data['id']);
    }

    public function addHistoricoFaturamento()
    {

        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Financeiro('');
        $Parametros = array();

        if (isset($_POST['id_obra']) && !empty($_POST['id_obra'])) {

            $data['id'] = $a->addHistoricoFaturamento($_POST, $u->getCompany(), $u->getId());
        }

        controller::setLog($_POST, 'financeiro', 'faturar');

        echo json_encode($data['id']);
        exit();
    }



    public function searchServicoByConcessionaria()
    {

        $data = array();
        $u = new Users();
        $a = new Servicos();
        $u->setLoggedUser();

        $servicoByConcessionaria = $a->getServicoByConcessionaria($_REQUEST['id_concessionaria']);

        foreach ($servicoByConcessionaria as $citem) {
            $data[] = array(
                'name_sev' => $citem['sev_nome'],
                'id_servico'   => $citem['id_servico']
            );
        }

        echo json_encode($servicoByConcessionaria);
        exit();
    }

    public function valorReceber()
    {


        $data = array();
        $u = new Users();
        $a = new Financeiro('');
        $u->setLoggedUser();

        $etpF = $_REQUEST['q'];

        $receber = $a->getValorReceber($etpF);



        echo json_encode($receber);
    }

    public function search_cliente()
    {
        $data = array();
        $u = new Users();
        $a = new Cliente();
        $u->setLoggedUser();



        if (isset($_GET['q']) && !empty($_GET['q'])) {

            $q = addslashes($_GET['q']);

            $cliente = $a->searchClienteByName($q, $u->getCompany());

            foreach ($cliente as $citem) {
                $data[] = array(
                    'name' => $citem['cliente_nome'],
                    'id'   => $citem['id'],
                    'apelido' => $citem['cliente_apelido']
                );
            }
        }

        echo json_encode($data);
    }

    public function add_cliente()
    {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Cliente();
        $Parametros = array();

        if (isset($_POST['name']) && !empty($_POST['name'])) {


            $Parametros['cliente_nome'] = addslashes($_POST['name']);
            $Parametros['rg'] = '';
            $Parametros['email'] = '';
            $Parametros['cpf'] = '';
            $Parametros['cliente_telefone'] = '';


            $data['id'] = $a->add($Parametros, $u->getCompany());
        }

        echo json_encode($data);
    }

    public function add_etapa()
    {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Etapa('Etapa');
        $Parametros = array();

        if (isset($_POST['nome']) && !empty($_POST['nome'])) {

            $Parametros['nome'] = addslashes($_POST['nome']);
            $Parametros['tipo'] = addslashes($_POST['tipo']);
            $Parametros['id_servico'] = addslashes($_POST['id_servico']);
            $Parametros['id_concessionaria'] = addslashes($_POST['id_concessionaria']);

            $Parametros['quantidade']       = (isset($_POST['quantidade'])  ? $_POST['quantidade'] : '');
            $Parametros['preco']            = (isset($_POST['preco'])       ? $_POST['preco'] : '');
            $Parametros['tipo_compra']      = (isset($_POST['tipo_compra']) ? $_POST['tipo_compra'] : '');


            $data['id'] = $a->add($u->getCompany(), $Parametros);
        } else if (isset($_POST['add_etapa_compra']) && $_POST['add_etapa_compra'] != '') {

            $data['id'] = $a->addEtapaCompra($u->getCompany(), $_POST);
        }

        echo json_encode($data['id']);
        exit;
    }

    public function add_obra()
    {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Comercial('comercial');
        $Parametros = array();

        if ($_POST['id'] && $_POST['id'] != '') {


            $data['id'] = $a->updateStatusComercial($_POST, $u->getCompany());
        }

        echo json_encode($data['id']);
    }

    public function getDepartamentoById()
    {

        $array = array();
        $u = new Users();
        $u->setLoggedUser();

        $cliente = new Cliente();

        if (isset($_POST['id_departamento']) && !empty($_POST['id_departamento'])) {

            $array = $cliente->getDepartamentoById($_POST['id_departamento']);

            echo json_encode($array);
        }
        exit;
    }

    public function verificarMensagem()
    {

        $u = new Users();
        $u->setLoggedUser();
        $array = $u->verificarMensagem($u->getCompany(), $u->getId());


        echo json_encode($array);
        exit;
    }

    public function updateEtapa()
    {
        $data = false;
        $u = new Users();
        $u->setLoggedUser();
        $a = new Servicos();
        $Parametros = array();

        if (isset($_POST['id_etapa']) && !empty($_POST['id_etapa'])) {

            $data = $a->updateEtapa($_POST, $u->getCompany(), $u->getName());
        }

        echo json_encode($data);
        exit;
    }

    public function getIdEtapaObra($id_etapa_obra)
    {

        $u = new Users();
        $u->setLoggedUser();
        $data = array();

        $a = new Etapa('etapa');

        $data = $a->getIdEtapaObra($id_etapa_obra);

        echo json_encode($data);
    }

    public function changeStatusComercial()
    {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Comercial('comercial');
        $Parametros = array();


        if (isset($_POST['id']) && !empty($_POST['id'])) {

            $data['id'] = $a->updateStatusComercial($_POST, $u->getCompany());
        }

        echo json_encode($data['id']);
        exit;
    }


    public function parcialCheck()
    {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Obras();
        $Parametros = array();

        if (isset($_POST['id_etapa']) && !empty($_POST['id_etapa'])) {

            $data['id'] = $a->parcialCheck($_POST);
        }

        echo json_encode($data['id']);
        exit;
    }

    public function faturarEtapa()
    {
        $return = false;
        $u = new Users();
        $u->setLoggedUser();
        $a = new Financeiro('');
        $Parametros = array();


        if (isset($_POST['id_etapa']) && !empty($_POST['id_etapa'])) {

            $return = $a->faturar($_POST['id_etapa'], $_POST['id_obra'], $_POST['id_historico']);
        }

        echo json_encode($return);
        exit;
    }

    public function searchEtapaByName()
    {
        $array = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Etapa('Etapa');
        $Parametros = array();

        if (isset($_POST['id_etapa']) && !empty($_POST['id_etapa'])) {

            $array = $a->searchByName($_POST);
        }

        echo json_encode($array);
        exit;
    }

    public function getEtapas()
    {
        $array = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Obras();
        $Parametros = array();

        if (isset($_REQUEST['id_obra']) && !empty($_REQUEST['id_obra'])) {
            $array = $a->getEtapasByTipoId($_REQUEST['id_obra'], $_REQUEST['tipo']);
        }

        echo json_encode($array);
        exit;
    }

    public function searchEtapaByTipo()
    {

        $retorno = $this->obra->getEtapas($_GET['id_obra'], $_GET['tipo']);

        echo json_encode($retorno);
        exit;
    }

    public function lerNotificacao()
    {

        $a = new Notificacao('notificacao');


        if (isset($_POST['id_not_user']) && !empty($_POST['id_not_user'])) {

            $id = $a->ler($_POST['id_not_user'],  $this->id_user);
        }

        echo json_encode($id);
        exit;
    }

    public function gerarWinrar()
    {

        $doc = new Documentos();

        if (isset($_POST['id_obra'])) {

            $doc->gerarWinrarObra($_POST['id_obra']);
        }
    }

    public function getPreview($id_obra = '', $id_cliente = '')
    {

        $array = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Obras();
        $d = new Documentos();
        $c = new Cliente();

        $id_company = $u->getCompany();

        $Parametros = array();

        $folder_name = 'assets/documentos/';

        if (!empty($id_obra)) {

            //if (!empty($_FILES)) {
            //
            //    $temp_file = $_FILES['file']['tmp_name'];
            //    $location = $folder_name . $_FILES['file']['name'];
            //
            //    move_uploaded_file($temp_file, $location);
            //}
            //
            //if (isset($_POST["name"])) {
            //    $filename = $folder_name . $_POST["name"];
            //    unlink($filename);
            //}

            //$result = array();
            //
            //$files = scandir('assets/documentos/');



            $nome_cliente = $c->getClienteByIdName($id_cliente, $id_company);



            //ADD
            if (!empty($_FILES)) {

                $_FILES['file']['name'] = str_replace('-', '', $_FILES['file']['name']);
                $_FILES['file']['name'] = str_replace(' - ', '_', $_FILES['file']['name']);
                $_FILES['file']['name'] = str_replace(' ', '_', $_FILES['file']['name']);

                $name = $_FILES['file']['name']. '_cli_' . $nome_cliente;

                $type = explode('.', $_FILES['file']['name']);
                $type = '.' . $type[1];

                $d->addByDropeZone($_FILES, $id_company, $id_obra, $name, $type);
            }


            //DELETE 
            if (isset($_POST["name"])) {
                //$filename = $folder_name . $_POST["name"];
                //unlink($filename);
            }


            $Arraydocumento = $d->getDocumentoObra($id_obra, 1);


            if (isset($Arraydocumento) && !empty($Arraydocumento)) {

                foreach ($Arraydocumento as $doc) {
                    $scanDir[] = $doc;
                }
            }

            $output = '<div class="row">';

            if (isset($scanDir) && false !== $scanDir) {

                foreach ($scanDir as $file) {


                    if ('.' !=  $file && '..' != $file) {

                        $type = explode('.', $file['docs_nome']);
                        $type = isset($type[1]) ? mb_strtoupper($type[1], 'UTF-8') : '??';

                        switch ($type) {
                            case 'PDF':
                                $icon =  "fa fa-file-pdf-o";
                                break;
                            case 'XLSX':
                                $icon =  "fa fa-fw fa-file-excel-o";
                                break;
                            case 'DWG':
                                $icon =  "fa fa-fw fa-file-picture-o";
                                break;
                            case 'DOCX':
                                $icon =  "fa fa-fw fa-file-word-o";
                                break;
                            case 'PNG':
                                $icon =  "fa fa-fw fa-file-image-o";
                                break;
                            case 'JPG':
                                $icon =  "fa fa-fw fa-file-image-o";
                                break;
                            default;
                            $icon =  "fa fa-file-pdf-o";
                            break;
                        }

                        $fileName = mb_strimwidth($file['docs_nome'], 0, 90, "...");
                        $output .= '
                            <li>
                                <span class="mailbox-attachment-icon"><i class="' . $icon . '"></i></span>

                                <div class="mailbox-attachment-info"  style="max-width: 29ch;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;">
                                    <a href="' . BASE_URL . 'assets/documentos/' . $file['docs_nome'] . '" target="_blank" class="mailbox-attachment-name">' . $fileName . '</a>
                                    <span class="mailbox-attachment-size">
                                        ' . $type . '
                                        <a download href="' . BASE_URL . 'assets/documentos/' . $fileName . '" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                        <a download onclick="toastAlertDelete(' . $file['id_documento'] . ', ' . $id_obra . ')" class="btn btn-default btn-xs pull-right"><i class="fa fa-trash"></i></a>

                                        </span>
                                </div>
                            </li>
                        ';
                    }
                }
            } else {
                $output .= '<p class="lead">obra sem documento</p>';
            }

            $output .= '</div>';

            echo ($output);
        }
    }

    public function buscarEtapa()
    {

        $data = array();
        $u = new Users();
        $e = new Etapa('etapa');
        $u->setLoggedUser();

        $requestData = $_REQUEST;

        $etapas = $e->getEtapasByTipoAjax($offset = 0, 'COMPRA', $requestData['id_concessionaria'], $requestData['id_servico'], $requestData);
        $total  = $this->etapa->getCountEtapaByTipo('COMPRA', $requestData['id_concessionaria'], $requestData['id_servico']);


        $dados = array();
        foreach ($etapas as $etp) {


            $dado = array();
            $dado[] = "<a type='button' data-toggle='tooltip' title='' data-original-title='Deletar' class='btn btn-danger' href='" . BASE_URL . "concessionarias/delete_etapa/" . $etp['id'] . "/" . $requestData['id_concessionaria'] . "/" . $requestData['id_servico'] . "/compra'><i class='ion ion-trash-a'></i></a>
            <a class='btn btn-info' href='javascript:void(0)' onclick='edit_person(" . $etp['id'] . ")'><i class='glyphicon glyphicon-pencil'></i> </a>

            <a type='button' class='btn btn-primary btn-xs' href='" . BASE_URL . "concessionarias/add_etapa/" . $requestData['id_concessionaria'] . "/" . $requestData['id_servico'] . "/" . $etp['id'] . "/compra'><i class='fa fa-arrow-right'></i> Add</a>
        ";


            $dado[] = $etp["etp_nome"];



            $dados[] = $dado;
        }



        if (isset($requestData['search']['value']) && !empty($requestData['search']['value']) && count($etapas) > 0) {
            $total = $etapas['rowCount'];
        }

        if (count($etapas) == 0) {
            $total = 0;
        }


        $json_data = array(
            "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
            "recordsTotal" => intval($total),  //Quantidade de registros que há no banco de dados
            "recordsFiltered" => intval($total), //Total de registros quando houver pesquisa
            "data" => $dados   //Array de dados completo dos dados retornados da tabela 
        );


        echo json_encode($json_data);
    }

    public function getEtapaComprabyId($id_etapa)
    {

        $u = new Users();
        $u->setLoggedUser();
        $data = array();

        $a = new Etapa('etapa');

        $data = $a->getEtapasById($id_etapa);

        echo json_encode($data);
    }

    public function getVariavelEtapa($id_etapa)
    {

        $u = new Users();
        $u->setLoggedUser();
        $data = array();

        $a = new Etapa('etapa');

        $data = $a->getVariavelEtapa($id_etapa);

        echo json_encode($data);
    }

    public function ValidateClienteDouble()
    {

        $u = new Users();
        $u->setLoggedUser();
        $data = array();

        $a = new Cliente();

        $id = !empty($_POST['id']) ? $_POST['id'] : '';

        $data = $a->validacao($this->user->getCompany(), $_POST['nome'], $id);

        echo json_encode($data);
    }

    public function getHistoricoFaturamento()
    {
        $u = new Users();
        $u->setLoggedUser();
        $data = array();

        $id_obra = $_REQUEST['id_obra'];

        $a = new Financeiro('');

        $hist = $a->getHistoricoFaturamento($id_obra, $u->getCompany());

        foreach ($hist as $citem) {



            $data[] = array(
                'id_historico'      => $citem['histf_id'],
                'coluna_faturamento'        => $citem['coluna_faturamento'],
                'nf_n'            => $citem['nf_n'],
                'data_emissao'      => $citem['data_emissao'],
                'data_vencimento'     => $citem['data_vencimento'],
                'valor'     => $citem['valor'],
                'etp_nome'     => $citem['etp_nome'],
                'recebido_status'     => $citem['recebido_status'],
                'histfa_id' => $citem['histfa_id'],
                'id_etapa_historico_faturamento' => $citem['id_etapa']

            );
        }

        echo json_encode($data);
    }

    public function receberFaturamento()
    {

        $return = false;
        $u = new Users();
        $u->setLoggedUser();
        $a = new Financeiro('');
        $Parametros = array();

        if (isset($_POST['histfa_id']) && !empty($_POST['histfa_id'])) {


            $return = $a->receberFaturamento($_POST['q'], $_POST['histfa_id'], $_POST['id_obra'], $_POST['id_etapa']);
        }

        $Parametros = [
            'historico_faturamento' => $_POST['histfa_id'],
            'valor_recebimento' => $return,
            'edit_by' => $this->user->getId(),
            'edit_date' => date('d-m-Y'),
            'valor' => $return,
        ];

        controller::setLog($Parametros, 'historico_faturamento (financeiro)', 'receber');

        echo json_encode($return);
        exit;
    }
}
