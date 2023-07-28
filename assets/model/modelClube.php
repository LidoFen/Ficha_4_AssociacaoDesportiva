<?php
require_once 'connection.php';

class Clube {

    function uploads($img, $id){


        $dir = "../imagens/clube".$id."/";
        $dir1 = "assets/imagens/clube".$id."/";
        $flag = false;
        $targetBD = "";
    
        if(!is_dir($dir)){
            if(!mkdir($dir, 0777, TRUE)){
                die ("Erro não é possivel criar o diretório");
            }
        }
      if(array_key_exists('logotipo', $img)){
        if(is_array($img)){
          if(is_uploaded_file($img['logotipo']['tmp_name'])){
            $fonte = $img['logotipo']['tmp_name'];
            $ficheiro = $img['logotipo']['name'];
            $end = explode(".",$ficheiro);
            $extensao = end($end);
    
            $newName = "clube".date("YmdHis").".".$extensao;
    
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

    function updateClubeImg($diretorio, $id){
        global $conn;
        $msg = "";
        $flag = true;

        $sql = "UPDATE clube SET logotipo = '".$diretorio."' WHERE id =".$id;

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

    function registaClube($nome, $localidade, $email, $ano, $telefone, $img){

        global $conn;
        $msg = "";
        $flag = true;

        $sql = "INSERT INTO clube (nome, localidade, email, ano, telefone) VALUES ('".$nome."',  '".$localidade."', '".$email."', '".$ano."', '".$telefone."')";

        if ($conn->query($sql) === TRUE) {
            $msg = "Clube registado com sucesso";
            $lastId = mysqli_insert_id($conn);
            $resp = $this -> uploads($img, $lastId);

            $res = json_decode($resp, TRUE);

            if($res['flag']){
                $this->updateClubeImg($res['target'],$lastId);
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

    function getListaClubes(){

        global $conn;
        $msg = "";

        $sql = "SELECT * FROM clube";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $msg .= "<tr>";
            $msg .= "<td>".$row['nome']."</td>";
            $msg .= "<td>".$row['localidade']."</td>";
            $msg .= "<td>".$row['ano']."</td>";
            $msg .= "<td><button class='btn btn-warning' onclick = 'getDadosClube(".$row['id'].")'><i class='fa fa-pencil'></i></button></td>";
            $msg .= "<td><button class='btn btn-danger' onclick = 'removerClube(".$row['id'].")'><i class='fa fa-trash'></i></button></td>";
            $msg .= "<td><button class='btn btn-primary' onclick = 'getInfo(".$row['id'].")'><i class='fa fa-plus'></i></button></td>";
            $msg .= "</tr>";
        }
        } else {
            $msg .= "<tr>";
            $msg .= "<td></td>";
            $msg .= "<td></td>";
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

    function removerClube($id){

        global $conn;
        $msg = "";
        $sql = "DELETE FROM clube WHERE id = ".$id;
        $flag = true;

        if ($conn->query($sql) === TRUE) {
            $msg = "Clube removido com sucesso!";
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

    function getDadosClube($id){
        global $conn;
        $row = "";

        $sql = "SELECT * FROM clube WHERE id = ".$id;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        $row = $result->fetch_assoc();

        }

        $conn->close();

        return (json_encode($row));

    }

    function guardaEdit($id, $nome, $localidade, $email, $ano, $telefone, $img){

        global $conn;
        $msg = "";
        $flag = true;

        $sql = "UPDATE clube SET nome = '".$nome."', localidade = '".$localidade."', email = '".$email."', ano = '".$ano."', telefone = '".$telefone."' WHERE id = ".$id;

        if ($conn->query($sql) === TRUE) {
            $msg = "Alterado com sucesso";
            $resp = $this -> uploads($img, $id);

            $res = json_decode($resp, TRUE);

            if($res['flag']){
                $this->updateClubeImg($res['target'],$id);
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

    function getSelectClubes(){
        global $conn;
        $msg = "<option value='-1' disabled selected>Escolha uma opção</option>";

        $sql = "SELECT id, nome FROM clube";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $msg .= "<option value='".$row['id']."'>".$row['nome']."</option>";
        }
        } else {
            $msg = "<option value='-1' disabled>Sem Clubes Registados</option>";
        }

        $conn->close();

        return ($msg);

    }

    function getInfo($id){

        global $conn;
        $msg = "";

        $sql = "SELECT * FROM clube WHERE id = ".$id;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            while($row = $result->fetch_assoc()) {
                $msg .= "<tr>";
                $msg .= "<td>".$row['nome']."</td>";
                $msg .= "<td>".$row['localidade']."</td>";
                $msg .= "<td>".$row['email']."</td>";
                $msg .= "<td>".$row['ano']."</td>";
                $msg .= "<td>".$row['telefone']."</td>";
                $msg .= "<td><img src='".$row['logotipo']."' height='80px'></td>";

            }   
        }

        $conn->close();

        return (json_encode($msg, JSON_UNESCAPED_SLASHES));

    }
}

?>