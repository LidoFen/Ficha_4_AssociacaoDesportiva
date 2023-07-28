<?php

require_once '../model/modelJogador.php';

$jogador = new Jogador();

if ($_POST['op'] == 1) {
    $res = $jogador->registaJogador(
        $_POST['nFederativo'],
        $_POST['nome'],
        $_POST['email'],
        $_POST['idade'],
        $_POST['morada'],
        $_POST['telefone'],
        $_POST['clube'],
        $_FILES
    );

    echo ($res);

}else if($_POST['op'] == 2){

    $res = $jogador -> getListaJogadores();
    echo($res);

}else if($_POST['op'] == 3){

    $res = $jogador -> removerJogador($_POST['nFederativo']);
    echo($res);

}else if($_POST['op'] == 4){

    $res = $jogador -> getDadosJogador($_POST['nFederativo']);
    echo($res);

}else if($_POST['op'] == 5){

    $res = $jogador->guardaEdit(
        $_POST['nFederativoNew'],
        $_POST['nFederativoOld'],
        $_POST['nome'],
        $_POST['email'],
        $_POST['idade'],
        $_POST['morada'],
        $_POST['telefone'],
        $_POST['clube'],
        $_FILES
    );

    echo($res);

}else if($_POST['op'] == 7){
    $res = $jogador -> getInfo($_POST['nFederativo']);
    echo($res);

}

?>