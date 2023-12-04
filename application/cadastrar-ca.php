<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $numeroCA = isset($_POST['num_ca']) ? $_POST['num_ca'] : "";
    $idEPI = isset($_POST["idEPI"]) ? $_POST["idEPI"] : "";

    if($numeroCA == '' || $idEPI == ''){
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;
    $sql = "INSERT INTO CA_EPI(id_epi, numero_ca) VALUES(?,?)";
    $params = [
        $idEPI,
        $numeroCA
    ];

    $banco->executarComando($sql, $params);

    echo json_encode(1);