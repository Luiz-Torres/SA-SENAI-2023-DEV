<?php
    require_once 'class/BancoDeDados.php';

    $busca = isset($_POST['busca']) ? $_POST['busca'] : '';
    if ($busca == '') {
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;
    $params = [$busca];

    $sql_aux = "SELECT id_produto FROM EPI_CADASTROS WHERE id_produto = ? AND controla_lote = '1'";
    $dados_aux = $banco->selecionarRegistro($sql_aux, $params);

    if (!$dados_aux) {
        echo json_encode(0);
        exit;
    }


    $sql = "SELECT * FROM EPI_LOTES WHERE UPPER(id_epi) = UPPER(?) AND qtd_disponivel > '0'";
    $dados = $banco->selecionarRegistros($sql, $params);


    if (count($dados) > 0) {
    
        $stringData = '';
        foreach ($dados as $linha) {
            $id_epi = $linha['id_epi'];
            $numero_lote= $linha['numero_lote'];
            $id_lote = $linha['id_lote'];
            $qtd_disponivel = $linha['qtd_disponivel'];

            $stringData = $stringData . 
            "
            <option value='$id_lote'>$numero_lote - QTD: $qtd_disponivel</option>
            ";
        }

        echo json_encode($stringData);
    }else{
        echo json_encode(0);
    }
