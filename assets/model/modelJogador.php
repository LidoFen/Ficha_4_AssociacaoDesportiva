<?php
require_once 'connection.php';

class Jogador {

    function uploads($img, $idClube){


        $dir = "../imagens/clube".$idClube."/";
        $dir1 = "assets/imagens/clube".$idClube."/";
        $flag = false;
        $targetBD = "";
    
        if(!is_dir($dir)){
            if(!mkdir($dir, 0777, TRUE)){
                die ("Erro não é possivel criar o diretório");
            }
        }
      if(array_key_exists('foto', $img)){
        if(is_array($img)){
          if(is_uploaded_file($img['foto']['tmp_name'])){
            $fonte = $img['foto']['tmp_name'];
            $ficheiro = $img['foto']['name'];
            $end = explode(".",$ficheiro);
            $extensao = end($end);
    
            $newName = "foto".date("YmdHis").".".$extensao;
    
            $target = $dir.$newName;
            $targetBD = $dir1.$newName;
    
            $flag = move_uploaded_file($fonte, $target);
            
          } 
        }
      }
        return (json_encode(array(
          "flag" => $flag,
          "target" => $targetBD
        )));
    
    
    }

    function updateJogadorImg($diretorio, $nFederativo){
        global $conn;
        $msg = "";
        $flag = true;

        $sql = "UPDATE jogador SET foto = '".$diretorio."' WHERE nFederativo =".$nFederativo;

        if ($conn->query($sql) === TRUE) {
            $msg = "Imagem adicionada com sucesso";
        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
          

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($resp);
    }

    function registaJogador($nFederativo, $nome, $email, $idade, $morada, $telefone, $idClube, $img){

        global $conn;
        $msg = "";
        $flag = true;

        $sql = "INSERT INTO jogador (nFederativo, nome, email, idade, morada, telefone, idClube) VALUES ('".$nFederativo."',  '".$nome."', '".$email."', '".$idade."', '".$morada."', '".$telefone."', '".$idClube."')";

        if ($conn->query($sql) === TRUE) {
            $msg = "Jogador registado com sucesso";
            $resp = $this -> uploads($img, $idClube);

            $res = json_decode($resp, TRUE);

            if($res['flag']){
                $this->updateJogadorImg($res['target'],$nFederativo);
            }

        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
          
        $conn->close();

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($resp);
    }

    function getListaJogadores(){

        global $conn;
        $msg = "";

        $sql = "SELECT * FROM jogador";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $msg .= "<tr>";
            $msg .= "<th scope='row'>".$row['nFederativo']."</td>";
            $msg .= "<td>".$row['nome']."</td>";
            $msg .= "<td>".$row['idade']."</td>";
            $msg .= "<td><button class='btn btn-warning' onclick = 'getDadosJogador(".$row['nFederativo'].")'><i class='fa fa-pencil'></i></button></td>";
            $msg .= "<td><button class='btn btn-danger' onclick = 'removerJogador(".$row['nFederativo'].")'><i class='fa fa-trash'></i></button></td>";
            $msg .= "<td><button class='btn btn-primary' onclick = 'getInfo(".$row['nFederativo'].")'><i class='fa fa-plus'></i></button></td>";
            $msg .= "</tr>";
        }
        } else {
            $msg .= "<tr>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "<td>Sem Resultados</td>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
            $msg .= "</tr>";
        }

        $conn->close();

        return ($msg);
    }

    function removerJogador($nFederativo){

        global $conn;
        $msg = "";
        $sql = "DELETE FROM jogador WHERE nFederativo = ".$nFederativo;
        $flag = true;

        if ($conn->query($sql) === TRUE) {
            $msg = "Jogador removido com sucesso!";
        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
          
        $conn->close();

        $res = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($res);
    }
    
    function getDadosJogador($nFederativo){
    
        global $conn;

        $conn->set_charset("utf8");
        
        $row = "";
        $msg = "";
    
        $sql = "SELECT * FROM jogador WHERE nFederativo = ".$nFederativo;
        $result = $conn->query($sql);
    
        $sql1 = "SELECT id, nome FROM clube";
        $result1 = $conn->query($sql1);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
    
        if ($result1->num_rows > 0) {
            while($row1 = $result1->fetch_assoc()) {
                $msg .= "<option value='".$row1['id']."'>".$row1['nome']."</option>";
            }
        }
    
        $conn->close();
    
        $result = array('dadosJogador' => $row, 'nomeClube' => $msg);
    
        return json_encode($result);
    }
    
    function guardaEdit($nFederativoNew, $nFederativoOld, $nome, $email, $idade, $morada, $telefone, $clube, $img){

        global $conn;
        $msg = "";
        $flag = true;

        $sql = "UPDATE jogador SET nFederativo = '".$nFederativoNew."', nome = '".$nome."', email = '".$email."', idade = '".$idade."', morada = '".$morada."', telefone = '".$telefone."', idClube = '".$clube."'  WHERE nFederativo = ".$nFederativoOld;

        if ($conn->query($sql) === TRUE) {
            $msg = "Alterado com sucesso";
            $resp = $this -> uploads($img, $nFederativoOld);

            $res = json_decode($resp, TRUE);

            if($res['flag']){
                $this->updateJogadorImg($res['target'],$nFederativoOld);
            }

        } else {
            $flag = false;
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }
          
        $conn->close();

        $resp = json_encode(array(
            "flag" => $flag,
            "msg" => $msg
        ));

        return ($resp);


    }

    function getInfo($nFederativo){

        global $conn;
        $msg = "";
        $msg1 = "";

        $sql = "SELECT * FROM jogador WHERE nFederativo = ".$nFederativo;
        $result = $conn->query($sql);

        $sql1 = "SELECT clube.id, clube.nome FROM clube INNER JOIN jogador ON clube.id = jogador.idClube WHERE jogador.nFederativo = ".$nFederativo;
        $result1 = $conn->query($sql1);


        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {

                $row1 = $result1->fetch_assoc();

                $msg .= "<tr>";
                $msg .= "<td>".$row['nFederativo']."</td>";
                $msg .= "<td>".$row['nome']."</td>";
                $msg .= "<td>".$row['email']."</td>";
                $msg .= "<td>".$row['idade']."</td>";
                $msg .= "<td>".$row['morada']."</td>";
                $msg .= "<td>".$row['telefone']."</td>";
                $msg .= "<td>".$row1['nome']."</td>";
                $msg .= "<td><img src='".$row['foto']."' height='80px'></td>";
                $msg .= "</tr>";

            }   
        }



        $conn->close();

        return (json_encode($msg, JSON_UNESCAPED_SLASHES));

    }
}

?>