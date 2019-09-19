<?php

class Etapa extends model
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

    public function getAll($filtro, $id_company)
    {

        $where = $this->buildWhere($filtro, $id_company);

        $sql = "
		SELECT * FROM  
			$this->tabela etp

		WHERE " . implode(' AND ', $where);

        $sql = $this->db->prepare($sql);

        $this->bindWhere($filtro, $sql);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $this->array = $sql->fetchAll();
        }

        return $this->array;
    }

    private function buildWhere($filtro, $id)
    {

        $where = array(
            'id_company=' . $id
        );

        if (!empty($filtro['example'])) {

            if ($filtro['example'] != '') {

                $where[] = "etp.example LIKE :example";
            }
        }

        return $where;
    }

    private function bindWhere($filtro, &$sql)
    {

        if (!empty($filtro['example'])) {
            if ($filtro['example'] != '') {
                $sql->bindValue(":example", '%' . $filtro['example'] . '%');
            }
        }
    }

    public function add($id_company, $Parametros)
    {

        $tipo = "Inserido";

        $id_servico = $Parametros['id_servico'];
        $id_concessionaria = $Parametros['id_concessionaria'];




        try {
            $sql = $this->db->prepare("INSERT INTO etapa SET 
                    etp_nome = :nome,
                    tipo = :tipo

                ");

            $sql->bindValue(":nome", $Parametros['nome']);
            $sql->bindValue(":tipo", $Parametros['tipo']);

            $sql->execute();

            $id_etapa = $this->db->lastInsertId();


            $this->addEtapaConcessionariaByService($id_concessionaria, $id_servico, $id_etapa);
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }

        return $this->db->lastInsertId();
    }

    public function edit($Parametros)
    {
        $tipo = 'Editado';

        if (isset($Parametros['id' . $this->tabela]) && $Parametros['id' . $this->tabela] != '') {
            try {

                $sql = $this->db->prepare("UPDATE $this->tabela SET 
					
					example = :example

					WHERE id_$this->tabela = :id
	        	");

                $sql->bindValue(":example", $example);
                $sql->bindValue(":id", $Parametros['id' . $this->tabela]);

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
            controller::alert('danger', 'Não foi selecionado nenhum arquivo!!');
        }
    }

    public function delete($id, $id_company)
    {
        $tipo = 'Deletado';

        if (isset($Parametros['id' . $this->tabela]) && $Parametros['id' . $this->tabela] != '') {

            $sql = $this->db->prepare("DELETE FROM $this->tabela WHERE id_$this->tabela = :id AND id_company = :id_company");
            $sql->bindValue(":id", $id);
            $sql->bindValue(":id_company", $id_company);

            if ($sql->execute()) {
                controller::alert('success', 'Deletado com sucesso!!');
            } else {
                controller::alert('danger', 'Erro ao deletar!!');
            }
        } else {
            controller::alert('danger', 'Não foi selecionado nenhum arquivo!!');
        }
    }

    public function delete_etapa_obra($id_etapa_obra, $id_company)
    {
        $tipo = 'Deletado';

        if (isset($id_etapa_obra) && $id_etapa_obra != '') {

            $sql = $this->db->prepare("DELETE FROM obra_etapa WHERE id_etapa_obra = :id_etapa_obra");

            $this->painel->setLog();
           
            $sql->bindValue(":id_etapa_obra", $id_etapa_obra);
            
            if ($sql->execute()) {
                controller::alert('success', 'Deletado com sucesso!!');
            } else {
                controller::alert('danger', 'Erro ao deletar!!');
            }
        } else {
            controller::alert('danger', 'Não foi selecionado nenhuma etapa!!');
        }
    }


    

    public function getCount($id_company)
    {

        $r = 0;

        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM $this->tabela WHERE id_company = :id_company");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        $row = $sql->fetch();
        $r = $row['count'];

        return $r;
    }

    public function getQntDocumentoEtapa($id_etapa_obra)
    {

        $r = 0;

        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM documento_etapa WHERE id_etapa_obra = :id_etapa_obra");
        $sql->bindValue(':id_etapa_obra', $id_etapa_obra);
        $sql->execute();

        $row = $sql->fetch();
        $r = $row['count'];

        return $r;
    }

    public function searchByName($var)
    {

        $sql = $this->db->prepare("SELECT * FROM etapa

			WHERE  etp_nome like :example
		");

        $sql->bindValue(':etp_nome', '%' . $var . '%');

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $this->array = $sql->fetchAll();
        }

        return $this->array;
    }

    public function getEtapasByTipo($tipo, $id_concessionaria, $id_servico)
    {

        $arrayTipo = array();
        $sql = $this->db->prepare("
        
        SELECT * FROM etapa etp
		INNER JOIN etapa_tipo etpt ON (etp.tipo = etpt.id_etapatipo)
		WHERE etp.id NOT IN(
            SELECT etpsc.id_etapa FROM etapas_servico_concessionaria etpsc
            WHERE etpsc.id_concessionaria = :id_concessionaria AND etpsc.id_servico = :id_servico)

			AND etpt.nome = :nome
		");

        $sql->bindValue(':nome', $tipo);
        $sql->bindValue(':id_concessionaria', $id_concessionaria);
        $sql->bindValue(':id_servico', $id_servico);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $arrayTipo = $sql->fetchAll();
        }

        return $arrayTipo;
    }

    public function getEtapasByServicoConcessionaria($tipo, $id_concessionaria, $id_servico)
    {

        $arrayConcessionaria = array();

        $sql = $this->db->prepare("SELECT * FROM etapas_servico_concessionaria etpsc
            INNER JOIN etapa etp ON (etp.id = etpsc.id_etapa)
            INNER JOIN etapa_tipo etpt ON (etp.tipo = etpt.id_etapatipo)

			WHERE etpsc.id_concessionaria = :id_concessionaria AND etpsc.id_servico = :id_servico AND etpt.nome = :tipo
		");

        $sql->bindValue(':id_concessionaria', $id_concessionaria);
        $sql->bindValue(':id_servico', $id_servico);
        $sql->bindValue(':tipo', $tipo);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $arrayConcessionaria = $sql->fetchAll();
        }

        return $arrayConcessionaria;
    }

    public function addEtapaConcessionariaByService($id_concessionaria, $id_servico, $id_etapa)
    {

        $tipo = "Inserido";
        try {
            $sql = $this->db->prepare("INSERT INTO etapas_servico_concessionaria SET 
        		id_concessionaria = :id_concessionaria,
                id_servico        = :id_servico,
                id_etapa          = :id_etapa

			");

            $sql->bindValue(":id_concessionaria", $id_concessionaria);
            $sql->bindValue(":id_servico", $id_servico);
            $sql->bindValue(":id_etapa", $id_etapa);


            if ($sql->execute()) {
                controller::alert('success', 'Inserido com sucesso!!');
            } else {
                controller::alert('danger', 'Não foi possivel fazer a inserção');
            }
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }

        return $this->db->lastInsertId();
    }

    public function removeEtapaConcessionariaByService($id_concessionaria, $id_servico, $id_etapa)
    {

        try {
            $sql = $this->db->prepare("DELETE FROM etapas_servico_concessionaria WHERE id_etapa = :id_etapa AND id_servico = :id_servico AND id_concessionaria = :id_concessionaria");
            $sql->bindValue(":id_etapa", $id_etapa);
            $sql->bindValue(":id_servico", $id_servico);
            $sql->bindValue(":id_concessionaria", $id_concessionaria);

            if ($sql->execute()) {
                controller::alert('success', 'Removido com sucesso!!');
            } else {
                controller::alert('danger', 'Não foi possivel remover');
            }
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }

        return true;
    }

    public function getIdEtapaObra($id)
    {
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM obra_etapa obrt
            INNER JOIN etapa etp ON (etp.id = obrt.id_etapa)
            INNER JOIN etapa_tipo etpt ON (etp.tipo = etpt.id_etapatipo)

            WHERE obrt.id_etapa_obra = :id 
            
        ");

        $sql->bindValue(':id', $id);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }


        return $array;
    }

    public function editEtapaObra($id_etapa, $Parametros, $arquivos, $id_company, $id_user)
    {
        $tipo = 'Editado';

error_log(print_r($Parametros,1));

        if (isset($id_etapa) && $id_etapa != '') {

            if ($Parametros['tipo'] === 'ADMINISTRATIVA') {

                $adm = array();

                $adm['id_obra'] = $Parametros['id_obra'];

                $adm['etp_nome'] = $Parametros['nome_etapa'];

                $adm['nome_etapa_obra'] = $Parametros['nome_etapa_obra'];


                $adm['responsavel_administrativo'] = $Parametros['responsavel_administrativo'];
                $adm['data_pedido_administrativo'] = $Parametros['data_pedido_administrativo'];
                $adm['cliente_responsavel_administrativo'] = $Parametros['cliente_responsavel_administrativo'];
                $adm['observacao'] = $Parametros['observacao'];


                $this->etapaAdministrativo($id_etapa, $adm, $id_company, $id_user);

            } elseif ($Parametros['tipo'] === 'CONCESSIONARIA') {

                $com = array();

                $com['id_obra'] = $Parametros['id_obra'];

                $com['etp_nome'] = $Parametros['nome_etapa'];

                $com['nome_etapa_obra'] = $Parametros['nome_etapa_obra'];

                $com['nota_numero_concessionaria'] = $Parametros['nota_numero_concessionaria'];
                $com['data_abertura_concessionaria'] = $Parametros['data_abertura_concessionaria'];
                $com['prazo_atendimento_concessionaria'] = $Parametros['prazo_atendimento_concessionaria'];
                $com['observacao'] = $Parametros['observacao'];

                $com['nova_data'] = controller::SomarData(controller::returnDate($com['data_abertura_concessionaria']), $com['prazo_atendimento_concessionaria']);

                $this->etapaConcessionaria($id_etapa, $com, $id_company, $id_user);

            } elseif ($Parametros['tipo'] === 'OBRA') {

                $obr = array();

                $obr['id_obra'] = $Parametros['id_obra'];

                $obr['etp_nome'] = $Parametros['nome_etapa'];

                $obr['nome_etapa_obra'] = $Parametros['nome_etapa_obra'];


                $obr['responsavel_obra'] = $Parametros['responsavel_obra'];
                $obr['data_programada_obra'] = $Parametros['data_programada_obra'];
                $obr['data_iniciada_obra'] = $Parametros['data_iniciada_obra'];
                $obr['tempo_atividade_obra'] = $Parametros['tempo_atividade_obra'];
                $obr['observacao'] = $Parametros['observacao'];

                $this->etapaObra($id_etapa, $obr, $id_company, $id_user);
            }

            if (isset($arquivos) && $Parametros['documento_nome'] != '') {

                $d = new Documentos;
                $d->addDocumentoEtapa($id_etapa, $arquivos, $Parametros['documento_nome'], $id_company);
            }
        } else {
            controller::alert('danger', 'Não foi selecionado nenhum arquivo!!');
        }
    }

    public function etapaAdministrativo($id_etapa, $Parametros, $id_company, $id_user)
    {
        try {

            $sql = $this->db->prepare("UPDATE obra_etapa SET 
                
                ordem = :ordem,
                responsavel = :responsavel,
                data_pedido = :data_pedido,
                cliente_responsavel = :cliente_responsavel,
                observacao = :observacao, 
                etp_nome_etapa_obra = :etp_nome_etapa_obra
                

                WHERE id_etapa_obra = :id
            ");

            $sql->bindValue(":responsavel", $Parametros['responsavel_administrativo']);
            $sql->bindValue(":data_pedido", $Parametros['data_pedido_administrativo']);
            $sql->bindValue(":cliente_responsavel", $Parametros['cliente_responsavel_administrativo']);
            $sql->bindValue(":observacao", $Parametros['observacao']);
            $sql->bindValue(":etp_nome_etapa_obra", $Parametros['nome_etapa_obra']);

            $sql->bindValue(":ordem", '');

            $sql->bindValue(":id", $id_etapa);

            if ($sql->execute()) {

                $ParametrosNotificacao = array(
                    'props' => array(
                        'msg' => 'Foi definido um prazo na etapa ' . $Parametros['nome_etapa_obra'],
                        'etapa' => ADMINISTRATIVA,
                        'id_obra' => $Parametros['id_obra']
                    ),
                    'usuario' => $id_user,
                    'tipo' => 'DEFINIDO',
                    'id_company' => $id_company,
                    'link' => BASE_URL . 'obras/edit/' . $Parametros['id_obra']
                );

                $this->notificacao->insert($id_company, $ParametrosNotificacao);

                controller::alert('success', 'Editado com sucesso!!');
            } else {
                controller::alert('danger', 'Erro ao fazer a edição!!');
            }
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }
    }

    public function etapaConcessionaria($id_etapa, $Parametros, $id_company, $id_user)
    {

        $data = str_replace("/", "-", $Parametros["nova_data"]);
        $nova_data = date('Y-m-d', strtotime($data));

        try {

            $sql = $this->db->prepare("UPDATE obra_etapa SET 
                
                ordem = :ordem,
                nota_numero = :nota_numero,
                data_abertura = :data_abertura,
                prazo_atendimento = :prazo_atendimento,
                data_prazo_total = :data_prazo_total,
                observacao = :observacao, 
                etp_nome_etapa_obra = :etp_nome_etapa_obra
                

                WHERE id_etapa_obra = :id
            ");

            $sql->bindValue(":ordem", '');
            $sql->bindValue(":nota_numero", $Parametros['nota_numero_concessionaria']);
            $sql->bindValue(":data_abertura", controller::returnDate($Parametros['data_abertura_concessionaria']));
            $sql->bindValue(":prazo_atendimento", $Parametros['prazo_atendimento_concessionaria']);
            $sql->bindValue(":data_prazo_total", $nova_data);
            $sql->bindValue(":observacao", $Parametros['observacao']);
            $sql->bindValue(":etp_nome_etapa_obra", $Parametros['nome_etapa_obra']);


            $sql->bindValue(":id", $id_etapa);

            if ($sql->execute()) {

                $ParametrosNotificacao = array(
                    'props' => array(
                        'msg' => 'Foi definido um prazo na etapa ' . $Parametros['nome_etapa_obra'],
                        'etapa' => CONCESSIONARIA,
                        'id_obra' => $Parametros['id_obra']

                    ),
                    'usuario' => $id_user,
                    'tipo' => 'DEFINIDO',
                    'id_company' => $id_company,
                    'link' => BASE_URL . 'obras/edit/' . $Parametros['id_obra']
                );

                $this->notificacao->insert($id_company, $ParametrosNotificacao);

                controller::alert('success', 'Editado com sucesso!!');
            } else {
                controller::alert('danger', 'Erro ao fazer a edição!!');
            }


            $sql = $this->db->prepare("UPDATE obra SET 
                
               
                obra_nota_numero = :obra_nota_numero
                

                WHERE id = :id
            ");

            $sql->bindValue(":obra_nota_numero", $Parametros['nota_numero_concessionaria']);


            $sql->bindValue(":id",  $Parametros['id_obra']);
            $sql->execute();
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }
    }

    public function etapaObra($id_etapa, $Parametros, $id_company, $id_user)
    {
        try {

            $sql = $this->db->prepare("UPDATE obra_etapa SET 
                
                ordem = :ordem,
                responsavel = :responsavel,
                data_programada = :data_programada,
                data_iniciada = :data_iniciada,
                tempo_atividade = :tempo_atividade,
                observacao = :observacao, 
                etp_nome_etapa_obra = :etp_nome_etapa_obra

                WHERE id_etapa_obra = :id
            ");

            $sql->bindValue(":ordem", '');
            $sql->bindValue(":responsavel", $Parametros['responsavel_obra']);
            $sql->bindValue(":data_programada", $Parametros['data_programada_obra']);
            $sql->bindValue(":data_iniciada", $Parametros['data_iniciada_obra']);
            $sql->bindValue(":tempo_atividade", $Parametros['tempo_atividade_obra']);
            $sql->bindValue(":observacao", $Parametros['observacao']);
            $sql->bindValue(":etp_nome_etapa_obra", $Parametros['nome_etapa_obra']);



            $sql->bindValue(":id", $id_etapa);

            if ($sql->execute()) {

                $ParametrosNotificacao = array(
                    'props' => array(
                        'msg' => 'Foi definido um prazo na etapa ' . $Parametros['nome_etapa_obra'],
                        'etapa' => OBRA,
                        'id_obra' => $Parametros['id_obra']
                    ),
                    'usuario' => $id_user,
                    'tipo' => 'DEFINIDO',
                    'id_company' => $id_company,
                    'link' => BASE_URL . 'obras/edit/' . $Parametros['id_obra']
                );

                $this->notificacao->insert($id_company, $ParametrosNotificacao);

                controller::alert('success', 'Editado com sucesso!!');
            } else {
                controller::alert('danger', 'Erro ao fazer a edição!!');
            }
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }
    }


    public function check($id, $id_obra, $tipo)
    {

        $array = array();

        $sql = $this->db->prepare("SELECT obr.parcial_check as parcial,obr.check as `check` FROM obra_etapa obr 
            INNER JOIN etapa etp ON (obr.id_etapa = etp.id)
            WHERE (id_etapa_obra = :id AND id_obra = :id_obra 
            AND etp.tipo = :tipo) ");

        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_obra', $id_obra);
        $sql->bindValue(':tipo', $tipo);

        $sql->execute();

        $row = $sql->fetch();

        if ($tipo == 1) {

            return 1;
        }

        if ($row['parcial'] == 1  || $row['check'] == 1 || $row['check'] == '') {

            return 1;
        } else {

            return 0;
        }
    }


    public function getPendentes()
    {

        $data_hoje = date('Y-m-d');

        $prazo_cinco_dias =  date('Y-m-d', strtotime('+5days', strtotime($data_hoje)));
        $prazo_atrasado = date('Y-m-d', strtotime('-1000days', strtotime($data_hoje)));

        try {

            $sql = $this->db->prepare("SELECT * FROM obra_etapa obtp

                INNER JOIN obra obr ON (obr.id = obtp.id_obra) 
                INNER JOIN etapa etp ON (etp.id = obtp.id_etapa)
                INNER JOIN cliente cli ON (cli.id = obr.id_cliente)
            
                WHERE data_prazo_total between :prazo_atrasado AND :prazo_cinco_dias AND `check` = 0 ORDER BY data_prazo_total LIMIT 10; 

            ");

            $sql->bindValue(':prazo_atrasado', date($prazo_atrasado));
            $sql->bindValue(':prazo_cinco_dias', date($prazo_cinco_dias));

            $sql->execute();

            if ($sql->rowCount() > 0) {
                $this->array = $sql->fetchAll();
            }

            return $this->array;
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }
    }

    public function etapaPull2($Parametros)
    {


        $sql = $this->db->prepare("UPDATE obra_etapa obr SET

            obr.parcial_check          	= 2

            WHERE (id_etapa = :id) AND (id_obra = :id_obra)

        ");

        $sql->bindValue(':id',   $Parametros['id_etapa']);
        $sql->bindValue(':id_obra',   $Parametros['id_obra']);

        $sql->execute();
    }
}
