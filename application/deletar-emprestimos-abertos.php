<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $banco = new BancoDeDados;

    $sql_busca = "SELECT id_emprestimo FROM EMPRESTIMOS WHERE status_emprestimo = 'Em Aberto'";
    $sql_delete_itens = "DELETE FROM EMPRESTIMOS_ITENS WHERE id_emprestimo = ?";
    $sql_delete_emprestimo = "DELETE FROM EMPRESTIMOS WHERE id_emprestimo = ?";

    $dados = $banco->selecionarTudo($sql_busca);
    foreach ($dados as $id){
        $params = [];
        array_push($params, $id['id_emprestimo']);
        $banco->executarComando($sql_delete_itens, $params);
        $banco->executarComando($sql_delete_emprestimo, $params);
    }

    echo json_encode(1);