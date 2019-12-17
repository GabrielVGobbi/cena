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
            LEFT JOIN cliente_endereco clie ON (cle.clend_id = clie.id_endereco)
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
                die();
                error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
            }
        } else {
            controller::alert('danger', 'Não foi selecionado nada!!');
        }
    }

    public function getEtapasFinanceiro($id_obra)
    {


        $sql = $this->db->prepare("
            SELECT obrt.check, obrt.id_etapa, obrt.etp_nome_etapa_obra, obrt.id_status, hfo.* FROM obra_etapa obrt
                INNER JOIN historico_financeiro hfo ON (obrt.id_etapa = hfo.id_etapa)
            WHERE hfo.id_obra = :id_obra AND obrt.id_obra = :id_obra GROUP BY obrt.id_etapa
        ");
        $sql->bindValue('id_obra', $id_obra);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $this->retorno = $sql->fetchAll();
        }

        return $this->retorno;
    }

    public function totalFaturamento($id_obra, $id_company, $status)
    {

        $r = 0;
        $sql = $this->db->prepare("SELECT SUM(valor_receber) AS c FROM historico_financeiro WHERE id_company = :id_company AND id_obra = :id_obra AND (histf_id_status = {$status} OR histf_id_status = 7)");
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':id_obra', $id_obra);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
        }

        $r = $row['c'];
        return $r;
    }

    public function totalFaturado($id_obra, $id_company, $status)
    {

        $r = 0;

        if ($status == RECEBIDO) {
            $sql = $this->db->prepare("SELECT SUM(valor) AS c FROM historico_faturamento histf WHERE id_company = :id_company AND id_obra = :id_obra AND recebido_status = :recebido_status ");
            $sql->bindValue(':id_company', $id_company);
            $sql->bindValue(':id_obra', $id_obra);
            $sql->bindValue(':recebido_status', 1);


            $sql->execute();

            if ($sql->rowCount() > 0) {
                $row = $sql->fetch();
            }

            $r = $row['c'];

            return $r;
        }else {
            $sql = $this->db->prepare("SELECT SUM(valor) AS c FROM historico_faturamento histf WHERE id_company = :id_company AND id_obra = :id_obra AND histf.status <> 1");
            $sql->bindValue(':id_company', $id_company);
            $sql->bindValue(':id_obra', $id_obra);
    
            $sql->execute();
    
            if ($sql->rowCount() > 0) {
                $row = $sql->fetch();
            }
    
            $r = $row['c'];
    
            return $r;
        }

        
    }

    public function faturar($id_etapa, $id_obra, $id_historico)
    {

        $status = FATURADO;


        $sql = $this->db->prepare("UPDATE historico_financeiro histf SET

                histf.histf_id_status 		= :id_status

			WHERE (id_etapa = :id) AND (id_obra = :id_obra) AND (histf.histf_id = :id_historico)

		");

        $sql->bindValue(':id',   $id_etapa);
        $sql->bindValue(':id_obra',   $id_obra);
        $sql->bindValue(':id_historico',   $id_historico);
        $sql->bindValue(':id_status',   $status);
        $sql->execute();


        $sql = $this->db->prepare("
            
            UPDATE obra_etapa obr SET

			obr.id_status 		= :id_status

			WHERE (id_etapa = :id) AND (id_obra = :id_obra)

		");

        $sql->bindValue(':id',   $id_etapa);
        $sql->bindValue(':id_obra',   $id_obra);
        $sql->bindValue(':id_status',   $status);

        return $sql->execute() ? true : false;
    }

    public function addHistoricoFaturamento($Parametros, $id_company, $id_usuario)
    {

        $histfa_id_status = FATURADO;

        $id_obra                    = $Parametros['id_obra'];
        $id_historico_financeiro    = $Parametros['id'];
        $coluna_faturamento         = $Parametros['coluna'];
        $nf_n                       = $Parametros['nf_n'];
        $data_vencimento            = $Parametros['data_vencimento'];
        $data_emissao               = $Parametros['data_emissao'];
        $valor_faturamento          = $Parametros['valor_faturamento'];
        $id_etapa                   = $Parametros['id_etapa'];
        $data_value                   = $Parametros['data_value'];



        try {
            $sql = $this->db->prepare("INSERT INTO historico_faturamento SET 
                
                id_company          = :id_company,
                histfa_id_status    = :histfa_id_status,
                id_usuario          = :id_usuario,
                id_obra          = :id_obra,
                coluna_faturamento  = :coluna_faturamento,
                nf_n 		        = :nf_n,
                data_emissao        = :data_emissao,
                data_vencimento     = :data_vencimento,
                valor               = :valor,
                histf_id            = :histf_id, 
                valor_receber       = :data_value

            ");

            $sql->bindValue(":histfa_id_status",    $histfa_id_status);
            $sql->bindValue(":id_usuario",          $id_usuario);
            $sql->bindValue(":id_company",          $id_company);
            $sql->bindValue(":id_obra",          $id_obra);
            $sql->bindValue(":coluna_faturamento",  $coluna_faturamento);
            $sql->bindValue(":nf_n",                $nf_n);
            $sql->bindValue(":data_emissao",        $data_emissao);
            $sql->bindValue(":data_vencimento",     $data_vencimento);
            $sql->bindValue(":valor",               $valor_faturamento);
            $sql->bindValue(":histf_id",            $id_historico_financeiro);
            $sql->bindValue(":data_value",          $data_value);

            $sql->execute();


            $histfa_id = $this->db->lastInsertId();

            $atualizar = $this->verify($histfa_id);

            if ($atualizar == '0') {
                $this->faturar($id_etapa, $id_obra, $id_historico_financeiro);
            }

            #return $sql->execute() ? true : false;
            $this->db = null;
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }
    }

    public function getHistoricoFaturamento($id_obra, $id_company)
    {

        $sql = "
		SELECT * FROM  
            historico_faturamento histfa
        INNER JOIN historico_financeiro histf ON (histf.histf_id = histfa.histf_id)
        INNER JOIN etapa etp ON (etp.id = histf.id_etapa)
			
		WHERE histfa.id_obra = :id_obra AND histfa.id_company = :id_company AND histfa.status <> 1";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id_obra",               $id_obra);
        $sql->bindValue(":id_company",            $id_company);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $this->array = $sql->fetchAll();
        }
        return $this->array;
    }

    public function getValorReceber($histf_id)
    {

        $r = 0;
        $sql = $this->db->prepare("SELECT valor_receber AS c FROM historico_faturamento histf WHERE histf_id = :histf_id AND histf.status <> 1 ORDER BY histfa_id DESC LIMIT 1");
        $sql->bindValue(':histf_id', $histf_id);
        $sql->execute();

        if ($sql->rowCount() == 1) {
            $row = $sql->fetch();

            $r = $row['c'];
        } else {

            $sql = $this->db->prepare("SELECT valor_receber AS c FROM historico_financeiro histf WHERE histf_id = :histf_id LIMIT 1");
            $sql->bindValue(':histf_id', $histf_id);
            $sql->execute();

            if ($sql->rowCount() == 1) {
                $row = $sql->fetch();

                $r = $row['c'];
            }
        }

        return $r;
    }

    public function verify($histfa_id)
    {

        $r = 0;
        $sql = "
		SELECT valor_receber AS c FROM  
            historico_faturamento histfa
       
		WHERE histfa.histfa_id = :histfa_id AND histfa.status <> 1 ";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(":histfa_id", $histfa_id);


        $sql->execute();

        if ($sql->rowCount() == 1) {
            $row = $sql->fetch();

            $r = $row['c'];
        }


        return $r;
    }

    public function getPendentesFinanceiroALL()
    {

        $sql = $this->db->prepare("
            SELECT hist.*, etp.etp_nome, obr.obr_razao_social,obr.id as id_obra FROM historico_financeiro hist 
            INNER JOIN etapa etp ON (etp.id = hist.id_etapa)
            INNER JOIN obra obr ON(obr.id = hist.id_obra)
            WHERE histf_id_status = :histfa_id
        ");

        $sql->bindValue(":histfa_id", FATURAR);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $this->retorno = $sql->fetchAll();
        }
        return $this->retorno;
    }

    public function getTotalFinanceiroAll()
    {

        $r = 0;

        $sql = $this->db->prepare("SELECT SUM(valor_receber) AS count FROM historico_financeiro WHERE histf_id_status = :histf_id_status");
        $sql->bindValue(':histf_id_status', FATURAR);
        $sql->execute();



        $row = $sql->fetch();
        $r = $row['count'];

        return $r;
    }

    public function receberFaturamento($valor, $histfa_id, $id_obra, $id_etapa)
    {

        $valor = $valor == 1 ? '0' : '1';

        $sql = $this->db->prepare("
            
            UPDATE historico_faturamento  SET

			recebido_status = :recebido_status

			WHERE (histfa_id = :histfa_id)

		");

        $sql->bindValue(':histfa_id',   $histfa_id);
        $sql->bindValue(':recebido_status',   $valor);

        $sql->execute() ? $valor : false;

        if ($valor == 1) {
            $sql = $this->db->prepare("UPDATE obra_etapa obr SET

                obr.id_status 		= :id_status

                WHERE (id_etapa = :id) AND (id_obra = :id_obra)
            ");

            $sql->bindValue(':id',   $id_etapa);
            $sql->bindValue(':id_obra',   $id_obra);
            $sql->bindValue(':id_status',   RECEBIDO);

            return $sql->execute() ? $valor : false;
        } else {
            $sql = $this->db->prepare("UPDATE obra_etapa obr SET

            obr.id_status 		= :id_status

            WHERE (id_etapa = :id) AND (id_obra = :id_obra)
        ");

            $sql->bindValue(':id',   $id_etapa);
            $sql->bindValue(':id_obra',   $id_obra);
            $sql->bindValue(':id_status',   FATURADO);

            return $sql->execute() ? $valor : false;
        }
    }
    public function deleteHistoricoFaturamento($id_historico, $id_user, $id_obra)
    {

        $Parametros = [
            'id_historico' => $id_historico,
            'deleteBy' => $id_user,
            'deleteDate' => date('d-m-Y'),
        ];
        $sql = $this->db->prepare("UPDATE historico_faturamento histf SET histf.status = 1 WHERE histf.id_obra = :id_obra AND histf.histfa_id = :id_historico");

        $sql->bindValue(":id_obra", $id_obra);
        $sql->bindValue(":id_historico", $id_historico);

        if ($sql->execute()) {

            controller::alert('danger', 'Lançamento deletado com sucesso!!');
            controller::setLog($Parametros, 'historico_lançamento', 'delete');
            //$this->deleteEtapasObras($id);

            $sql = null;
        } else {
            controller::alert('error', 'não foi possivel deletar o lançamento');
        }
    }
}
