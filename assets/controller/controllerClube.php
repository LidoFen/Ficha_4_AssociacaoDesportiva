<?php

require_once '../model/modelClube.php';

$clube = new Clube();

if ($_POST['op'] == 1) {
    $res = $clube->registaClube(
        $_POST['nome'],
        $_POST['localidade'],
        $_POST['email'],
        $_POST['ano'],
        $_POST['telefone'],
        $_FILES
    );

    echo ($res);
}else if($_POST['op'] == 2){

    $res = $clube -> getListaClubes();
    echo($res);

}else if($_POST['op'] == 3){

    $res = $clube -> removerClube($_POST['id']);
    echo($res);

}else if($_POST['op'] == 4){
    $res = $clube -> getDadosClube($_POST['id']);
    echo($res);

}else if($_POST['op'] == 5){
    $res = $clube -> guardaEdit(
        $_POST['id'],        
        $_POST['nome'],
        $_POST['localidade'],
        $_POST['email'],
        $_POST['ano'],
        $_POST['telefone'],
        $_FILES
    );

    echo($res);

}else if($_POST['op'] == 6){
    $res = $clube -> getSelectClubes();
    echo($res);

}else if($_POST['op'] == 7){
    $res = $clube -> getInfo($_POST['id']);
    echo($res);

}

?>