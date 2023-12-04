<?php
    require_once 'class/BancoDeDados.php';

    $busca = isset($_POST['busca']) ? $_POST['busca'] : '';
    if ($busca == '') {
        echo json_encode("<p>Preencha o campo acima para buscar um EPI</p>");
        exit;
    }

    $busca = "%$busca%";

    $banco = new BancoDeDados;
    $sql = "SELECT * FROM EPI_CADASTROS WHERE UPPER(codigo) LIKE UPPER(?) OR UPPER(descricao) LIKE UPPER(?)";
    $params = [$busca, $busca];
    $dados = $banco->selecionarRegistros($sql, $params);


    if (count($dados) > 0) {
    
        $stringData = '';
        foreach ($dados as $linha) {
            $id_epi = $linha['id_produto'];
            $codigo = $linha['codigo'];
            $descricao = $linha['descricao'];

            $stringData = $stringData . 
            "
            <a onclick='selecionarEPI($id_epi, \"$descricao\")' class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                <div class='d-flex gap-2 w-100 justify-content-between'>
                    <div>
                    <h6 class='mb-0'>{$descricao}</h6>
                    <h6 class='mb-0'>{$codigo}</h6>
                    </div>        
                </div>
            </a>
            ";
        }

        echo json_encode($stringData);
    }else{
        echo json_encode("<p>Nenhum EPI encontrado!</p>");
    }
