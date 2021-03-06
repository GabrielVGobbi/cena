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

                $this->dataInfo['etapasFinanceiro'] = $this->financeiro->getEtapasFinanceiro($id);

                $faturar = $this->financeiro->totalFaturamento($id, $this->user->getCompany(), FATURAR);

                $this->dataInfo['totalFaturado'] = $this->financeiro->totalFaturado($id, $this->user->getCompany(), FATURADO);
            
                $this->dataInfo['totalFaturar'] =  intval($faturar);

                $this->dataInfo['recebido'] = $this->financeiro->totalFaturado($id, $this->user->getCompany(), RECEBIDO);


                $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
            }
            

        } else {
            $this->loadViewError();
        }
    }

    public function deleteHistoricoFaturamento($id_historico, $id_his, $id_obra){

        if ($this->user->hasPermission('financeiro_view')) {

            
            $result = $this->financeiro->deleteHistoricoFaturamento($id_historico, $this->user->getId(), $id_obra);
            
            header("Location: " . BASE_URL . "financeiro/obra/".$id_obra.'?hist='.$id_his);
            exit();

        } else {
            $this->loadViewError();
        }

    }

    public function add($id_obra = 0)
    {

        if ($this->user->hasPermission('financeiro_view')) {
            
            $this->dataInfo['titlePage'] = 'Financeiro Adicionar';

            $this->dataInfo['id_obra'] = $id_obra != 0 ? $id_obra : '0';

            if($this->dataInfo['id_obra'] != 0){
                $verify = $this->financeiro->verifyFinanceiroObra($id_obra);

                if($verify){
                    header('Location:' . BASE_URL . $this->dataInfo['nome_tabela'].'/obra/'.$this->dataInfo['id_obra']);
                    exit(); 
                }
            }

            $this->dataInfo['obras'] = $this->obra->getAllByClear($this->user->getCompany());

            $this->loadTemplate($this->dataInfo['pageController'] . "/cadastrar", $this->dataInfo);

        } else {
            $this->loadViewError();
        }   

    }

    public function add_action(){
        
        if (isset($_POST['id_obra']) && $_POST['id_obra'] != '') {

            $verify = $this->financeiro->verifyFinanceiroObra($_POST['id_obra']);

            if($verify){
                header('Location:' . BASE_URL . $this->dataInfo['pageController'].'/obra/'.$_POST['id_obra']);
                exit(); 
            }

            $result = $this->financeiro->add($this->user->getCompany(), $_POST);

            header('Location:' . BASE_URL . 'comercial/edit/'.$_POST['id_obra']);
            exit();
        
        } else {
            
            $this->loadViewError();
        }
    }

    




}
