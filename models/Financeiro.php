<?php

class Financeiro extends model
{

    private $dados;

    public function __construct($nomeTabela)
    {
        parent::__construct();

        $this->array = array();
        $this->retorno = array();

        $this->notificacao = new Notificacao('notificacoes');
        $this->painel = new Painel();

        $this->tabela = $nomeTabela;
    }
    

    public function getAllCountFinanceiroObra($filtro,$id_company)
    {
        $where = $this->buildWhere($filtro, $id_company);
        $r = 0;
        $sql = $this->db->prepare("  SELECT COUNT(obr.id) as c FROM financeiro_obra fin
            INNER JOIN obra obr ON (obr.id = fin.id_obra) WHERE " . implode(' AND ', $where) 
        );
        $this->bindWhere($filtro, $sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
        }

        $r = $row['c'];

        return $r;
    }


    public function getFinanceirobyObra($id_obra, $id_company)
    {

        $sql = $this->db->prepare("SELECT * FROM financeiro_obra fino
            INNER JOIN obra obr ON (obr.id = fino.id_obra) 
            INNER JOIN servico sev ON(obr.id_servico = sev.id)
            INNER JOIN cliente cle ON(cle.id = obr.id_cliente)
            LEFT JOIN obra_endereco obre ON (obr.id_endereco_obra = obre.id_obra_endereco)
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

    public function getAllObrasFinanceiro($id_company, $offset = 0, $filtro = array())
    {
		$where = $this->buildWhere($filtro, $id_company);

        $sql = $this->db->prepare("
            SELECT fin.valor_negociado,obr.obr_razao_social,obr.id as id_obra FROM financeiro_obra fin
            INNER JOIN obra obr ON (obr.id = fin.id_obra) WHERE " . implode(' AND ', $where) . " ORDER BY obr.obr_razao_social 
        ");

		$this->bindWhere($filtro, $sql);

        $sql->execute();
        $total_receber = 0;
        if ($sql->rowCount() > 0) {
            $obrT = array();
            $this->dados = $sql->fetchAll();

            foreach ($this->dados as $obr) {

                $obr['recebido'] = 0;
                $obr['faturar']  = 0;
                $obr['receber']  = 0;
                $obr['faturado'] = 0;

                $id_obra = $obr['id_obra'];

                $obr['recebido'] += $this->totalFaturado($id_obra, 1, RECEBIDO);
                $obr['faturar'] += $this->totalFaturamento($id_obra, 1, FATURAR);
                $obr['receber'] += $this->totalReceber($id_obra);
                $obr['faturado'] += $this->totalFaturado($id_obra, 1, FATURADO);

                $obrT[] = $obr;
            }

            $this->dados = $obrT;
        }

        return $this->dados;
    }

    public function getHistoricoFaturamentoBySearch($id_company, $offset, $filtro){

        $where = $this->buildWhere($filtro, $id_company);

        $sql = $this->db->prepare("
            SELECT * FROM historico_faturamento histfa
            INNER JOIN obra obr ON (obr.id = histfa.id_obra) WHERE " . implode(' AND ', $where) . " ORDER BY obr.obr_razao_social LIMIT {$offset}, 10 
        ");

		$this->bindWhere($filtro, $sql);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $obrT = array();
            $this->dados = $sql->fetchAll();

        }

        return $this->dados;

    }


    public function getAllCountFaturamento ($filtro, $id_company)
    {

        $where = $this->buildWhere($filtro, $id_company);

        $r = 0;
        $sql = $this->db->prepare("  
            SELECT COUNT(histfa.histfa_id) as c FROM historico_faturamento histfa
            INNER JOIN obra obr ON (obr.id = histfa.id_obra) WHERE " . implode(' AND ', $where)
        );
		$this->bindWhere($filtro, $sql);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
        }

        $r = $row['c'];

        return $r;
    }

    private function buildWhere($filtro, $id)
	{
		$where = array(
			'obr.id_company=' . $id,
			'obr.id_status=3',
			'obr.atv<>2'
		);

		if (!empty($filtro['nome_obra'])) {
			if ($filtro['nome_obra'] != '') {
				$where[] = "obr.obr_razao_social LIKE :nome_obra";
			}
        }
        
        if (!empty($filtro['nf_n'])) {
			if ($filtro['nf_n'] != '') {
				$where[] = "histfa.nf_n LIKE :nf_n";
			}
		}

		return $where;
	}

	private function bindWhere($filtro, &$sql)
	{

		if (!empty($filtro['nome_obra'])) {
			if ($filtro['nome_obra'] != '') {
				$sql->bindValue(":nome_obra", '%' . $filtro['nome_obra'] . '%');
			}
        }
        
        if (!empty($filtro['nf_n'])) {
			if ($filtro['nf_n'] != '') {
				$sql->bindValue(":nf_n", '%' . $filtro['nf_n'] . '%');
			}
		}
		
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
        $faturar = 0;
        $r = 0;

        if ($status == FATURAR) {

            $sql = $this->db->prepare("SELECT * FROM historico_financeiro where histf_id_status = 6 AND id_obra = :id_obra AND id_company = :id_company");
            $sql->bindValue(':id_company', $id_company);
            $sql->bindValue(':id_obra', $id_obra);
            $sql->execute();

            if ($sql->rowCount() > 0) {

                $sql->execute();
                $ArrayFinanceiro = $sql->fetchALL();

                foreach ($ArrayFinanceiro as $fin) {
                    $r = 0;
                    $histf_id = $fin['histf_id'];

                    $valor_receber = $fin['valor_receber'];

                    $sql = $this->db->prepare("SELECT SUM(valor) as faturar FROM historico_faturamento WHERE histf_id = {$histf_id} AND status <> 1");
                    $sql->execute();
                    if ($sql->rowCount() == 1) {
                        $row = $sql->fetch();
                        $r = $row['faturar'];
                    }

                    $faturar += $valor_receber - $r;
                }
                return $faturar;
            }
        } else {

            $r = 0;
            $sql = $this->db->prepare("SELECT SUM(valor_receber) AS c FROM historico_financeiro WHERE id_company = :id_company AND id_obra = :id_obra AND (histf_id_status = {$status})");
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

    public function totalReceber($id_obra)
    {


        $r = 0;
        $sql = $this->db->prepare("SELECT SUM(valor) as c FROM historico_faturamento hisfat WHERE id_obra = :id_obra AND recebido_status = 0 AND hisfat.status <> 1");
        $sql->bindValue(':id_obra', $id_obra);
        $sql->execute();

        if ($sql->rowCount() == 1) {
            $row = $sql->fetch();
        }

        $r = $row['c'];

        return $r;
    }

    public function totalTudo($id_company)
    {

        $somaTotal = [
            'recebido' => 0,
            'valor_negociado' => 0,
            'valor_receber' => 0,
            'liberado_a_faturar' => 0,
            'saldo' => 0,
            'faturar' => 0,
            'faturado' => 0

        ];
        //faturado
        $sql = $this->db->prepare("SELECT SUM(valor) AS c FROM historico_faturamento histf WHERE id_company = :id_company AND histf.status <> 1 ");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
            $faturado = $row['c'];
            $somaTotal['faturado'] = controller::number_format($row['c']);
        }

        //recebido
        $sql = $this->db->prepare("SELECT SUM(valor) AS c FROM historico_faturamento histf WHERE id_company = :id_company AND recebido_status = '1' AND histf.status <> 1 ");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
            $somaTotal['recebido'] = controller::number_format($row['c']);
        }

        //a receber
        $sql = $this->db->prepare("SELECT SUM(valor) as c FROM historico_faturamento hisfat WHERE  recebido_status = 0 AND hisfat.status <> 1");
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
            $somaTotal['valor_receber'] = controller::number_format($row['c']);
        }

        //faturar 
        $sql = $this->db->prepare("SELECT * FROM historico_financeiro where histf_id_status = 6 AND id_company = :id_company");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();
        $faturar = 0;
        if ($sql->rowCount() > 0) {

            $sql->execute();
            $ArrayFinanceiro = $sql->fetchALL();

            foreach ($ArrayFinanceiro as $fin) {
                $r = 0;
                $histf_id = $fin['histf_id'];

                $valor_receber = $fin['valor_receber'];

                $sql = $this->db->prepare("SELECT SUM(valor) as faturar FROM historico_faturamento WHERE histf_id = {$histf_id} AND status <> 1");
                $sql->execute();
                if ($sql->rowCount() == 1) {
                    $row = $sql->fetch();
                    $r = $row['faturar'];
                }

                $faturar += $valor_receber - $r;
            }

            $somaTotal['faturar'] = controller::number_format($faturar);
        }


        //valor de todos negociado
        $sql = $this->db->prepare("SELECT SUM(valor_negociado) as c FROM financeiro_obra fin
        INNER JOIN obra obr ON (obr.id = fin.id_obra) WHERE obr.id_status = 3 AND obr.atv<>2 AND obr.id_company = :id_company");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();

            $somaTotal['saldo'] = controller::number_format(($row['c'] - $faturado));

            $somaTotal['valor_negociado'] = controller::number_format($row['c']);


        }




        return $somaTotal;
    }

    public function totalFaturado($id_obra, $id_company, $status)
    {

        $r = 0;


        if ($status == RECEBIDO) {
            $sql = $this->db->prepare("SELECT SUM(valor) AS c FROM historico_faturamento histf WHERE id_company = :id_company AND id_obra = :id_obra AND recebido_status = :recebido_status AND histf.status <> 1 ");
            $sql->bindValue(':id_company', $id_company);
            $sql->bindValue(':id_obra', $id_obra);
            $sql->bindValue(':recebido_status', 1);


            $sql->execute();

            if ($sql->rowCount() > 0) {
                $row = $sql->fetch();
            }

            $r = $row['c'];




            return $r;
        } else {
            $sql = $this->db->prepare("SELECT SUM(valor) AS c FROM historico_faturamento histf WHERE id_company = :id_company AND id_obra = :id_obra AND histf.status <> 1 ");
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

        try {
            $sql = $this->db->prepare("
                
                UPDATE obra_etapa obr SET

                obr.id_status 		= :id_status

                WHERE (id_etapa = :id) AND (id_obra = :id_obra)

            ");

            $sql->bindValue(':id',   $id_etapa);
            $sql->bindValue(':id_obra',   $id_obra);
            $sql->bindValue(':id_status',   $status);


            return $sql->execute() ? true : false;
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }
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
        $data_value                 = $Parametros['data_value'];

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

        if ($sql->rowCount() > 0) {
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
            WHERE histf_id_status = :histfa_id AND obr.atv = 1
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

            $sql = $this->db->prepare("SELECT * FROM historico_faturamento

                WHERE (histfa_id = :histfa_id) LIMIT 1
            ");

            $sql->bindValue(':histfa_id',   $histfa_id);

            $sql->execute();

            if ($sql->rowCount() == 1) {
                $row = $sql->fetch();


                if ($row['valor_receber'] == 0) {

                    $sql = $this->db->prepare("UPDATE obra_etapa obr SET

                        obr.id_status 		= :id_status
    
                        WHERE (id_etapa = :id) AND (id_obra = :id_obra)
                    ");

                    $sql->bindValue(':id',   $id_etapa);
                    $sql->bindValue(':id_obra',   $id_obra);
                    $sql->bindValue(':id_status',   RECEBIDO);

                    return $sql->execute() ? $valor : false;
                }
            }

            return true;
        } else {
            $sql = $this->db->prepare("UPDATE obra_etapa obr SET

            obr.id_status 		= :id_status

            WHERE (id_etapa = :id) AND (id_obra = :id_obra)
        ");

            $sql->bindValue(':id',   $id_etapa);
            $sql->bindValue(':id_obra',   $id_obra);
            $sql->bindValue(':id_status',   FATURAR);

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



        } else {
            controller::alert('error', 'não foi possivel deletar o lançamento');
        }
    }

    public function getPendentesRecebido()
    {

        $hoje = date('Y-m-d');

        $array_faturamento = array();

        $sql = $this->db->prepare("
            SELECT * FROM historico_faturamento histf
            INNER JOIN obra obr ON (obr.id = histf.id_obra)
            WHERE (histf.recebido_status = 0 AND histf.status <> 1 AND obr.atv = 1)
        ");

        $sql->bindValue(":hoje", $hoje);
        $sql->execute();

        if ($sql->rowCount() > 0) {

            $array_faturamento_fat  = $sql->fetchAll();

            foreach ($array_faturamento_fat as $fat) {

                $data = str_replace('/', '-', $fat['data_vencimento']);

                $vencimento =  date('Y-m-d', strtotime($data));

                if ($vencimento <= $hoje) {
                    $array_faturamento[] = $fat;
                }
            }
        }

        return $array_faturamento;
    }

    public function add($id_company, $Parametros)
    {

        $valor_proposta         = controller::PriceSituation($Parametros['valor_proposta']);
        $valor_desconto         = controller::PriceSituation($Parametros['valor_desconto']);
        $valor_negociado         = controller::PriceSituation($Parametros['valor_negociado']);
        $valor_custo              = controller::PriceSituation($Parametros['valor_custo']);

        $id_obra                = $Parametros['id_obra'];
        $data_envio             = isset($Parametros['data_envio']) ? $Parametros['data_envio'] : '';

        try {
            $sql = "INSERT INTO financeiro_obra SET 

                id_company = :id_company,
                valor_proposta = :valor_proposta,
                valor_negociado = :valor_negociado,
                valor_desconto = :valor_desconto,
                valor_custo = :valor_custo,
                data_envio = :data_envio,
                id_obra = :id_obra
            ";

            $sql = $this->db->prepare($sql);

            $sql->bindValue(":id_company", $id_company);
            $sql->bindValue(":valor_proposta", $valor_proposta);
            $sql->bindValue(":valor_negociado", $valor_negociado);
            $sql->bindValue(":valor_desconto", $valor_desconto);
            $sql->bindValue(":valor_custo", $valor_custo);
            $sql->bindValue(":data_envio", $data_envio);
            $sql->bindValue(":id_obra", $id_obra);

            $sql->execute() ? controller::alert('success', 'Cadastrado com sucesso') : controller::alert('error', 'erro');
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }

        return $this->db->lastInsertId();
    }

    public function verifyFinanceiroObra($id_obra)
    {

        $array_fin = array();

        $sql = $this->db->prepare("
            SELECT * FROM financeiro_obra WHERE id_obra = :id_obra 
        ");

        $sql->bindValue(":id_obra", $id_obra);
        $sql->execute();

        return ($sql->rowCount() > 0) ? true : false;
    }

    public function getExcel()
    {

        $array_fin = array();

        $sql = $this->db->prepare("
            SELECT * FROM financeiro_obra WHERE id_obra = :id_obra 
        ");

        $sql->bindValue(":id_obra", $id_obra);
        $sql->execute();

        return ($sql->rowCount() > 0) ? true : false;
    }
}
