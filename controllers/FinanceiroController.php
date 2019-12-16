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
            
                $this->dataInfo['totalFaturar'] =  intval($faturar) - intval($this->dataInfo['totalFaturado']); 

                
                $this->loadTemplate($this->dataInfo['pageController'] . "/index", $this->dataInfo);
            }
            

        } else {
            $this->loadViewError();
        }
    }


}
