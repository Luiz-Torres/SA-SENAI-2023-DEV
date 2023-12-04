<?php
    //IMPORTAÇÕES
    require_once 'class/BancoDeDados.php';

    //CRIANDO CONEXÃO NO BANCO DE DADOS;
    $banco = new BancoDeDados;
    $banco->executarNoParams("SET NAMES UTF8mb4"); 

    //ATIVANDO ERROS DO PHP PARA TODOS OS TIPOS DE NAVEGADORES
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    //VALIDANDO INFORMAÇÕES ESSENCIAS
    $formulario['idEmprestimo'] = isset($_POST['idEmprestimo']) ? $_POST['idEmprestimo'] : "";
    $formulario['EPI_selecionado'] = isset($_POST['EPI_selecionado']) ? $_POST['EPI_selecionado'] : "";
    $formulario['CA_selecionadas'] = isset($_POST['CA_selecionadas']) ? $_POST['CA_selecionadas'] : "";
    $formulario['QTD_selecionada'] = isset($_POST['QTD_selecionada']) ? $_POST['QTD_selecionada'] : "";

    if(in_array("", $formulario)){
        echo json_encode(0);
        exit;
    }

    $sql_confere_quantidade = "SELECT qtd FROM EPI_CADASTROS WHERE id_produto = ?";
    $params_confere_quantidade = [
        $formulario['EPI_selecionado']
    ];

    $dados_confere_quantidade  = $banco->selecionarRegistro($sql_confere_quantidade, $params_confere_quantidade);

    if($formulario['QTD_selecionada'] > $dados_confere_quantidade['qtd']){
        echo json_encode(2);
        exit;
    }

    //INFORMAÇÕES OPCIONAIS E SITUACIONAIS
    $formulario['SERIE_selecionada'] = isset($_POST['SERIE_selecionada']) ? $_POST['SERIE_selecionada'] : "";
    $formulario['LOTE_selecionado'] = isset($_POST['LOTE_selecionado']) ? $_POST['LOTE_selecionado'] : "";

    if($formulario['LOTE_selecionado'] != ''){
        $sql_confere_lote = "SELECT qtd_disponivel FROM EPI_LOTES WHERE id_lote = ?";
        $params_confere_lote = [
            $formulario["LOTE_selecionado"]
        ];

        $dados_confere_lote = $banco->selecionarRegistro($sql_confere_lote, $params_confere_lote);

        if($formulario['QTD_selecionada'] > $dados_confere_lote['qtd_disponivel']){
            echo json_encode(3);
            exit;
        }
    }

    if($formulario['SERIE_selecionada'] != ''){
        if($formulario['QTD_selecionada'] > 1){
            echo json_encode(4);
            exit;
        }
    }
    

    $sql_aux = "INSERT INTO EMPRESTIMOS_ITENS(id_emprestimo, id_epi, id_ca_epi, qtd";
    $sql_aux_2 =  ") VALUES(?,?,?,?";
    $sql_aux_3 =  ")";  

    $params = [
        $formulario['idEmprestimo'],
        $formulario['EPI_selecionado'],
        $formulario['CA_selecionadas'],
        $formulario['QTD_selecionada']
    ];

    if($formulario['SERIE_selecionada'] != ''){
        $sql_aux = $sql_aux . ", id_num_serie";
        $sql_aux_2 = $sql_aux_2 . ",?";
        array_push($params, $formulario['SERIE_selecionada']); 
    }

    if($formulario['LOTE_selecionado'] != ''){
        $sql_aux = $sql_aux . ", id_lote_epi";
        $sql_aux_2 = $sql_aux_2 . ",?";
        array_push($params, $formulario['LOTE_selecionado']); 
    }

    $sql = $sql_aux . $sql_aux_2 . $sql_aux_3;

    //INSERINDO E ATUALIZANDO BANCO DE DADOS
    //$sql = 'INSERT INTO EMPRESTIMOS_ITENS(id_emprestimo, id_epi, id_ca_epi, qtd, id_num_serie, id_lote_epi) VALUES(?,?,?,?,?,?)';
    // $params = [
    //     $formulario['idEmprestimo'],
    //     $formulario['EPI_selecionado'],
    //     $formulario['CA_selecionadas'],
    //     $formulario['QTD_selecionada'],
    //     $formulario['SERIE_selecionada'],
    //     $formulario['LOTE_selecionado']
    // ];

    $banco->executarComando($sql, $params);

    //$sql_secundario = "SELECT EC.codigo, EC.descricao, CA.numero_ca, EI.qtd, NS.serie FROM EMPRESTIMOS_ITENS EI JOIN EPI_CADASTROS EC ON EI.id_epi = EC.id_produto JOIN CA_EPI CA ON EI.id_ca_epi = CA.id_ca JOIN EPI_NUM_SERIE NS ON EI.id_num_serie = NS.id_num_serie WHERE id_emprestimo = ?";
    $sql_secundario = "SELECT EC.codigo, EC.descricao, CA.numero_ca, EI.qtd, NS.serie, EL.numero_lote FROM EMPRESTIMOS_ITENS EI JOIN EPI_CADASTROS EC ON EI.id_epi = EC.id_produto JOIN CA_EPI CA ON EI.id_ca_epi = CA.id_ca LEFT JOIN EPI_NUM_SERIE NS ON EI.id_num_serie = NS.id_num_serie LEFT JOIN EPI_LOTES EL ON EI.id_lote_epi = EL.id_lote WHERE id_emprestimo = ?";
    $params_secundario = [
        $formulario['idEmprestimo']
    ];

    $dados = $banco->selecionarRegistros($sql_secundario, $params_secundario);

    $stringData = '';

    foreach($dados as $linha) {
        $stringData = $stringData . "
        <tr>
            <td>{$linha['codigo']}</td>
            <td>{$linha['descricao']}</td>
            <td>{$linha['numero_ca']}</td>
            <td style='text-align:center;'>{$linha['qtd']}</td>
            <td>{$linha['serie']}</td>
            <td>{$linha['numero_lote']}</td>
            <td style='text-align:right;'>X</td>
        </tr>
        ";
    }
    
    
    echo json_encode($stringData);
    exit;
