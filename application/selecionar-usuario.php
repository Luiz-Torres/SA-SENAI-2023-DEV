<?php
    require_once 'class/BancoDeDados.php';

    $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
    if ($codigo == '') {
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;
    $sql = "SELECT * FROM USUARIOS WHERE codigo = LPAD(?,6,0)";
    $params = [$codigo];
    $dados = $banco->selecionarRegistro($sql, $params);
    echo json_encode($dados);