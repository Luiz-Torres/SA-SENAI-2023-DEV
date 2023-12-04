<?php
    require_once 'class/BancoDeDados.php';

    $busca = isset($_POST['busca']) ? $_POST['busca'] : '';
    if ($busca == '') {
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;
    $params = [$busca];

    $sql_aux = "SELECT id_produto FROM EPI_CADASTROS WHERE id_produto = ? AND controla_serie = '1'";
    $dados_aux = $banco->selecionarRegistro($sql_aux, $params);

    if (!$dados_aux) {
        echo json_encode(0);
        exit;
    }


    $sql = "SELECT * FROM EPI_NUM_SERIE WHERE UPPER(id_produto) = UPPER(?) AND disponivel = '1'";
    $dados = $banco->selecionarRegistros($sql, $params);


    if (count($dados) > 0) {
    
        $stringData = '';
        foreach ($dados as $linha) {
            $id_epi = $linha['id_produto'];
            $numero_serie = $linha['serie'];
            $id_serie = $linha['id_num_serie'];

            $stringData = $stringData . 
            "
            <option value='$id_serie'>$numero_serie</option>
            ";
        }

        echo json_encode($stringData);
    }else{
        echo json_encode(0);
    }
