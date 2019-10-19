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
    { }

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


    public function search_categoria()
    {
        $u = new Users();
        $u->setLoggedUser();
        $data = array();

        $id_concessionaria = $_REQUEST['id_concessionaria'];
        $id_servico        = $_REQUEST['id_servico'];

        $a = new Servicos();
        $servico = $a->getEtapas($id_concessionaria, $id_servico);

        foreach ($servico as $citem) {
            $data[] = array(
                'id' => $citem['id'],
                'nome_sub_categoria'   => $citem['etp_nome']
            );
        }

        echo json_encode($data);
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
                    'id'   => $citem['id']
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

            $data['id'] = $a->add($u->getCompany(), $Parametros);
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

            $Parametros['quantidade']       = ( isset($_POST['quantidade'])  ? $_POST['quantidade'] : '' );	
            $Parametros['preco']            = ( isset($_POST['preco'])       ? $_POST['preco'] :      '' );	
            $Parametros['tipo_compra']      = ( isset($_POST['tipo_compra']) ? $_POST['tipo_compra'] : '' );	


            $data['id'] = $a->add($u->getCompany(), $Parametros);
        }

        echo json_encode($data['id']);
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
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $a = new Servicos();
        $Parametros = array();



        if (isset($_POST['id_etapa']) && !empty($_POST['id_etapa'])) {

            $data['id'] = $a->updateEtapa($_POST, $u->getCompany(), $u->getName());
      
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

    public function searchEtapaByTipo(){
        
        $retorno = $this->obra->getEtapas($_GET['id_obra'], $_GET['tipo']);

        echo json_encode($retorno);
        exit;

    }

    public function lerNotificacao(){

        $a = new Notificacao('notificacao');


        if (isset($_POST['id_not_user']) && !empty($_POST['id_not_user'])) {

            $id = $a->ler($_POST['id_not_user'],  $this->id_user);
      
        }

        echo json_encode($id);
        exit;
    }

    public function gerarWinrar(){

        $doc = new Documentos();

        if(isset($_POST['id_obra'])){

            $doc->gerarWinrarObra($_POST['id_obra']);


        }

    }
}
