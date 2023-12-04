<?php
    //IMPORTAÇÕES
    require_once 'class/BancoDeDados.php';

    //INICIANDO A SESSÃO
    session_start();
    $idUsuario =  $_SESSION['id_usuario'];

    //CRIANDO CONEXÃO NO BANCO DE DADOS;
    $banco = new BancoDeDados;
    $banco->executarNoParams("SET NAMES UTF8mb4"); 

    //ATIVANDO ERROS DO PHP PARA TODOS OS TIPOS DE NAVEGADORES
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    
    //VALIDANDO INFORMAÇÕES ESSENCIAS
    $formulario['numero'] = isset($_POST['codigoEmprestimo']) ? $_POST['codigoEmprestimo'] : "";
    $formulario['idColaborador'] = isset($_POST['idColaborador']) ? $_POST['idColaborador'] : "";


    if(in_array("", $formulario)){
        if(in_array("", $formulario)){
            echo json_encode(0);
            exit;
        }
    }

    //INFORMAÇÕES OPCIONAIS E SITUACIONAIS
    $formulario['id'] = isset($_POST['idEmprestimo']) ? $_POST['idEmprestimo'] : "";
    $formulario['observacoes'] = isset($_POST['observacoes']) ? $_POST['observacoes'] : "";

    //CRIANDO UMA VÁRIAVEL CÓDIGO PARA PREENCHER NO BANCO DE DADOS
    if($formulario['numero'] == 'NOVO'){
        //BUSCANDO ULTIMO CÓDIGO DO BANCO
        $sqlSecundario = 'SELECT MAX(numero) FROM EMPRESTIMOS';

        $ultimoCodigo = $banco->selecionarTudo($sqlSecundario);

        //ATRIBUINDO ULTIMO CÓDIGO NO BANCO PARA UMA VARIAVEL
        if(!is_null($ultimoCodigo)){
            foreach ($ultimoCodigo as $cod => $value) {
                $codigo = $value['MAX(numero)'];
                $codigo++;
            }
        }else{
            $codigo = 1;
        }

        //DEIXANDO UM TAMANHO PADRÃO DE 6 CARACTERES
        $codigo = str_pad($codigo, 6, 0, STR_PAD_LEFT);
    }else{
        $codigo = $formulario['numero'];
    }

    $data_hora = date('Y-m-d H:i:s');
   
    //INSERINDO E ATUALIZANDO BANCO DE DADOS
    if($formulario['numero'] == 'NOVO'){
        $sql = 'INSERT INTO EMPRESTIMOS(numero, status_emprestimo, id_colaborador, id_usuario, data_emprestimo) VALUES(LPAD(?,6,0),?,?,?,?)';
        $params = [
            $codigo,
            "Em Aberto",
            $formulario['idColaborador'],
            $idUsuario,
            $data_hora
        ];
    }else{
        $sql = 'UPDATE EMPRESTIMOS SET numero=?, status_emprestimo=?, id_colaborador=?, id_usuario=?, data_emprestimo=?, observacoes=? WHERE id_emprestimo = ?';
        $params = [
            $codigo,
            "Concluido",
            $formulario['idColaborador'],
            $idUsuario,
            $data_hora,
            $formulario['observacoes'],
            $formulario['id']
        ];
    }

    $banco->executarComando($sql, $params);

    $sql_terciario = "SELECT * FROM EMPRESTIMOS WHERE numero = ?";
    $params_terciario = [
        $codigo
    ];

    $dados = $banco->selecionarRegistro($sql_terciario, $params_terciario);
    
    echo json_encode($dados);

    exit;
