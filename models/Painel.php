<?php
class Painel extends model
{

    public function __construct()
    {
        parent::__construct();
        $this->array = array();
        $this->retorno = array();
    }

    public function insert($arr, $tabela, $id_company)
    {
        $certo = true;
        $nome_tabela = $tabela;
        $parametros[] = $id_company;


        foreach ($arr as $key => $value) {
            $nome_coluna[] = '`' . $key . '`';
        }

        $params = implode(',', $nome_coluna);

        $query = "INSERT INTO `$nome_tabela` (`id_company`,$params) VALUES (?";

        foreach ($arr as $key => $value) {
            $nome = $key;
            $valor = $value;
            if ($nome == 'id')
                continue;
            if ($value == '') {
                $certo = false;
                break;
            }
            $query .=  ",?";
            $parametros[] .= controller::ReturnFormatLimpo($value);
        }

        $query .= ")";

        if ($certo == true) {
            $sql = $this->db->prepare($query);
            if ($sql->execute($parametros)) {
                return $this->retorno = 'sucess';
            } else {
                return $this->retorno = 'error';
            }
        }
    }

    public function edit($arr, $nome_tabela, $id_company, $single = false)
    {
        $certo = true;
        $first = false;

        $query = "UPDATE `$nome_tabela` SET ";
        foreach ($arr as $key => $value) {
            $nome = $key;
            $valor = $value;
            if ($nome == 'acao' || $nome == 'nome_tabela' || $nome == 'id')
                continue;
            if ($value == '') {
                $certo = false;
                break;
            }

            if ($first == false) {
                $first = true;
                $query .= "$nome=?";
            } else {
                $query .= ",$nome=?";
            }

            $parametros[] = $value;
        }

        if ($certo == true) {
            if ($single == false) {
                $parametros[] = $arr['id'];
                $sql = $this->db->prepare($query . ' WHERE id=?');
                $sql->execute($parametros);
            } else {
                $sql = $this->db->prepare($query);
                $sql->execute($parametros);
            }
        }
        return $certo;
    }

    public function setLog($arr, $nome_tabela,  $tipo, $id_usuario)
    {

        $arr['nome_tabela'] = $nome_tabela;
 
        try {
            $sql = $this->db->prepare(
                "   INSERT INTO log SET 

                    log_id_usuario  = :id_usuario,  
                    log_timer       = NOW(),
                    log_tipo        = :tipo,
                    log_dados       = :Parametros

                ");

            $sql->bindValue(":id_usuario", $id_usuario);
            $sql->bindValue(":tipo", $tipo);
            $sql->bindValue(":Parametros", json_encode($arr, JSON_UNESCAPED_UNICODE ));


            if($sql->execute()){
                $this->db = null;

                return true;
            }else { 
                $this->db = null;
               
                return false;
            }
        
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }   


    }

    public function orderItem($orderType, $id, $tipo){
     
        $itemBefore = array();
        if($orderType == 'up'){

            $infoItemAtual = $this->atual($id);
            $order_id = $infoItemAtual['order_id'];

            $sql = $this->db->prepare(
                "   SELECT * FROM etapas_servico_concessionaria WHERE order_id < :order_id AND tipo = :tipo ORDER BY order_id DESC  LIMIT 1

                ");

            $sql->bindValue(":order_id", $order_id);
            $sql->bindValue(":tipo", $tipo);
            $sql->execute();
            
     
            if ($sql->rowCount() > 0) {
                $itemBefore = $sql->fetch();

                $sql = $this->db->prepare("
                UPDATE etapas_servico_concessionaria SET 
                    order_id = :order_id
                WHERE id = :id
                ");

                $sql->bindValue(":id", $itemBefore['id']);
                $sql->bindValue(":order_id", $order_id);
                $sql->execute();


                $sql = $this->db->prepare("
                UPDATE etapas_servico_concessionaria SET 
                    order_id = :order_id
                WHERE id = :id
                ");

                $sql->bindValue(":id", $infoItemAtual['id']);
                $sql->bindValue(":order_id", $itemBefore['order_id']);
                $sql->execute();


            }else {
                return;
            }


        }else if($orderType == 'down') {

            $infoItemAtual = $this->atual($id);
            $order_id = $infoItemAtual['order_id'];
            
            $sql = $this->db->prepare(
                "   SELECT * FROM etapas_servico_concessionaria WHERE order_id > :order_id AND tipo = :tipo ORDER BY order_id ASC  LIMIT 1

                ");

            $sql->bindValue(":order_id", $order_id);
            $sql->bindValue(":tipo", $tipo);
            $sql->execute();
            
     
            if ($sql->rowCount() > 0) {
                $itemBefore = $sql->fetch();

                $sql = $this->db->prepare("
                UPDATE etapas_servico_concessionaria SET 
                    order_id = :order_id
                WHERE id = :id
                ");

                $sql->bindValue(":id", $itemBefore['id']);
                $sql->bindValue(":order_id", $order_id);
                $sql->execute();


                $sql = $this->db->prepare("
                UPDATE etapas_servico_concessionaria SET 
                    order_id = :order_id
                WHERE id = :id
                ");

                $sql->bindValue(":id", $infoItemAtual['id']);
                $sql->bindValue(":order_id", $itemBefore['order_id']);
                $sql->execute();


            }else {
                return;
            }

        }


    }

    public function atual($id){
        $array = array();
        $sql = $this->db->prepare(
            "   SELECT * FROM etapas_servico_concessionaria WHERE id = :id LIMIT 1

            ");

        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }

        return $array;
       
    }

    public function script(){

        
        $array = array();
        $sql = $this->db->prepare(
            "    SELECT * FROM obra_etapa
            WHERE id_etapa <> 116 AND id_etapa_obra <> 40 and id_etapa_obra <> 39 and id_etapa_obra <> 515
            ");

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchALL();

            foreach($array as $k){


                $sql = $this->db->prepare(
                    "UPDATE obra_etapa  SET
							ordem = :id
				
							WHERE id_etapa_obra = :id
				");
                $sql->bindValue(":id",$k['id_etapa_obra']);


                $sql->execute();
                   
            }

        }

       

    }

    public function scriptdata(){

        $array = array();
        $sql = $this->db->prepare(
            "    SELECT data_vencimento FROM historico_faturamento
            
            ");

        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchALL();

        
            foreach($array as $k){

                $data_vencimento = str_replace('/', '-', $k['data_vencimento']);

                $data_vencimento =  date('Y-d-m', strtotime($data_vencimento));

                $sql = $this->db->prepare(
                    "UPDATE historico_faturamento  SET
							data_vencimento = :dat
				");
                $sql->bindValue(":dat",$data_vencimento);


                $sql->execute();
                   
            }

        }


    }

    
}

