<?php

class Financeiro extends model
{

    public function __construct($nomeTabela)
    {
        parent::__construct();

        $this->array = array();
        $this->retorno = array();

        $this->notificacao = new Notificacao('notificacoes');
        $this->painel = new Painel();

        $this->tabela = $nomeTabela;
    }


    public function getFinanceirobyObra($id_obra, $id_company)
    {

        $sql = $this->db->prepare("SELECT * FROM financeiro_obra fino
            INNER JOIN obra obr ON (obr.id = fino.id_obra) 
            INNER JOIN servico sev ON(obr.id_servico = sev.id)
            INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
            INNER JOIN concessionaria con ON(con.id = obr.id_concessionaria)
            WHERE fino.id_obra = :id_obra
            AND fino.id_company = :id_company
        ");

        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":id_obra", $id_obra);
        $sql->execute();

        if ($sql->rowCount() == 1) {
            $this->array = $sql->fetch();
        }

        return $this->array;
    }

    public function edit($id_company, $Parametros)
    {
        $tipo = 'Editado';

        $etp_nome = $Parametros['nome_etapa'];
        $id_etapa  = $Parametros['id_etapa'];

        if (isset($id_etapa) && $id_etapa != '') {
            try {

                $sql = $this->db->prepare("UPDATE etapa SET 
					
					etp_nome = :etp_nome

					WHERE id = :id_etapa
	        	");

                $sql->bindValue(":etp_nome", $etp_nome);
                $sql->bindValue(":id_etapa", $id_etapa);

                if ($sql->execute()) {
                    controller::alert('success', 'Editado com sucesso!!');
                } else {
                    controller::alert('danger', 'Erro ao fazer a edição!!');
                }
            } catch (PDOExecption $e) {

                $sql->rollback();
                error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
            }
        } else {
            controller::alert('danger', 'Não foi selecionado nada!!');
        }
    }

    public function getEtapasFinanceiro($id_obra){

        $sql = $this->db->prepare("
            SELECT obrt.check, obrt.id_etapa, obrt.etp_nome_etapa_obra, obrt.id_status, hfo.* FROM obra_etapa obrt
                INNER JOIN historico_financeiro hfo ON (obrt.id_etapa = hfo.id_etapa)
            WHERE hfo.id_obra = :id_obra and obrt.id_obra = :id_obra GROUP BY obrt.id_etapa
        ");
        $sql->bindValue('id_obra', $id_obra);
    
        $sql->execute();

        if($sql->rowCount() > 1){
            $this->retorno = $sql->fetchAll();
        }

        return $this->retorno;

    }
}
