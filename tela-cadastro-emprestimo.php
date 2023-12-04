<!doctype html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Emprestimos | LTControl</title>

        <link href="/assets/css/emprestimos.css" rel="stylesheet">

    </head>
    <body onload="carregarInfo()" onunload="RemoverEmprestimosAbertos()" onpagehide="RemoverEmprestimosAbertos()">
        <form id="form_emprestimos" method="post" action="javascript:CadastrarEmprestimo();" enctype="multipart/form-data">
            <div class="py-md-5">
                <div class="modal-header row">
                    <h4 class="title">Empréstimo</h4>
                    <button type="button" onclick="AbrirEmprestimos()" class="close" aria-hidden="true">&times;</button>
                </div>
                <div class="row">
                    <div class="modal-body row col-12">
                        <input type="hidden" name="txt_id" id="txt_id">
                        
                        <div class="form-group col-6">
                            <label>Código Interno</label>
                            <input type="text" class="form-control w-50" name="txt_codigo_interno" id="txt_codigo_interno" value="NOVO" required readonly>
                        </div>


                        <div class="form-group col-12 mb-3">
                            <label>Colaborador</label>
                            <input onchange="cadastrarEmprestimo()" type="hidden" class="form-control w-25" name="txt_id_colaborador" id="txt_id_colaborador">
                            <input oninput="abrirBuscaColaborador()" type="text" class="form-control w-50" name="txt_colaborador" id="txt_colaborador" required>
                        </div>

                        <div class="form-group col-12">
                            <label>Observação</label>
                            <textarea class="form-control w-50" name="txt_observacoes" id="txt_observacoes"></textarea>
                        </div>

                        <div class="form-group row col-6 mb-3 w-50" style="margin-left=0px; margin-right=0px;">
                            <label class="col-12 w-50">Inserir EPI</label>
                            <input type="text" placeholder="ID EPI" class="form-control col-12 w-50" name="txt_id_epi" id="txt_id_epi" required hidden>
                            <input oninput="abrirBuscaEPI()" type="text" placeholder="Inserir EPI" class="form-control col-12 w-50" name="txt_epi" id="txt_epi" required readonly>

                            <select type="text" placeholder="Inserir CA" class="form-control col-3 w-50" name="txt_ca_epi" id="txt_ca_epi" required readonly></select>
                            <input type="number" placeholder="Inserir Quantidade" class="form-control col-3 w-50" name="txt_qtd_epi" id="txt_qtd_epi" required readonly>
                            <select type="text" placeholder="Inserir Número de Série" class="form-control col-3 w-50" name="txt_serie_epi" id="txt_serie_epi" required readonly></select>
                            <select type="text" placeholder="Inserir Lote" class="form-control col-3 w-50" name="txt_lote_epi" id="txt_lote_epi" required readonly></select>
                            <a onclick="inserirEPI()" class="btn btn-secondary my-2">Adicionar EPI</a>
                        </div>

                        <h6 class="col-12">EPI's Adicionados</h2>
                        <div class="table-responsive w-50">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="">
                                        <th scope="col-3">Código</th>
                                        <th scope="col-4">EPI</th>
                                        <th scope="col-1">CA</th>
                                        <th scope="col-1">Quantidade</th>
                                        <th scope="col-1">Série</th>
                                        <th scope="col-1">Lote</th>
                                        <th scope="col-1" class="ms-auto" style="text-align:right;"></th>
                                    </tr>
                                </thead>
                                <tbody id="epis_adicionados">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer CRUD-bar" id="crud-footer">
                    <button onclick="ExcluirEmprestimo()" id="btn_excluir" class="btn btn-secondary btn-alert" disabled>Excluir</button>
                    <button onclick="AjustarURL()" class="btn btn-secondary btn-alert" type="reset">Novo</button>
                    <button type="submit" id="btn_salvar" class="btn btn-success">Salvar</button>  
                </div>
            </div>
            
            
        <!-- Modal Colaborador -->  
        <div id="adicionar-colaborador" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="select-colaborador">
                        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
                            <div class="list-group" id="adicionar-colaborador-lista">
                                <?php
                                    require_once "application/class/BancoDeDados.php";

                                    error_reporting(E_ALL);
                                    ini_set('display_errors', '1');
    
                                    print("
                                        <input oninput='buscarColaborador()' type='text' class='form-control' name='txt_colaborador_busca' id='txt_colaborador_busca'>
                                    ");
                                ?>

                                <div id="lista-colaboradores-modal" name="lista-colaboradores-modal">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onclick="FecharColaboradores()" class="btn btn-success">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal EPI -->  
        <div id="adicionar-epi" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="select-epi">
                        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
                            <div class="list-group" id="adicionar-epi-lista">
                                <?php
                                    require_once "application/class/BancoDeDados.php";

                                    error_reporting(E_ALL);
                                    ini_set('display_errors', '1');
    
                                    print("
                                        <input oninput='buscarEPI()' type='text' class='form-control' name='txt_epi_busca' id='txt_epi_busca'>
                                    ");
                                ?>

                                <div id="lista-epi-modal" name="lista-epi-modal">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onclick="FecharEPI()" class="btn btn-success">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        </form>
        <script src="assets/javascript/tela-cadastro-emprestimo.js"></script>
        <script>
            function carregarInfo(){
                <?php
                    if(isset($_GET['codigo']) && $_GET['codigo'] != 'novo'){
                        print "
                            $.ajax({
                                method: 'post',
                                url: 'application/selecionar-emprestimo.php',
                                dataType: 'json',
                                data: {
                                    codigo: {$_GET['codigo']}
                                },
                                success: function(retorno) {
                                    // Imprimir os dados do retorno
                                    $('#txt_id').val(retorno['id_emprestimo']);
                                    $('#txt_codigo_interno').val(retorno['numero']);
                                    $('#txt_id_colaborador').val(retorno['id_colaborador']);
                                    $('#txt_colaborador').val(retorno['nome']);
                                    $('#txt_observacoes').val(retorno['observacoes']);

                                    $('#btn_excluir').removeAttr('disabled');
                                    $('#txt_colaborador').prop('readonly', true);
                                    $('#txt_observacoes').prop('readonly', true);
                                    $('#btn_salvar').attr('disabled', true);
                                
                                    carregarEPIS();
                                }
                                
                            });
                            
                            ";
                    }else{
                        print"
                            $.ajax({
                                method: 'post',
                                url: 'application/deletar-emprestimos-abertos.php',
                                dataType: 'json',
                                success: function(retorno) {
                                
                                }
                                
                            });


                        ";
                    };
                ?>
            }

            function carregarEPIS(){
                var idEmprestimo = document.getElementById('txt_id').value

                $.ajax({
                    method: 'post',
                    url: 'application/selecionar-epi-emprestimo.php',
                    dataType: 'json',
                    data: {
                        idEmprestimo: idEmprestimo
                    },
                    success: function(retorno) {

                        $('#epis_adicionados').html(retorno);

                    }    
                })
            }

            function ExcluirEPI(){
                opcao = confirm("Deseja realmente excluir esse empréstimo?");

                if(opcao){
                    idEmprestimo = document.getElementById('txt_id').value;

                    $.ajax({
                            method: 'post',
                            url: 'application/excluir-emprestimo.php',
                            dataType: 'json',
                            data: {
                                idEmprestimo: idEmprestimo
                            },
                            success: function(retorno) {
                                if(retorno == 1){
                                    window.location = 'index.php?tela=emprestimos';
                                }
                            }
                        })
                }  
            }
        </script>
    </body>
</html>

