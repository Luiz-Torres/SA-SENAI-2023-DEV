<?php
    require_once 'class/BancoDeDados.php';

    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
    if ($codigo == '') {
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;
    $sql = "SELECT E.id_emprestimo, E.numero, E.status_emprestimo, E.id_colaborador, C.nome, E.id_usuario, E.observacoes FROM EMPRESTIMOS E JOIN COLABORADORES C ON E.id_colaborador = C.id_colaborador WHERE numero = LPAD(?,6,0)";
    $params = [$codigo];
    $dados = $banco->selecionarRegistro($sql, $params);
    echo json_encode($dados);