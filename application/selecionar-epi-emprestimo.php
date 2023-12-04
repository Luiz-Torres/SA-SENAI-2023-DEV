<?php
    require_once 'class/BancoDeDados.php';

    $idEmprestimo = isset($_POST['idEmprestimo']) ? $_POST['idEmprestimo'] : '';
    if ($idEmprestimo == '') {
        echo json_encode(0);
        exit;
    }

    $banco = new BancoDeDados;
    $sql = "SELECT EC.codigo, EC.descricao, CA.numero_ca, EI.qtd, NS.serie, EL.numero_lote FROM EMPRESTIMOS_ITENS EI JOIN EPI_CADASTROS EC ON EI.id_epi = EC.id_produto JOIN CA_EPI CA ON EI.id_ca_epi = CA.id_ca LEFT JOIN EPI_NUM_SERIE NS ON EI.id_num_serie = NS.id_num_serie LEFT JOIN EPI_LOTES EL ON EI.id_lote_epi = EL.id_lote WHERE id_emprestimo = ?";
    $params = [$idEmprestimo];
    $dados = $banco->selecionarRegistros($sql, $params);

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