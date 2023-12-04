<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $idColaborador = isset($_POST["idColaborador"]) ? $_POST["idColaborador"] : "";

    if($idColaborador == ''){
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;

    $sql_aux = "SELECT id_emprestimo FROM EMPRESTIMOS WHERE id_colaborador = ?";
    $params_aux = [
        $idColaborador
    ];
    $dados = $banco->selecionarRegistros($sql_aux, $params_aux);

    if($dados){
        echo json_encode(2);
        exit;
    }


    
    $sql = "DELETE FROM COLABORADORES WHERE id_colaborador = ?";
    $params = [
        $idColaborador
    ];
    
    $banco->executarComando($sql, $params);

    echo json_encode(1);