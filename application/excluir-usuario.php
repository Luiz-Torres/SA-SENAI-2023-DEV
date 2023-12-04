<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $idUsuario = isset($_POST["idUsuario"]) ? $_POST["idUsuario"] : "";

    if($idUsuario == ''){
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;

    $sql_aux = "SELECT id_emprestimo FROM EMPRESTIMOS WHERE id_usuario= ?";
    $params_aux = [
        $idUsuario
    ];
    $dados = $banco->selecionarRegistros($sql_aux, $params_aux);

    if($dados){
        echo json_encode(2);
        exit;
    }


    $sql = "DELETE FROM USUARIOS WHERE id_usuario = ?";
    $params = [
        $idUsuario
    ];
    
    $banco->executarComando($sql, $params);

    echo json_encode(1);