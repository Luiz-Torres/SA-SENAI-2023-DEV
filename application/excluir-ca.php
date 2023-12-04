<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $CA_ids = isset($_POST["CA_ids"]) ? $_POST["CA_ids"] : "";

    if($CA_ids == ''){
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;

    $sql_aux = "SELECT id_emprestimo FROM EMPRESTIMOS_ITENS WHERE id_ca_epi = ?";
    foreach($CA_ids as $id){
        $params_aux = [
            $id
        ];
        $dados = $banco->selecionarRegistros($sql_aux, $params_aux);

        if($dados){
            echo json_encode(2);
            exit;
        }
    }
    



    $sql = "DELETE FROM CA_EPI WHERE id_ca = ?";


    foreach($CA_ids as $id){
        $params = [
            $id
        ];
        $banco->executarComando($sql, $params);
    }

    echo json_encode(1);