<!doctype html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Estoque | LTControl</title>

        <link href="/assets/css/estoque.css" rel="stylesheet">

    </head>
    <body onload="gerenciarCarregamentos()">
        <form id="form_epi" method="post" action="application/inserir-produto.php" enctype="multipart/form-data">
            <div class="py-md-5">
                <div class="modal-header">
                    <h4 class="title">Cadastro EPI</h4>
                    <button onclick="AbrirEstoque()" type="button" class="close" aria-hidden="true">&times;</button>
                </div>
                <div class="row">
                    <div class="modal-body row col-9">
                        <input type="hidden" name="txt_id" id="txt_id">

                        <div class="form-group col-6">
                            <label>Código Interno</label>
                            <input type="text" class="form-control w-50" name="txt_codigo_interno" id="txt_codigo_interno" value="NOVO" required readonly>
                        </div>


                        <div class="form-group col-12 mb-3">
                            <label>Nome</label>
                            <input type="text" class="form-control w-50" name="txt_nome" id="txt_nome" required>
                        </div>


                        <div class="form-group col-12">
                            <label>Quantidade</label>
                            <input type="number" class="form-control w-50" name="txt_quantidade" id="txt_quantidade" required>
                        </div>


                        <div class="form-group col-12">
                            <label>Observações</label>
                            <textarea class="form-control" name="txt_observacoes" id="txt_observacoes"></textarea>
                        </div>


                        <div class="form-group col-12">
                            <label>Imagem</label>
                            <input type="file" class="form-control w-50" name="file_imagem" id="file_imagem" accept="image/*" onchange="visualizarIMG(this)">
                        </div>


                        <div class="form-group col-4">
                            <div class="">
                                <label for="btn_ca">Controlar CA</label>
                            </div>
                            <a onclick="abrirModalCA()" class='list-group-item list-group-item-action d-flex gap-3 py-3 text-center' name="btn_ca" id="btn_ca">Cadastrar CA</a>
                        </div>


                        <div class="form-group col-4">
                            <div class="">
                                <input type="checkbox" name="controla_serie" id="controla_serie">
                                <label for="controla_serie">Fazer controle de serie</label>
                            </div>
                            <a onclick="abrirModalSerie()" class='list-group-item list-group-item-action d-flex gap-3 py-3 text-center' name="btn_serie" id="btn_serie">Números de Série</a>
                        </div>


                        <div class="form-group col-4">
                            <div class="">
                                <input type="checkbox" name="controla_lote" id="controla_lote">
                                <label for="controla_lote">Fazer controle de lote</label>
                            </div>
                            <a onclick="abrirModalLote()" class='list-group-item list-group-item-action d-flex gap-3 py-3 text-center' name="btn_lote" id="btn_lote">Lotes</a>
                        </div>


                    </div>
                    <div class="row col-3">
                        <div class="col-12">
                            <label class="form-label">Pré Visualização</label><br>
                            <img style="display: block; margin: 0 auto; height: 300px; width: 300px" src="assets/imagens/not-found.jpg" alt="Sem Imagem" id="img_equipamento" name="img_equipamento">
                            <input type="hidden" name="txt_nomeImagem" id="txt_nomeImagem">
                        </div>
                    </div>
                </div>
                <div class="modal-footer CRUD-bar" id="crud-footer">
                    <button onclick="ExcluirEPI()" id="btn_excluir" class="btn btn-secondary btn-alert" disabled>Excluir</button>
                    <button onclick="AjustarURL()" class="btn btn-secondary btn-alert" type="reset">Novo</button>
                    <button type="submit" class="btn btn-success">Salvar</button>  
                </div>
            </div>        
        </form>

        <!-- Modal CA -->
        <div id="adicionar-ca" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="cadastros_ca">
                        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
                            <div class="list-group" id="adicionar-ca-lista">
                                <?php
                                    require_once "application/class/BancoDeDados.php";

                                    error_reporting(E_ALL);
                                    ini_set('display_errors', '1');

                                    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';

                                    if($codigo == '' || $codigo == 'novo'){
                                        print"
                                            <a class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                                                <div class='d-flex gap-2 w-100 justify-content-between'>
                                                    <div>
                                                    <h6 class='mb-0'>Não há nenhuma CA cadastrada ainda para esse produto</h6>
                                                    </div>
                                                </div>
                                            </a>";
                                    }else{
                                        $banco = new BancoDeDados;
                                        $sql = "SELECT  CA.id_ca, CA.numero_ca FROM CA_EPI CA JOIN EPI_CADASTROS E ON CA.id_epi = E.id_produto WHERE E.codigo = ?";
                                        $params = [
                                            $codigo
                                        ];
                                    
                                        $dados = $banco->selecionarRegistros($sql, $params);
                                        
                                        print"
                                            <div class='form-group row'>
                                                <label class='col-12'>Número:</label>
                                                <input type='text' class='form-control col-7' name='txt_numero_ca' id='txt_numero_ca'>
                                                <span class='col-1'></span>
                                                <button onclick='CadastrarCA()' class='btn btn-secondary btn-alert col-4'>Cadastrar</button>
                                            </div>
                                        ";
                                        if(is_array($dados) && !empty($dados)){
                                            foreach ($dados as $ca) {
                                                print("
                                                    <a class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                                                        <div class='d-flex gap-2 w-100 justify-content-between'>
                                                            <div>
                                                            <h6 class='mb-0'>{$ca['numero_ca']}</h6>
                                                            </div>        
                                                        </div>
                                                        <input type='checkbox' name='CA_selecionadas[]' id='ca_{$ca['numero_ca']}' value='{$ca['id_ca']}'>
                                                    </a>
                                                ");
                                            } 
                                        }else{
                                            print"
                                            <a class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                                                <div class='d-flex gap-2 w-100 justify-content-between'>
                                                    <div>
                                                    <h6 class='mb-0'>Não há nenhuma CA cadastrada ainda para esse produto</h6>
                                                    </div>
                                                </div>
                                            </a>";
                                        }
                                    } 
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onclick="ExcluirCA()" class="btn btn-error">Excluir</button>
                            <button onclick="FecharCA()" class="btn btn-success">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Série -->
        <div id="adicionar-serie" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="cadastros_serie">
                        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
                            <div class="list-group" id="adicionar-serie-lista">
                                <?php
                                    require_once "application/class/BancoDeDados.php";

                                    error_reporting(E_ALL);
                                    ini_set('display_errors', '1');

                                    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';

                                    if($codigo == '' || $codigo == 'novo'){
                                        print"
                                            <a class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                                                <div class='d-flex gap-2 w-100 justify-content-between'>
                                                    <div>
                                                    <h6 class='mb-0'>Não há nenhuma série cadastrada ainda para esse produto</h6>
                                                    </div>
                                                </div>
                                            </a>";
                                    }else{
                                        $banco = new BancoDeDados;
                                        $sql = "SELECT  SE.id_num_serie, SE.serie FROM EPI_NUM_SERIE SE JOIN EPI_CADASTROS E ON SE.id_produto = E.id_produto WHERE E.codigo = ? AND SE.disponivel = '1'";
                                        $params = [
                                            $codigo
                                        ];
                                    
                                        $dados = $banco->selecionarRegistros($sql, $params);
                                        
                                        print"
                                            <div class='form-group row'>
                                                <label class='col-12'>Número:</label>
                                                <input type='text' class='form-control col-7' name='txt_numero_serie' id='txt_numero_serie'>
                                                <span class='col-1'></span>
                                                <button onclick='CadastrarSerie()' class='btn btn-secondary btn-alert col-4'>Cadastrar</button>
                                            </div>
                                        ";
                                        if(is_array($dados) && !empty($dados)){
                                            foreach ($dados as $serie) {
                                                print("
                                                    <a class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                                                        <div class='d-flex gap-2 w-100 justify-content-between'>
                                                            <div>
                                                            <h6 class='mb-0'>{$serie['serie']}</h6>
                                                            </div>        
                                                        </div>
                                                        <input type='checkbox' name='Serie_selecionadas[]' id='ca_{$serie['serie']}' value='{$serie['id_num_serie']}'>
                                                    </a>
                                                ");
                                            } 
                                        }else{
                                            print"
                                            <a class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                                                <div class='d-flex gap-2 w-100 justify-content-between'>
                                                    <div>
                                                    <h6 class='mb-0'>Não há nenhuma série cadastrada ainda para esse produto</h6>
                                                    </div>
                                                </div>
                                            </a>";
                                        }
                                    } 
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onclick="ExcluirSerie()" class="btn btn-error">Excluir</button>
                            <button onclick="FecharSerie()" class="btn btn-success">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>                          


        <!-- Modal Lote -->
        <div id="adicionar-lote" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="cadastros_lote">
                        <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
                            <div class="list-group" id="adicionar-lote-lista">
                                <?php
                                    require_once "application/class/BancoDeDados.php";

                                    error_reporting(E_ALL);
                                    ini_set('display_errors', '1');

                                    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';

                                    if($codigo == '' || $codigo == 'novo'){
                                        print"
                                            <a class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                                                <div class='d-flex gap-2 w-100 justify-content-between'>
                                                    <div>
                                                    <h6 class='mb-0'>Não há nenhum lote cadastrado ainda para esse produto</h6>
                                                    </div>
                                                </div>
                                            </a>";
                                    }else{
                                        $banco = new BancoDeDados;
                                        $sql = "SELECT  EL.id_lote, EL.numero_lote, EL.qtd_disponivel, EL.data_validade FROM EPI_LOTES EL JOIN EPI_CADASTROS EC ON EL.id_epi = EC.id_produto WHERE EC.codigo = ?";
                                        $params = [
                                            $codigo
                                        ];
                                    
                                        $dados = $banco->selecionarRegistros($sql, $params);
                                        
                                        print"
                                            <div class='form-group row'>
                                                <label class='col-8'>Número:</label>
                                                <label class='col-4'>Validade:</label>
                                                <input type='text' class='form-control col-7' name='txt_numero_lote' id='txt_numero_lote'>
                                                <span class='col-1'></span>
                                                <input type='date' class='form-control col-4' name='txt_validade_lote' id='txt_validade_lote'>
                                                
                                                <label class='col-12 mt-1'>Quantidade:</label>
                                                <input type='number' class='form-control col-7' name='txt_qtd_lote' id='txt_qtd_lote'>
                                                <span class='col-1'></span>
                                                <button onclick='CadastrarLote()' class='btn btn-secondary btn-alert col-4'>Cadastrar</button>
                                            </div>
                                        ";
                                        if(is_array($dados) && !empty($dados)){
                                            foreach ($dados as $lote) {
                                                print("
                                                    <a class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                                                        <div class='d-flex gap-2 w-100 justify-content-between'>
                                                            <div>
                                                                <h6 class='mb-0'>{$lote['numero_lote']}</h6>
                                                                <p class='mb-0'>Quantidade: {$lote['qtd_disponivel']}</p>
                                                                <p class='mb-0'>Validade: {$lote['data_validade']}</p>
                                                            </div>        
                                                        </div>
                                                        <input type='checkbox' name='Lote_selecionadas[]' id='ca_{$lote['numero_lote']}' value='{$lote['id_lote']}'>
                                                    </a>
                                                ");
                                            } 
                                        }else{
                                            print"
                                            <a class='list-group-item list-group-item-action d-flex gap-3 py-3' aria-current='true'>
                                                <div class='d-flex gap-2 w-100 justify-content-between'>
                                                    <div>
                                                    <h6 class='mb-0'>Não há nenhum lote cadastrado ainda para esse produto</h6>
                                                    </div>
                                                </div>
                                            </a>";
                                        }
                                    } 
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button onclick="ExcluirLote()" class="btn btn-error">Excluir</button>
                            <button onclick="FecharLote()" class="btn btn-success">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 


        <script src='assets/javascript/tela-cadastro-epi.js'></script>
        <script>
            function carregarInfo(){
                <?php
                    if(isset($_GET['codigo']) && $_GET['codigo'] != 'novo'){
                        print "
                            $.ajax({
                                method: 'post',
                                url: 'application/selecionar-produto.php',
                                dataType: 'json',
                                data: {
                                    codigo: {$_GET['codigo']}
                                },
                                success: function(retorno) {
                                    // Imprimir os dados do retorno
                                    $('#txt_id').val(retorno['id_produto']);
                                    $('#txt_codigo_interno').val(retorno['codigo']);
                                    $('#txt_nomeImagem').val(retorno['imagem']);
                                    if(retorno['imagem'] == '' || retorno['imagem'] == null){
                                        $('#img_equipamento').prop('src', 'assets/imagens/not-found.jpg');
                                    }else{
                                        $('#img_equipamento').prop('src', 'application/upload/' + retorno['imagem']);
                                    }
                                    $('#txt_nome').val(retorno['descricao']);
                                    $('#txt_observacoes').val(retorno['observacoes']);
                                    $('#txt_quantidade').val(retorno['qtd']);

                                    if(retorno['controla_serie'] == 1){
                                        document.getElementById('controla_serie').checked = true;
                                    }

                                    if(retorno['controla_lote'] == 1){
                                        document.getElementById('controla_lote').checked = true;
                                    }

                                    $('#btn_excluir').removeAttr('disabled');
                                }
                                
                            });";
                    };
                ?>
            }

            function ExcluirEPI(){
                opcao = confirm("Deseja realmente excluir esse EPI?");

                if(opcao){
                    idEPI = document.getElementById('txt_id').value;

                    $.ajax({
                            method: 'post',
                            url: 'application/excluir-epi.php',
                            dataType: 'json',
                            data: {
                                idEPI: idEPI
                            },
                            success: function(retorno) {
                                if(retorno == 1){
                                    window.location = 'index.php?tela=estoque';
                                }else if(retorno == 2){
                                    alert("Não foi possível excluir o EPI pois há empréstimos vinculados!");
                                    location.reload();
                                }
                            }
                        })
                }  
            }

            function ExcluirCA(){

                var CA_selecionadas = document.querySelectorAll("input[name='CA_selecionadas[]']");
                var CA_marcadas = [];
                var counter = 0;

                CA_selecionadas.forEach(CA_atual => {
                    if(CA_atual.checked){
                        CA_marcadas[counter] = CA_atual;
                        counter++;
                    }
                });

                var CA_ids = Array.from(CA_marcadas).map(input => input.value);

                $.ajax({
                    method: 'post',
                    url: 'application/excluir-ca.php',
                    dataType: 'json',
                    data: {
                        CA_ids: CA_ids,
                    },
                    success: function(retorno) {
                        if(retorno == 1){
                            location.reload();
                            abrirModalCA();
                        }else if(retorno == 2){
                            alert("Não foi possível excluir as CAs pois há empréstimos vinculados!");
                            location.reload();
                        }
                    }
                })
            }

            function ExcluirLote(){
                var Lote_selecionadas = document.querySelectorAll("input[name='Lote_selecionadas[]']");
                var Lote_marcadas = [];
                var counter = 0;

                Lote_selecionadas.forEach(Lote_atual => {
                    if(Lote_atual.checked){
                        Lote_marcadas[counter] = Lote_atual;
                        counter++;
                    }
                });

                var lote_ids = Array.from(Lote_marcadas).map(input => input.value);

                $.ajax({
                    method: 'post',
                    url: 'application/excluir-lote.php',
                    dataType: 'json',
                    data: {
                        lote_ids: lote_ids,
                    },
                    success: function(retorno) {
                        if(retorno == 1){
                            location.reload();
                            abrirModalLote();
                        }else if(retorno == 2){
                            alert("Não foi possível excluir os Lotes pois há empréstimos vinculados!");
                            location.reload();
                        }
                    }
                })
            }

            function ExcluirSerie(){
                var Serie_selecionadas = document.querySelectorAll("input[name='Serie_selecionadas[]']");
                var Serie_marcadas = [];
                var counter = 0;

                Serie_selecionadas.forEach(Serie_atual => {
                    if(Serie_atual.checked){
                        Serie_marcadas[counter] = Serie_atual;
                        counter++;
                    }
                });

                var Serie_ids = Array.from(Serie_marcadas).map(input => input.value);

                $.ajax({
                    method: 'post',
                    url: 'application/excluir-serie.php',
                    dataType: 'json',
                    data: {
                        Serie_ids: Serie_ids,
                    },
                    success: function(retorno) {
                        if(retorno == 1){
                            location.reload();
                            abrirModalSerie();
                        }else if(retorno == 2){
                            alert("Não foi possível excluir as Séries pois há empréstimos vinculados!");
                            location.reload();
                        }
                    }
                })
            }

            function gerenciarCarregamentos(){
                carregarInfo();
                gerenciarMenu();
            }

            function CadastrarLote(){
                var idEPI = document.getElementById('txt_id').value;
                var num_lote = document.getElementById('txt_numero_lote').value;
                var data_validade = document.getElementById('txt_validade_lote').value;
                var qtd = document.getElementById('txt_qtd_lote').value;

                if(num_lote != ''){
                    $.ajax({
                        method: 'post',
                        url: 'application/cadastrar-lote.php',
                        dataType: 'json',
                        data: {
                            idEPI: idEPI,
                            num_lote: num_lote,
                            data_validade: data_validade,
                            qtd: qtd
                        },
                        success: function(retorno) {
                            if(retorno == 0){
                                alert("Preencha todos os campos!");
                            }else{
                                location.reload();
                            }
                        }
                    })
                }
            }
        </script>
    </body>
    
</html>

