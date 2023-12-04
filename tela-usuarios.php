<!doctype html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Usuarios | LTControl</title>

        <link href="/assets/css/usuarios.css" rel="stylesheet">

    </head>
    <body>
        
        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
            <div class="list-group">
                <?php
                    require_once "application/class/BancoDeDados.php";

                    error_reporting(E_ALL);
                    ini_set('display_errors', '1');

                    $banco = new BancoDeDados;
                    $sql = "SELECT * FROM USUARIOS";
                
                    $dados = $banco->selecionarTudo($sql);
                    
                    foreach ($dados as $usuario) {
                        print("
                            <a href='index.php?tela=cadastro-usuario&codigo={$usuario['codigo']}' class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                            <img src='application/upload/{$usuario['imagem']}' alt='S/I' width='32' height='32' class='rounded-circle flex-shrink-0'>
                            <div class='d-flex gap-2 w-100 justify-content-between'>
                                <div>
                                <h6 class='mb-0'>{$usuario['nome']}</h6>
                                <p class='mb-0 opacity-75'>{$usuario['usuario']}</p>
                                </div>
                            <small class='opacity-50 text-nowrap'>Código Interno: #{$usuario['codigo']}</small>
                            </div>
                            </a>
                        ");
                    } 
                ?>
            </div>
        </div>
        <!-- Botão de Cadastro do EPI -->
        <button onclick="abrirCadastroUsuario()" type="button" class="adicionar btn btn-primary btn-floating rounded-circle flex-shrink-0" >
           <i class="fas fa-plus add-icone"></i>
        </button> 
    </body>
    
</html>