<?php
    require_once 'class/BancoDeDados.php';

    $busca = isset($_POST['busca']) ? $_POST['busca'] : '';
    if ($busca == '') {
        echo json_encode(0);
        exit;
    }



    $banco = new BancoDeDados;
    $sql = "SELECT * FROM CA_EPI WHERE UPPER(id_epi) = UPPER(?)";
    $params = [$busca];
    $dados = $banco->selecionarRegistros($sql, $params);


    if (count($dados) > 0) {
    
        $stringData = '';
        foreach ($dados as $linha) {
            $id_epi = $linha['id_epi'];
            $numero_ca = $linha['numero_ca'];
            $id_ca = $linha['id_ca'];

            $stringData = $stringData . 
            "
            <option value='$id_ca'>$numero_ca</option>
            ";
        }

        echo json_encode($stringData);
    }else{
        echo json_encode(0);
    }
