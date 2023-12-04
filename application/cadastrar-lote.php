<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $formulario['idEPI'] = isset($_POST["idEPI"]) ? $_POST["idEPI"] : "";
    $formulario["lote"] = isset($_POST['num_lote']) ? $_POST['num_lote'] : "";
    $formulario["validade"] = isset($_POST["data_validade"]) ? $_POST["data_validade"] : "";
    $formulario["qtd"] = isset($_POST["qtd"]) ? $_POST["qtd"] : "";
    $dataAtual = date('Y-m-d H:i:s');

    if(!is_array($formulario) || in_array("", $formulario)){
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;
    $sql = "INSERT INTO EPI_LOTES(id_epi, numero_lote, data_cadastro, data_validade, qtd_total, qtd_disponivel) VALUES(?,?,?,?,?,?)";
    $params = [
        $formulario['idEPI'],
        $formulario["lote"],
        $dataAtual,
        $formulario["validade"],
        $formulario["qtd"],
        $formulario["qtd"]
    ];

    $banco->executarComando($sql, $params);

    echo json_encode(1);