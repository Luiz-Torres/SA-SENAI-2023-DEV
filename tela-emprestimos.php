<!doctype html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Empréstimos | LTControl</title>

        <link href="/assets/css/emprestimos.css" rel="stylesheet">

    </head>
    <body onload="RemoverEmprestimosAbertos()">
        
        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
            <div class="list-group">
                <?php
                    require_once "application/class/BancoDeDados.php";

                    error_reporting(E_ALL);
                    ini_set('display_errors', '1');

                    $banco = new BancoDeDados;
                    $sql = "SELECT E.id_emprestimo, E.numero, C.nome, E.data_emprestimo FROM EMPRESTIMOS E JOIN COLABORADORES C ON E.id_colaborador = C.id_colaborador";
                
                    $dados = $banco->selecionarTudo($sql);
                    
                    foreach ($dados as $emprestimo) {
                        print("
                            <a href='index.php?tela=novo-emprestimo&codigo={$emprestimo['numero']}' class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                            <div class='d-flex gap-2 w-100 justify-content-between'>
                                <div>
                                <h6 class='mb-0'>Empréstimo: #{$emprestimo['numero']}</h6>
                                <p class='mb-0 opacity-75'>{$emprestimo['nome']}</p>
                                </div>
                            <small class='opacity-50 text-nowrap'>{$emprestimo['data_emprestimo']}</small>
                            </div>
                            </a>
                        ");
                    } 
                ?>
            </div>
        </div>
        <!-- Botão de Cadastro do EPI -->
        <button onclick="novoEmprestimo()" type="button" class="adicionar btn btn-primary btn-floating rounded-circle flex-shrink-0" >
           <i class="fas fa-plus add-icone"></i>
        </button> 
        <script>
            function RemoverEmprestimosAbertos(){
                $.ajax({
                    method: 'post',
                    url: 'application/deletar-emprestimos-abertos.php',
                    dataType: 'json',
                    success: function(retorno) {
                    }
                });
            }

        </script>           
    </body>
    
</html>