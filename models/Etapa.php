<?php

class Etapa extends model
{

    public function __construct($nomeTabela)
    {
        parent::__construct();

        $this->array = array();
        $this->retorno = array();

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
            '1=1'
        );

        if (!empty($filtro['search']['value'])) {

            if ($filtro['search']['value'] != '') {

                $where[] = "etp.etp_nome LIKE :etp_nome";
            }
        }

        return $where;
    }

    private function bindWhere($filtro, &$sql)
    {

        if (!empty($filtro['search']['value'])) {
            if ($filtro['search']['value'] != '') {
                $sql->bindValue(":etp_nome", '%' . $filtro['search']['value'] . '%');
            }
        }
    }

    public function add($id_company, $Parametros)
    {

        $tipo = "Inserido";

        $id_servico = $Parametros['id_servico'];
        $id_concessionaria = $Parametros['id_concessionaria'];


        $quantidade = (isset($Parametros['quantidade']) ? $Parametros['quantidade'] : '');
        $preco      = (isset($Parametros['preco'])      ? controller::PriceSituation($Parametros['preco'])      : '');
        $tipo_compra      = (isset($Parametros['tipo_compra'])      ? $Parametros['tipo_compra']      : '');

        if ($Parametros['tipo'] == 1) {
            $tipo = 'adm';
        } else if ($Parametros['tipo'] == 2) {
            $tipo = 'com';
        } else if ($Parametros['tipo'] == 3) {
            $tipo = 'obr';
        } else {
            $tipo = 'compra';
        }

        try {
            $sql = $this->db->prepare("INSERT INTO etapa SET 
                etp_nome    = :nome,
                tipo        = :tipo,
                quantidade  = :quantidade,
                preco       = :preco,
                tipo_compra  = :tipo_compra
            ");

            $sql->bindValue(":nome", $Parametros['nome']);
            $sql->bindValue(":tipo", $Parametros['tipo']);
            $sql->bindValue(":quantidade", $quantidade);
            $sql->bindValue(":preco", $preco);
            $sql->bindValue(":tipo_compra", $tipo_compra);


            $sql->execute();

            $id_etapa = $this->db->lastInsertId();

            controller::setLog($Parametros, 'etapa', 'add');

            $this->addEtapaConcessionariaByService($id_concessionaria, $id_servico, $id_etapa, $tipo);
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }

        return $this->db->lastInsertId();
    }

    public function addEtapaCompra($id_company, $Parametros)
    {

        $tipo = "Inserido";

        $id_servico = $Parametros['id_servico'];
        $id_concessionaria = $Parametros['id_concessionaria'];

        $quantidade       = (isset($Parametros['quantidade']) ? $Parametros['quantidade'] : '');
        $preco            = (isset($Parametros['preco'])      ? controller::PriceSituation($Parametros['preco'])      : '');
        $tipo_compra      = (isset($Parametros['tipo_compra'])      ? $Parametros['tipo_compra']      : '');


        try {
            $sql = $this->db->prepare("INSERT INTO etapa SET 
                etp_nome    = :nome,
                tipo        = :tipo,
                quantidade  = :quantidade,
                preco       = :preco,
                tipo_compra  = :tipo_compra
            ");

            $sql->bindValue(":tipo", 4);
            $sql->bindValue(":nome", $Parametros['add_etapa_compra']);
            $sql->bindValue(":quantidade", $quantidade);
            $sql->bindValue(":preco", $preco);
            $sql->bindValue(":tipo_compra", $tipo_compra);


            $sql->execute();

            $id_etapa = $this->db->lastInsertId();

            controller::setLog($Parametros, 'etapa', 'add');

            if (isset($Parametros['variavel'])) {
                $this->addVariavelEtapa($Parametros, $id_etapa);
            }

            $this->addEtapaConcessionariaByService($id_concessionaria, $id_servico, $id_etapa, $tipo);
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }

        return $this->db->lastInsertId();
    }

    public function addVariavelEtapa($Parametros, $id_etapa)
    {

        if (isset($Parametros['variavel'])) {
            if (count($Parametros['variavel']) > 0) {
                for ($q = 0; $q < count($Parametros['variavel']['nome_variavel']); $q++) {

                    if ($Parametros['variavel']['nome_variavel'][$q] != '') {

                        $sql = $this->db->prepare("INSERT INTO variavel_etapa (id_etapa, nome_variavel, preco_variavel)
                            VALUES (:id_etapa, :nome_variavel, :preco_variavel)
                        ");

                        $sql->bindValue(":id_etapa", $id_etapa);
                        $sql->bindValue(":nome_variavel", $Parametros['variavel']['nome_variavel'][$q]);
                        $sql->bindValue(":preco_variavel", controller::PriceSituation($Parametros['variavel']['preco_variavel'][$q]));


                        $sql->execute();
                    }
                }
            }
        } else { }
    }

    public function getVariavelEtapa($id_etapa)
    {

        $variavel_array = array();

        $sql = $this->db->prepare("SELECT * FROM variavel_etapa WHERE id_etapa = :id_etapa");
        $sql->bindValue(':id_etapa', $id_etapa);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $variavel_array = $sql->fetchAll();
        }

        return $variavel_array;
    }

    public function edit($id_company, $Parametros)
    {
        $tipo = 'Editado';



        $etp_nome  = $Parametros['nome_etapa'];
        $id_etapa  = $Parametros['id_etapa'];
        $descricao  = $Parametros['descricao'];


        $quantidade         = (isset($Parametros['quantidade'])  ? $Parametros['quantidade'] : '');
        $preco              = (isset($Parametros['preco'])       ? controller::PriceSituation($Parametros['preco']) : '');
        $tipo_compra        = (isset($Parametros['tipo_compra']) ? $Parametros['tipo_compra'] : '');

        if (isset($id_etapa) && $id_etapa != '') {
            try {

                $sql = $this->db->prepare("UPDATE etapa SET 
					
					etp_nome = :etp_nome,
                    quantidade  = :quantidade,
                    preco       = :preco,
                    tipo_compra  = :tipo_compra,
                    descricao = :descricao

					WHERE id = :id_etapa
	        	");

                $sql->bindValue(":etp_nome", $etp_nome);
                $sql->bindValue(":id_etapa", $id_etapa);
                $sql->bindValue(":quantidade", $quantidade);
                $sql->bindValue(":preco", $preco);
                $sql->bindValue(":tipo_compra", $tipo_compra);
                $sql->bindValue(":descricao", $descricao);


                if ($sql->execute()) {

                    if (isset($Parametros['variavel']) && $Parametros['variavel'] != '') {
                        foreach ($Parametros['variavel'] as $var) {

                            $nome_variavel = $var['nome_variavel'];
                            $preco_variavel = $var['preco_variavel'];
                            $id = $var['id'];


                            $sql = $this->db->prepare("UPDATE variavel_etapa SET 
                        
                                nome_variavel = :nome_variavel,
                                preco_variavel  = :preco_variavel

                                WHERE id_variavel_etapa = :id
                            ");

                            $sql->bindValue(":nome_variavel", $nome_variavel);
                            $sql->bindValue(":preco_variavel", controller::PriceSituation($preco_variavel));
                            $sql->bindValue(":id", $id);
                            $sql->execute();
                        }
                    }


                    controller::alert('success', 'Editado com sucesso!!');
                    controller::setLog($Parametros, 'etapa', 'edit');
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

    public function delete($id_etapa, $id_company)
    {
        $tipo = 'Deletado';

        $Parametros = array();
        $Parametros['id_etapa'] = $id_etapa;

        if (isset($id_etapa) && $id_etapa != '') {

            $sql = $this->db->prepare("DELETE FROM etapa WHERE id = :id_etapa");
            $sql->bindValue(":id_etapa", $id_etapa);

            if ($sql->execute()) {
                controller::alert('success', 'Deletado com sucesso!!');
                controller::setLog($Parametros, 'etapa', 'delete');
            } else {
                controller::alert('danger', 'Erro ao deletar!!');
            }
        } else {
            controller::alert('danger', 'Não foi selecionado nenhum arquivo!!');
        }
    }

    public function deleteVariavelEtapa($id_variavel_etapa)
    {
        $tipo = 'Deletado';

        if (isset($id_variavel_etapa) && $id_variavel_etapa != '') {

            $sql = $this->db->prepare("DELETE FROM variavel_etapa WHERE id_variavel_etapa = :id_variavel_etapa");
            $sql->bindValue(":id_variavel_etapa", $id_variavel_etapa);

            if ($sql->execute()) {
                //controller::alert('success', 'Deletado com sucesso!!');
                //controller::setLog($id_variavel_etapa, 'etapaDeleteVariavel', 'delete');

                return true;
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

        $Parametros = array(
            'id_etapa_obra' => $id_etapa_obra,
        );


        if (isset($id_etapa_obra) && $id_etapa_obra != '') {

            $sql = $this->db->prepare("DELETE FROM obra_etapa WHERE id_etapa_obra = :id_etapa_obra");
            $sql->bindValue(":id_etapa_obra", $id_etapa_obra);

            if ($sql->execute()) {
                controller::alert('success', 'Deletado com sucesso!!');
                controller::setLog($Parametros, 'delete_etapa_obra', 'obra_etapa');
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

    public function getEtapasByTipo($offset = 0, $tipo, $id_concessionaria, $id_servico)
    {

        $arrayTipo = array();
        $sql = $this->db->prepare("
        
        SELECT * FROM etapa etp
		INNER JOIN etapa_tipo etpt ON (etp.tipo = etpt.id_etapatipo)
		WHERE etp.id NOT IN(
            SELECT etpsc.id_etapa FROM etapas_servico_concessionaria etpsc
            WHERE etpsc.id_concessionaria = :id_concessionaria AND etpsc.id_servico = :id_servico)

			AND etpt.nome = :nome ORDER BY etp_nome
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

    public function getEtapasByTipoAjax($offset, $tipo, $id_concessionaria, $id_servico, $filtro = array())
    {

        $start = isset($filtro['start']) ? $filtro['start'] : '0';
        $length = isset($filtro['length']) ? $filtro['length'] : '5';

        $arrayTipo = array();

        $where = $this->buildWhere($filtro, $id_company = 1);

        $sql = ("
        
            SELECT * FROM etapa etp
            INNER JOIN etapa_tipo etpt ON (etp.tipo = etpt.id_etapatipo)
            WHERE etp.id NOT IN(
                SELECT etpsc.id_etapa FROM etapas_servico_concessionaria etpsc
                WHERE etpsc.id_concessionaria = :id_concessionaria AND etpsc.id_servico = :id_servico)

                AND etpt.nome = :nome AND " . implode(' AND ', $where). " ORDER BY etp_nome LIMIT ".$start." ,".$length
        );


        $sql = $this->db->prepare($sql);
        
        $this->bindWhere($filtro, $sql);

        $sql->bindValue(':nome', $tipo);
        $sql->bindValue(':id_concessionaria', $id_concessionaria);
        $sql->bindValue(':id_servico', $id_servico);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $arrayTipo = $sql->fetchAll();
            $arrayTipo['rowCount'] = $sql->rowCount();
        }

        return $arrayTipo;
        
    }

    public function criarBotao($id_etapa){


        
        
        $botao = sprintf('<a type="button" data-toggle="tooltip" title="" data-original-title="Deletar" class="btn btn-danger" href="delete_etapa/%s/%s/%s/compra"><i class="ion ion-trash-a"></i></a>
        <a type="button" class="btn btn-info" onclick="modalEditar(%s, %-"Comp)"><i class="ion-android-create"></i></a>', $id_etapa,$id_etapa,$id_etapa,$id_etapa, 'Comp');
                                       
        
        return $botao;

    }

    public function getCountEtapaByTipo($tipo, $id_concessionaria, $id_servico)
    {

        $arrayTipo = array();
        $sql = $this->db->prepare("
        
        SELECT COUNT(*) AS c FROM etapa etp
		INNER JOIN etapa_tipo etpt ON (etp.tipo = etpt.id_etapatipo)
		WHERE etp.id NOT IN(
            SELECT etpsc.id_etapa FROM etapas_servico_concessionaria etpsc
            WHERE etpsc.id_concessionaria = :id_concessionaria AND etpsc.id_servico = :id_servico)

			AND etpt.nome = :nome ORDER BY etp_nome
		");

        $sql->bindValue(':nome', $tipo);
        $sql->bindValue(':id_concessionaria', $id_concessionaria);
        $sql->bindValue(':id_servico', $id_servico);

        $sql->execute();

        if ($sql->rowCount() > 0) {
			$row = $sql->fetch();
		}

		$r = $row['c'];

		return $r;
    }



    public function getEtapasByServicoConcessionaria($tipo, $id_concessionaria, $id_servico)
    {

        $arrayConcessionaria = array();

        $sql = $this->db->prepare("SELECT *, etpsc.id as id_ord_m FROM etapas_servico_concessionaria etpsc
            INNER JOIN etapa etp ON (etp.id = etpsc.id_etapa)
            INNER JOIN etapa_tipo etpt ON (etp.tipo = etpt.id_etapatipo)

			WHERE etpsc.id_concessionaria = :id_concessionaria AND etpsc.id_servico = :id_servico AND etpt.nome = :tipo ORDER BY etpsc.order_id ASC
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

    public function addEtapaConcessionariaByService($id_concessionaria, $id_servico, $id_etapa, $tipo)
    {

        try {
            $sql = $this->db->prepare("INSERT INTO etapas_servico_concessionaria SET 
        		id_concessionaria = :id_concessionaria,
                id_servico        = :id_servico,
                id_etapa          = :id_etapa,
                tipo              = :tipo

			");

            $sql->bindValue(":id_concessionaria", $id_concessionaria);
            $sql->bindValue(":id_servico", $id_servico);
            $sql->bindValue(":id_etapa", $id_etapa);
            $sql->bindValue(":tipo", $tipo);



            if ($sql->execute()) {


                $id = $this->db->lastInsertId();

                $sql = $this->db->prepare("
                    UPDATE etapas_servico_concessionaria SET 
                        order_id = :id
                    WHERE id = :id
                ");

                $sql->bindValue(":id", $id);
                $sql->execute();

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
        $sql = $this->db->prepare("SELECT *, obrt.quantidade AS quantidade_obra, obrt.preco AS preco_obra, obrt.tipo_compra AS tipo_compra_obra FROM obra_etapa obrt
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


        if (isset($id_etapa) && $id_etapa != '') {

            if ($Parametros['tipo'] === 'ADMINISTRATIVA') {

                $adm = array();

                $adm['id_obra'] = $Parametros['id_obra'];

                $adm['etp_nome'] = isset($Parametros['nome_etapa']) ? $Parametros['nome_etapa'] : '';

                $adm['nome_etapa_obra'] = $Parametros['nome_etapa_obra'];


                $adm['responsavel_administrativo'] = $Parametros['responsavel_administrativo'];
                $adm['data_pedido_administrativo'] = $Parametros['data_pedido_administrativo'];
                $adm['cliente_responsavel_administrativo'] = $Parametros['cliente_responsavel_administrativo'];
                $adm['observacao'] = $Parametros['observacao'];
                $adm['observacao_sistema'] = $Parametros['observacao_sistema'];
                $adm['meta_etapa'] = $Parametros['meta_etapa'];


                $this->etapaAdministrativo($id_etapa, $adm, $id_company, $id_user);
            } elseif ($Parametros['tipo'] === 'CONCESSIONARIA') {

                $com = array();

                $com['check_nota'] = isset($Parametros['check_nota']) ? $Parametros['check_nota'] : '';

                $com['id_obra'] = $Parametros['id_obra'];

                $com['etp_nome'] = isset($Parametros['nome_etapa']) ? $Parametros['nome_etapa'] : '';

                $com['nome_etapa_obra'] = $Parametros['nome_etapa_obra'];

                $com['nota_numero_concessionaria'] = $Parametros['nota_numero_concessionaria'];
                $com['data_abertura_concessionaria'] = $Parametros['data_abertura_concessionaria'];
                $com['prazo_atendimento_concessionaria'] = $Parametros['prazo_atendimento_concessionaria'];
                $com['observacao'] = $Parametros['observacao'];
                $com['observacao_sistema'] = $Parametros['observacao_sistema'];
                $com['meta_etapa'] = $Parametros['meta_etapa'];


                $com['nova_data'] = controller::SomarData(controller::returnDate($com['data_abertura_concessionaria']), $com['prazo_atendimento_concessionaria']);

                $this->etapaConcessionaria($id_etapa, $com, $id_company, $id_user);
            } elseif ($Parametros['tipo'] === 'OBRA') {

                $obr = array();

                $obr['id_obra'] = $Parametros['id_obra'];

                $obr['etp_nome'] = isset($Parametros['nome_etapa']) ? $Parametros['nome_etapa'] : '';

                $obr['nome_etapa_obra'] = $Parametros['nome_etapa_obra'];


                $obr['responsavel_obra'] = $Parametros['responsavel_obra'];
                $obr['data_programada_obra'] = $Parametros['data_programada_obra'];
                $obr['data_iniciada_obra'] = $Parametros['data_iniciada_obra'];
                $obr['tempo_atividade_obra'] = $Parametros['tempo_atividade_obra'];
                $obr['observacao'] = $Parametros['observacao'];
                $obr['observacao_sistema'] = $Parametros['observacao_sistema'];
                $obr['meta_etapa'] = $Parametros['meta_etapa'];



                $this->etapaObra($id_etapa, $obr, $id_company, $id_user);
            } elseif ($Parametros['tipo'] === 'COMPRA') {

                $comp = array();

                $comp['id_obra'] = $Parametros['id_obra'];

                $comp['etp_nome'] = isset($Parametros['nome_etapa']) ? $Parametros['nome_etapa'] : '';
                $comp['nome_etapa_obra'] = $Parametros['nome_etapa_obra'];
                
                $comp['quantidade'] = $Parametros['quantidade'];
                $comp['preco'] = (isset($Parametros['preco'])  && !empty($Parametros['preco']) ? controller::PriceSituation($Parametros['preco'])      : '');
                $comp['tipo_compra'] = $Parametros['tipo_compra'];
                $comp['meta_etapa'] = $Parametros['meta_etapa'];


                

                $this->etapaCompra($id_etapa, $comp, $id_company, $id_user);
            }

            controller::setLog($Parametros, 'etapa', 'obra_etapa');


            if (isset($arquivos) && $Parametros['documento_etapa_nome'] != '') {
                $d = new Documentos;

                $Parametros['documento_etapa_nome'] = $Parametros['documento_etapa_nome'] . '_' . $Parametros['cliente'];
                $d->addDocumentoEtapa($id_etapa, $arquivos, $Parametros['documento_etapa_nome'], $id_company, $Parametros['id_obra']);
            }

            if (isset($arquivos) && isset($Parametros['documento_nome'])  && $Parametros['documento_nome'] != '') {
                $d = new Documentos;


                $Parametros['documento_nome'] = $Parametros['documento_nome'] . '_' . $Parametros['cliente'];
                $d->add($arquivos, $id_company, $Parametros['id_obra'], $Parametros['documento_nome']);
            }
        } else {
            controller::alert('danger', 'Não foi selecionado nenhum arquivo!!');
        }
    }


    public function etapaAdministrativo($id_etapa, $Parametros, $id_company, $id_user)
    {
        try {

            $sql = $this->db->prepare("UPDATE obra_etapa SET 
                
                responsavel = :responsavel,
                data_pedido = :data_pedido,
                cliente_responsavel = :cliente_responsavel,
                observacao = :observacao, 
                observacao_sistema = :observacao_sistema, 
                etp_nome_etapa_obra = :etp_nome_etapa_obra,
                meta_etapa = :meta_etapa
                

                WHERE id_etapa_obra = :id
            ");

            $sql->bindValue(":responsavel", $Parametros['responsavel_administrativo']);
            $sql->bindValue(":data_pedido", $Parametros['data_pedido_administrativo']);
            $sql->bindValue(":cliente_responsavel", $Parametros['cliente_responsavel_administrativo']);
            $sql->bindValue(":observacao", $Parametros['observacao']);
            $sql->bindValue(":observacao_sistema", $Parametros['observacao_sistema']);
            $sql->bindValue(":etp_nome_etapa_obra", $Parametros['nome_etapa_obra']);
            $sql->bindValue(":meta_etapa", $Parametros['meta_etapa']);



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

                //$this->notificacao->insert($id_company, $ParametrosNotificacao);

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
                
                nota_numero = :nota_numero,
                data_abertura = :data_abertura,
                prazo_atendimento = :prazo_atendimento,
                data_prazo_total = :data_prazo_total,
                observacao = :observacao, 
                observacao_sistema = :observacao_sistema, 
                etp_nome_etapa_obra = :etp_nome_etapa_obra,
                meta_etapa = :meta_etapa

                

                WHERE id_etapa_obra = :id
            ");

            $sql->bindValue(":nota_numero", $Parametros['nota_numero_concessionaria']);
            $sql->bindValue(":data_abertura", controller::returnDate($Parametros['data_abertura_concessionaria']));
            $sql->bindValue(":prazo_atendimento", $Parametros['prazo_atendimento_concessionaria']);
            $sql->bindValue(":data_prazo_total", $nova_data);
            $sql->bindValue(":observacao", $Parametros['observacao']);
            $sql->bindValue(":observacao_sistema", $Parametros['observacao_sistema']);
            $sql->bindValue(":etp_nome_etapa_obra", $Parametros['nome_etapa_obra']);
            $sql->bindValue(":meta_etapa", $Parametros['meta_etapa']);




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

                //$this->notificacao->insert($id_company, $ParametrosNotificacao);

                controller::alert('success', 'Editado com sucesso!!');
            } else {
                controller::alert('danger', 'Erro ao fazer a edição!!');
            }

            if ($Parametros['check_nota'] == 1) {
                $sql = $this->db->prepare("UPDATE obra SET 
                    
                
                    obra_nota_numero = :obra_nota_numero
                    

                    WHERE id = :id
                ");

                $sql->bindValue(":obra_nota_numero", $Parametros['nota_numero_concessionaria']);


                $sql->bindValue(":id",  $Parametros['id_obra']);
                $sql->execute();
            }
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }
    }

    public function etapaObra($id_etapa, $Parametros, $id_company, $id_user)
    {
        try {

            $sql = $this->db->prepare("UPDATE obra_etapa SET 
                
                responsavel = :responsavel,
                data_programada = :data_programada,
                data_iniciada = :data_iniciada,
                tempo_atividade = :tempo_atividade,
                observacao = :observacao, 
                observacao_sistema = :observacao_sistema, 
                etp_nome_etapa_obra = :etp_nome_etapa_obra,
                meta_etapa = :meta_etapa


                WHERE id_etapa_obra = :id
            ");

            $sql->bindValue(":responsavel", $Parametros['responsavel_obra']);
            $sql->bindValue(":data_programada", $Parametros['data_programada_obra']);
            $sql->bindValue(":data_iniciada", $Parametros['data_iniciada_obra']);
            $sql->bindValue(":tempo_atividade", $Parametros['tempo_atividade_obra']);
            $sql->bindValue(":observacao_sistema", $Parametros['observacao_sistema']);
            $sql->bindValue(":observacao", $Parametros['observacao']);
            $sql->bindValue(":meta_etapa", $Parametros['meta_etapa']);


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

                //$this->notificacao->insert($id_company, $ParametrosNotificacao);

                controller::alert('success', 'Editado com sucesso!!');
            } else {
                controller::alert('danger', 'Erro ao fazer a edição!!');
            }
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }
    }

    public function etapaCompra($id_etapa, $Parametros, $id_company, $id_user)
    {

        
        try {

            $sql = $this->db->prepare("UPDATE obra_etapa SET 
                
                quantidade = :quantidade,
                preco = :preco,
                tipo_compra = :tipo_compra,
                etp_nome_etapa_obra = :etp_nome_etapa_obra,
                meta_etapa = :meta_etapa


                WHERE id_etapa_obra = :id
            ");

            $sql->bindValue(":quantidade", $Parametros['quantidade']);
            $sql->bindValue(":preco", $Parametros['preco']);
            $sql->bindValue(":tipo_compra", $Parametros['tipo_compra']);
            $sql->bindValue(":etp_nome_etapa_obra", $Parametros['nome_etapa_obra']);
            $sql->bindValue(":meta_etapa", $Parametros['meta_etapa']);


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

                //$this->notificacao->insert($id_company, $ParametrosNotificacao);

                controller::alert('success', 'Editado com sucesso!!');
            } else {
                controller::alert('danger', 'Erro ao fazer a edição!!');
            }
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }
    }


    public function check($ordem, $id_obra, $tipo)
    {

        $array = array();

        $sql = $this->db->prepare("SELECT obr.parcial_check as parcial,obr.check as `check`,ordem FROM obra_etapa obr 
            INNER JOIN etapa etp ON (obr.id_etapa = etp.id)
            WHERE (ordem < :id AND id_obra = :id_obra 
            AND etp.tipo = :tipo) ORDER BY id_etapa_obra DESC LIMIT 1 ");

        $sql->bindValue(':id', $ordem);
        $sql->bindValue(':id_obra', $id_obra);
        $sql->bindValue(':tipo', $tipo);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();

            if ($tipo == 1 || $tipo == 4) {
                return 1;
            }

            if ($row['parcial'] == 1  || $row['check'] == 1 || $row['check'] == '') {

                return 1;
            } else {

                return 0;
            }
        } else {

            return 1;
        }
    }


    public function getPendentes()
    {

        $data_hoje = date('Y-m-d');

        $prazo_cinco_dias =  date('Y-m-d', strtotime('+30days', strtotime($data_hoje)));
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

    public function getEtapasById($id_etapa){

        $sql = $this->db->prepare("
            SELECT * FROM etapa WHERE id = :id_etapa
        ");

        $sql->bindValue(':id_etapa', $id_etapa);

        $sql->execute();

        if ($sql->rowCount() == 1) {
            $arrayTipo = $sql->fetch();
        }

        return $arrayTipo;

    }

    public function getEtapasByTipoByObra($id_obra){

        $sql = $this->db->prepare("
            SELECT * FROM obra_etapa obrt 
            INNER JOIN etapa etp on (obrt.id_etapa = etp.id)
            INNER JOIN etapa_compra_comercial etcc on (etcc.id_etapa = etp.id)
            WHERE  obrt.id_obra = :id_obra  AND etp.tipo = 4 AND etcc.id_obra = :id_obra GROUP BY id_etapa_obra
        ");

        $sql->bindValue(':id_obra', $id_obra);

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $this->array = $sql->fetchAll();
        }

        return $this->array;

    }

    public function getVariavelByEtapa($id_etapa, $id_obra){

        $array = array();

        $sql = $this->db->prepare("
            SELECT * FROM etapa_compra_comercial etcc
            INNER JOIN variavel_etapa vare ON (etcc.id_variavel_etapa = vare.id_variavel_etapa)
            WHERE id_obra = :id_obra AND etcc.id_etapa = :id_etapa;
        ");

        $sql->bindValue(':id_etapa', $id_etapa);
        $sql->bindValue(':id_obra', $id_obra);
        $sql->execute();


        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;

    }

    public function getEtapaByServiceByConcessionaria($id_concessionaria, $id_servico){


        $array = array();

        $sql = $this->db->prepare("
            SELECT *, etpsc.id as id_ord_m FROM etapas_servico_concessionaria etpsc 
            WHERE etpsc.id_concessionaria = :id_concessionaria AND etpsc.id_servico = :id_servico
        ");

        $sql->bindValue(':id_concessionaria', $id_concessionaria);
        $sql->bindValue(':id_servico', $id_servico);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;

    }
}
