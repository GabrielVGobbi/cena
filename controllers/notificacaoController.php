<?php

class NotificacaoController extends controller
{

    public function __construct()
    {
        parent::__construct();

        $this->user = new Users();
        $this->notificacao = new Notificacao('notificacoes');
        $this->painel = new Painel();
        $this->user->setLoggedUser();

        if ($this->user->isLogged() == false) {
            header("Location: " . BASE_URL . "login");
            exit();
        }



        $this->filtro = array();
        $this->dataInfo = array(
            'pageController' => 'notificacao',
            'nome_tabela'   => 'notificacoes',
            'titlePage' => 'Notificações'
        );
    }

    public function index()
    {

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

        $this->dataInfo['tableDados'] = $this->notificacao->getAll($this->filtro, $this->user->getCompany(), $this->user->getId());
        $this->dataInfo['getCount']   = $this->notificacao->getCount($this->user->getCompany());
        $this->dataInfo['p_count']    = ceil($this->dataInfo['getCount'] / 10);

        $this->dataInfo['toDo'] = $this->notificacao->getAllTodoByUsuario($this->user->getId());


        $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
    }
   
    public function lertudo()
    {

        $this->notificacao->LerTudo($this->user->getId());
        header("Location: " . BASE_URL . $this->dataInfo['pageController']);
        exit();


    }
}
