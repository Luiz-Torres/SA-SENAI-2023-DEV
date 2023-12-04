<!doctype html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Usuarios | LTControl</title>

        <link href="/assets/css/usuarios.css" rel="stylesheet">

    </head>
    <body onload="carregarInfo()">
        <form id="form_usuarios" method="post" action="application/inserir-usuario.php" enctype="multipart/form-data">
            <div class="py-md-5">
                <div class="modal-header">
                    <h4 class="title">Novo Usuario</h4>
                    <button onclick="AbrirUsuarios()" type="button" class="close" aria-hidden="true">&times;</button>
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
                            <label>Usuario</label>
                            <input type="text" class="form-control" name="txt_usuario" id="txt_usuario" required>
                        </div>


                        <div class="form-group col-6">
                            <label>Senha</label>
                            <input type="password" class="form-control" name="txt_senha" id="txt_senha" required>
                        </div>
                        

                        <div class="form-group col-12">
                            <label>Foto</label>
                            <input onchange="visualizarIMG(this)" type="file" class="form-control w-50" name="file_imagem" id="file_imagem" accept="image/*" >
                        </div>
                    </div>
                    <div class="row col-3">
                        <div class="col-12">
                            <label class="form-label">Pré Visualização</label><br>
                            <img style="display: block; margin: 0 auto; height: 300px; width: 300px;" src="assets/imagens/not-found.jpg" id="img_usuario">
                            <input type="hidden" name="txt_nomeImagem" id="txt_nomeImagem">
                        </div>
                    </div>
                </div>
                <div class="modal-footer CRUD-bar">
                    <button onclick="ExcluirUsuario()" id="btn_excluir" class="btn btn-secondary btn-alert" disabled>Excluir</button>
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
                                url: 'application/selecionar-usuario.php',
                                dataType: 'json',
                                data: {
                                    codigo: {$_GET['codigo']}
                                },
                                success: function(retorno) {
                                    // Imprimir os dados do retorno
                                    $('#txt_id').val(retorno['id_usuario']);
                                    $('#txt_codigo_interno').val(retorno['codigo']);
                                    $('#txt_nome').val(retorno['nome']);
                                    $('#txt_usuario').val(retorno['usuario']);
                                    $('#txt_senha').val(retorno['senha']);
                                    $('#txt_nomeImagem').val(retorno['imagem']);
                                    if(retorno['imagem'] == '' || retorno['imagem'] == null){
                                        $('#img_usuario').prop('src', 'assets/imagens/not-found.jpg');
                                    }else{
                                        $('#img_usuario').prop('src', 'application/upload/' + retorno['imagem']);
                                    }

                                    $('#btn_excluir').removeAttr('disabled');
                                }
                                
                            });";
                    };
                ?>
            }

            function AjustarURL(){
                window.location = 'index.php?tela=cadastro-usuario&codigo=novo';
            }

            function ExcluirUsuario(){
                opcao = confirm("Deseja realmente excluir esse Usuário?");

                if(opcao){
                    idUsuario = document.getElementById('txt_id').value;

                    $.ajax({
                            method: 'post',
                            url: 'application/excluir-usuario.php',
                            dataType: 'json',
                            data: {
                                idUsuario: idUsuario
                            },
                            success: function(retorno) {
                                if(retorno == 1){
                                    window.location = 'index.php?tela=usuarios';
                                }else if(retorno == 2){
                                    alert("Não foi possível excluir o colaborador pois há empréstimos vinculados!");
                                    location.reload();
                                }
                            }
                        })
                }  
            }

            function AbrirUsuarios(){
                window.location = 'index.php?tela=usuarios';
            }

            function visualizarIMG(obj) {
                var img = document.getElementById('img_usuario');
                var reader = new FileReader();
                reader.onload = () => {
                img.src =  reader.result
                };
                reader.readAsDataURL(obj.files[0]);
            }

        </script>           
    </body>
</html>

