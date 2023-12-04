<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $idEmprestimo = isset($_POST["idEmprestimo"]) ? $_POST["idEmprestimo"] : "";

    if($idEmprestimo == ''){
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;

    $sql_aux = "DELETE FROM EMPRESTIMOS_ITENS WHERE id_emprestimo = ?";
    $params_aux = [
        $idEmprestimo
    ];
    $banco->executarComando($sql_aux, $params_aux);

    $sql = "DELETE FROM EMPRESTIMOS WHERE id_emprestimo= ?";
    $params = [
        $idEmprestimo
    ];
    
    $banco->executarComando($sql, $params);

    echo json_encode(1);