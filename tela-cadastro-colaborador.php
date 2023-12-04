<!doctype html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Colaboradores | LTControl</title>

        <link href="/assets/css/colaboradores.css" rel="stylesheet">

    </head>
    <body onload="carregarInfo()">
        <form id="form_colaborador" method="post" action="application/inserir-colaborador.php" enctype="multipart/form-data">
            <div class="py-md-5">
                <div class="modal-header">
                    <h4 class="title">Colaborador</h4>
                    <button type="button" onclick="AbrirColaboradores()" class="close" aria-hidden="true">&times;</button>
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


                        <div class="form-group col-6">
                            <label>Função</label>
                            <input type="text" class="form-control" name="txt_funcao" id="txt_funcao" required>
                        </div>


                        <div class="form-group col-6">
                            <label>Setor</label>
                            <input type="text" class="form-control" name="txt_setor" id="txt_setor" required>
                        </div>

                        <div class="form-group col-6">
                            <label>Turno</label>
                            <input type="text" class="form-control" name="txt_turno" id="txt_turno" required>
                        </div>


                        <div class="form-group col-6">
                            <label>Data Admissão</label>
                            <input type="date" class="form-control" name="data_admissao" id="data_admissao" required>
                        </div>


                        <div class="form-group col-12">
                            <label>Observação</label>
                            <textarea class="form-control" name="txt_observacoes" id="txt_observacoes"></textarea>
                        </div>


                        <div class="form-group col-12">
                            <label>Foto</label>
                            <input onchange="visualizarIMG(this)" type="file" class="form-control w-50" name="file_imagem" id="file_imagem" accept="image/*">
                            
                        </div>
                    </div>
                    <div class="row col-3">
                        <div class="col-12">
                            <label class="form-label">Pré Visualização</label><br>
                            <img style="display: block; margin: 0 auto; height: 300px; width: 300px;" src="assets/imagens/not-found.jpg" id="img_colaborador">
                            <input type="hidden" name="txt_nomeImagem" id="txt_nomeImagem">
                        </div>
                    </div>
                </div>
                <div class="modal-footer CRUD-bar">
                    <button onclick="ExcluirColaborador()" id="btn_excluir" class="btn btn-secondary btn-alert" disabled>Excluir</button>
                    <button onclick="AjustarURL()" class="btn btn-secondary btn-alert" type="reset">Novo</button>
                    <button type="submit" class="btn btn-success">Salvar</button>  
                </div>
            </div>        
        </form>
        <script>
            function carregarInfo(){
                <?php
                    if(isset($_GET['codigo']) && $_GET['codigo'] != 'novo'){
                        print "
                            $.ajax({
                                method: 'post',
                                url: 'application/selecionar-colaborador.php',
                                dataType: 'json',
                                data: {
                                    codigo: {$_GET['codigo']}
                                },
                                success: function(retorno) {
                                    // Imprimir os dados do retorno
                                    $('#txt_id').val(retorno['id_colaborador']);
                                    $('#txt_codigo_interno').val(retorno['codigo']);
                                    $('#txt_nomeImagem').val(retorno['imagem']);
                                    if(retorno['imagem'] == '' || retorno['imagem'] == null){
                                        $('#img_colaborador').prop('src', 'assets/imagens/not-found.jpg');
                                    }else{
                                        $('#img_colaborador').prop('src', 'application/upload/' + retorno['imagem']);
                                    }
                                    $('#txt_nome').val(retorno['nome']);
                                    $('#txt_funcao').val(retorno['funcao']);
                                    $('#txt_setor').val(retorno['setor']);
                                    $('#txt_turno').val(retorno['turno']);
                                    $('#data_admissao').val(retorno['data_admissao']);
                                    $('#txt_observacoes').val(retorno['observacoes']);

                                    $('#btn_excluir').removeAttr('disabled');
                                }
                                
                            });";
                    };
                ?>
            }

            function AjustarURL(){
                window.location = 'index.php?tela=cadastro-colaborador&codigo=novo';
            }

            function ExcluirColaborador(){
                opcao = confirm("Deseja realmente excluir esse Colaborador?");

                if(opcao){
                    idColaborador = document.getElementById('txt_id').value;

                    $.ajax({
                            method: 'post',
                            url: 'application/excluir-colaborador.php',
                            dataType: 'json',
                            data: {
                                idColaborador: idColaborador
                            },
                            success: function(retorno) {
                                if(retorno == 1){
                                    window.location = 'index.php?tela=colaboradores';
                                }else if(retorno == 2){
                                    alert("Não foi possível excluir o colaborador pois há empréstimos vinculados!");
                                    location.reload();
                                }
                                
                            }
                        })
                }  
            }

            function AbrirColaboradores(){
                window.location = 'index.php?tela=colaboradores';
            }

            function visualizarIMG(obj) {
                var img = document.getElementById('img_colaborador');
                var reader = new FileReader();
                reader.onload = () => {
                img.src =  reader.result
                };
                reader.readAsDataURL(obj.files[0]);
            }

        </script>
    </body>
</html>

