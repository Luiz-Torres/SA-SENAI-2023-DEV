<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $EPI_id = isset($_POST["idEPI"]) ? $_POST["idEPI"] : "";

    if($EPI_id == ''){
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;

    $sql_aux = "SELECT id_emprestimo FROM EMPRESTIMOS_ITENS WHERE id_epi = ?";
    $params_aux = [
        $EPI_id
    ];
    $dados = $banco->selecionarRegistros($sql_aux, $params_aux);

    if($dados){
        echo json_encode(2);
        exit;
    }


    $sql = "DELETE FROM EPI_CADASTROS WHERE id_produto = ?";
    $params = [
        $EPI_id
    ];
    
    $banco->executarComando($sql, $params);

    echo json_encode(1);