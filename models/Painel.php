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
                return true;
            }else { 
                return false;
            }
        
        } catch (PDOExecption $e) {
            $sql->rollback();
            error_log(print_r("Error!: " . $e->getMessage() . "</br>", 1));
        }   


    }

    
}
