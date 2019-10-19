<?php
class homeController extends controller
{

    private $user;

    public function __construct()
    {
        parent::__construct();


        $this->user = new Users();
        $this->concessionaria = new Concessionaria();
        $this->servico = new Servicos();
        $this->cliente = new Cliente();
        $this->obra = new Obras();
        $this->documento = new Documentos();
        $this->etapa = new Etapa('etapa');
        $this->painel = new Painel;

        $this->user->setLoggedUser();
        $this->dataInfo['errorForm'] = array();

        if ($this->user->isLogged() == false) {

            header("Location: " . BASE_URL . "login");
            exit();
        }

        $this->dataInfo = array(
            'pageController' => 'dashboard',
            'user' => $this->user->getInfo($this->user->getId(), $this->user->getCompany()),
            'titlePage' => 'Dashboard'
        );
    }

    public function index()
    {

        $this->dataInfo['count_obras'] = $this->obra->getCount($this->user->getCompany());
        $this->dataInfo['count_obrasAtivas'] = $this->obra->getCountAtivas($this->user->getCompany());
        $this->dataInfo['count_servico'] = $this->servico->getCount($this->user->getCompany());
        $this->dataInfo['count_cliente'] = $this->cliente->getCount($this->user->getCompany());
        $this->dataInfo['count_concessionaria'] = $this->concessionaria->getCount($this->user->getCompany());

        $this->dataInfo['etapas_pendentes'] = $this->etapa->getPendentes();

        if ($this->user->usr_info() === 'cliente') {

            $this->dataInfo['titlePage'] = 'Bem-vindo';
            $this->dataInfo['tableDados'] = $this->obra->getObraCliente($this->user->cliente(), '', $this->user->getCompany());

            $this->loadTemplate('obrasClientes' . "/index", $this->dataInfo);
        } else {


            $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
        }
    }

    public function visualizar($id)
    {

        if ($this->user->usr_info() === 'cliente') {

            $this->dataInfo['titlePage'] = 'Bem-vindo';
            $this->dataInfo['obr'] = $this->obra->getInfoObraCliente($id, $this->user->getCompany(), $this->user->getIdCliente());

            if ($this->dataInfo['obr']) {

                $this->loadTemplate('obrasClientes' . "/visualizar", $this->dataInfo);
            } else {

                header('Location:' . BASE_URL . 'home');
                controller::alert('warning', 'Essa obra não esta no seu nome');
                exit();
            }
        }
    }
}
