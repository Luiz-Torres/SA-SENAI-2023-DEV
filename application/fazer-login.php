<?php
    require_once 'class/BancoDeDados.php';

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $formulario['usuario'] = isset($_POST['txt_usuario']) ? $_POST['txt_usuario'] : "";
    $formulario['senha'] = isset($_POST['txt_senha']) ? $_POST['txt_senha'] : "";

    if(in_array("", $formulario)){
        print("<script>
        alert('Há campos em branco! Verifique!');
        window.location = '../login.php';
        </script>");
        exit;
    }

    $banco = new BancoDeDados;
    $sql = 'SELECT id_usuario, nome FROM USUARIOS WHERE usuario = ? AND senha = ?';
    $params = [
        $formulario['usuario'], 
        $formulario['senha']
    ];

    print("<script>
        alert('TESTE!');
        </script>");

    $dados = $banco->selecionarRegistro($sql, $params);

    print("<script>
        alert('TESTE!');
        </script>");

    if(is_array($dados)){
        print("<script>
        alert('LOGANDO!');
        </script>");

        session_start();
        $_SESSION['logado'] = true;
        $_SESSION['nome'] = $dados['nome'];
        $_SESSION['id_usuario'] = $dados['id_usuario'];

        print("<script>
        alert('LOGADO!');
        </script>");

        header('LOCATION: ../index.php?tela=estoque');
        exit;
    }else{
        print("<script>
        alert('Dados Inválidos! Não existe esse usuário com essa senha!');
        window.location = '../login.php';
        </script>");
        exit;
    }

