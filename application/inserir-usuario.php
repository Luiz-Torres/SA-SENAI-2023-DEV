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
    $formulario['codigo'] = isset($_POST['txt_codigo_interno']) ? $_POST['txt_codigo_interno'] : "";
    $formulario['nome'] = isset($_POST['txt_nome']) ? $_POST['txt_nome'] : "";
    $formulario['usuario'] = isset($_POST['txt_usuario']) ? $_POST['txt_usuario'] : "";
    $formulario['senha'] = isset($_POST['txt_senha']) ? $_POST['txt_senha'] : "";

    if(in_array("", $formulario)){
        print("<script>
        alert('Há campos em branco! Verifique!');
        window.location = '../index.php?tela=cadastro-usuario';
        </script>");
        exit;
    }
    

    //CRIANDO UMA VÁRIAVEL CÓDIGO PARA PREENCHER NO BANCO DE DADOS
    if($formulario['codigo'] == 'NOVO'){
        //BUSCANDO ULTIMO CÓDIGO DO BANCO
        $sqlSecundario = 'SELECT MAX(codigo) FROM USUARIOS';

        $ultimoCodigo = $banco->selecionarTudo($sqlSecundario);

        //ATRIBUINDO ULTIMO CÓDIGO NO BANCO PARA UMA VARIAVEL
        if(!is_null($ultimoCodigo)){
            foreach ($ultimoCodigo as $cod => $value) {
                $codigo = $value['MAX(codigo)'];
                $codigo++;
            }
        }else{
            $codigo = 1;
        }

        //DEIXANDO UM TAMANHO PADRÃO DE 6 CARACTERES
        $codigo = str_pad($codigo, 6, 0, STR_PAD_LEFT);
    }else{
        $codigo = $formulario['codigo'];
    }

    //PASSANDO AS IMAGENS PARA A PASTA DE UPLOADS
    if ($_FILES['file_imagem']['size'] > 0) {
        date_default_timezone_set('America/Sao_Paulo');
        $nome_imagem = "imagem_{$codigo}_" . date('Y-m-d_H-i-s') . '.jpg';
        move_uploaded_file($_FILES['file_imagem']['tmp_name'], "upload/$nome_imagem");
    } else {
        if($_POST['txt_nomeImagem'] == ''){
            $nome_imagem = 'default/not-found.jpg';
        }else{
            $nome_imagem = $_POST['txt_nomeImagem'];
        }   
    }


    //INSERINDO E ATUALIZANDO BANCO DE DADOS
    if($formulario['codigo'] == 'NOVO'){
        $sql = 'INSERT INTO USUARIOS(codigo, nome, usuario, senha, imagem) VALUES(LPAD(?,6,0),?,?,?,?)';
        $params = [
            $codigo,
            $formulario['nome'],
            $formulario['usuario'],
            $formulario['senha'],
            $nome_imagem
        ];

        $mensagem = 'Usuário cadastrado com sucesso';
    }else{
        $formulario['id_usuario'] = isset($_POST['txt_id']) ? $_POST['txt_id'] : "";
        $codigo = $formulario['codigo'];

        $sql = 'UPDATE USUARIOS SET nome=?, usuario=?, senha=?, imagem=? WHERE id_usuario = ?';
        $params = [
            $formulario['nome'],
            $formulario['usuario'],
            $formulario['senha'],
            $nome_imagem,
            $formulario['id_usuario']
        ];
        $mensagem = 'Usuário salvo com sucesso';
    }
    

    $banco->executarComando($sql, $params);

    print "<script>
        alert('{$mensagem}');
        window.location = '../index.php?tela=cadastro-usuario&codigo={$codigo}';
    </script>";