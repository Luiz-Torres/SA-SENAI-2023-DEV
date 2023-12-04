<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $numeroSerie = isset($_POST['num_serie']) ? $_POST['num_serie'] : "";
    $idEPI = isset($_POST["idEPI"]) ? $_POST["idEPI"] : "";

    if($numeroSerie == '' || $idEPI == ''){
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;
    $sql = "INSERT INTO EPI_NUM_SERIE(serie, id_produto, disponivel) VALUES(?,?,?)";
    $params = [
        $numeroSerie,
        $idEPI,
        1
    ];

    $banco->executarComando($sql, $params);

    echo json_encode(1);