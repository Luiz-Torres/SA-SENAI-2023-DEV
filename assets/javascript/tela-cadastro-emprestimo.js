function AjustarURL(){
    window.location = 'index.php?tela=novo-emprestimo&codigo=novo';
}

function ExcluirEmprestimo(){
    var opcao = confirm("Deseja realmente excluir esse Emprestimo?");

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
                    window.location = 'index.php?tela=emprestimos';
                }
            })
    }  
}

function AbrirEmprestimos(){
    RemoverEmprestimosAbertos()
}

function RemoverEmprestimosAbertos(){
    $.ajax({
        method: 'post',
        url: 'application/deletar-emprestimos-abertos.php',
        dataType: 'json',
        success: function(retorno) {
            window.location = 'index.php?tela=emprestimos'; 
        }
    });
}

function CadastrarEmprestimo(){
    var idColaborador = document.getElementById('txt_id_colaborador').value;
    var idEmprestimo = document.getElementById('txt_id').value;
    var codigoEmprestimo = document.getElementById('txt_codigo_interno').value;
    var observacoes = document.getElementById('txt_observacoes').value;

    $.ajax({
            method: 'post',
            url: 'application/inserir-emprestimo.php',
            dataType: 'json',
            data: {
                idEmprestimo: idEmprestimo,
                codigoEmprestimo: codigoEmprestimo,
                idColaborador: idColaborador,
                observacoes: observacoes
            },
            success: function(retorno) {
                $('#txt_epi').removeAttr('readonly');

                $('#txt_id').val(retorno['id_emprestimo']);
                $('#txt_codigo_interno').val(retorno['numero']);

                console.log(retorno);

                if(retorno['status_emprestimo'] == "Concluido"){
                    window.location = "index.php?tela=novo-emprestimo&codigo=" + retorno['numero'];
                }
            }
        })
}  

function abrirBuscaColaborador(){
    $('#adicionar-colaborador').modal('show');
    $('#txt_colaborador_busca').focus();
    $('#txt_colaborador_busca').val(document.getElementById('txt_colaborador').value);
    buscarColaborador();
    document.getElementById('crud-footer').hidden = true;
}

function buscarColaborador(){
    var busca = document.getElementById('txt_colaborador_busca').value

    $.ajax({
        method: 'post',
        url: 'application/buscar-colaborador.php',
        dataType: 'json',
        data: {
            busca: busca
        },
        success: function(retorno) {

            $('#lista-colaboradores-modal').html(retorno);
        }    
    })
}

function selecionarColaborador(idColaborador, nome){
    document.getElementById('txt_id_colaborador').value = idColaborador;
    document.getElementById('txt_colaborador').value = nome;

    $('#adicionar-colaborador').modal('hide');
    document.getElementById('crud-footer').hidden = false;
    CadastrarEmprestimo()
}

function fecharColaboradores(){
    $('#adicionar-colaborador').modal('hide');
    document.getElementById('crud-footer').hidden = false;
}

function fecharEPI(){
    $('#adicionar-epi').modal('hide');
    document.getElementById('crud-footer').hidden = false;
}

function selecionarEPI(idEPI, nome){
    document.getElementById('txt_id_epi').value = idEPI;
    document.getElementById('txt_epi').value = nome;

    $('#adicionar-epi').modal('hide');
    $('#txt_ca_epi').removeAttr('readonly');
    $('#txt_qtd_epi').removeAttr('readonly');
    document.getElementById('crud-footer').hidden = false;
    selecionarCA();
    selecionarSerie();
    selecionarLote();
}

function buscarEPI(){
    var busca = document.getElementById('txt_epi_busca').value

    $.ajax({
        method: 'post',
        url: 'application/buscar-epi.php',
        dataType: 'json',
        data: {
            busca: busca
        },
        success: function(retorno) {

            $('#lista-epi-modal').html(retorno);
        }    
    })
}

function abrirBuscaEPI(){
    $('#adicionar-epi').modal('show');
    $('#txt_epi_busca').focus();
    $('#txt_epi_busca').val(document.getElementById('txt_epi').value);
    buscarEPI();
    document.getElementById('crud-footer').hidden = true;
}

function selecionarCA(){
    var busca = document.getElementById('txt_id_epi').value

    $.ajax({
        method: 'post',
        url: 'application/buscar-ca-epi.php',
        dataType: 'json',
        data: {
            busca: busca
        },
        success: function(retorno) {
            $('#txt_ca_epi').html(retorno);
        }    
    })
}

function selecionarSerie(){
    var busca = document.getElementById('txt_id_epi').value

    $.ajax({
        method: 'post',
        url: 'application/buscar-serie-epi.php',
        dataType: 'json',
        data: {
            busca: busca
        },
        success: function(retorno) {
            if(retorno != 0){
                $('#txt_serie_epi').html(retorno);
                $('#txt_serie_epi').removeAttr('readonly');
            }
        }    
    })
}

function selecionarLote(){
    var busca = document.getElementById('txt_id_epi').value

    $.ajax({
        method: 'post',
        url: 'application/buscar-lote-epi.php',
        dataType: 'json',
        data: {
            busca: busca
        },
        success: function(retorno) {
            if(retorno != 0){
                $('#txt_lote_epi').html(retorno);
                $('#txt_lote_epi').removeAttr('readonly');
            }
        }    
    })
}

function inserirEPI(){
    var idEmprestimo = document.getElementById('txt_id').value
    var EPI_selecionado = document.getElementById('txt_id_epi').value
    var QTD_selecionada = document.getElementById('txt_qtd_epi').value
    var CA_selecionadas = document.getElementById('txt_ca_epi').value
    
    
    var SERIE_selecionada = document.getElementById('txt_serie_epi').value
    var LOTE_selecionado = document.getElementById('txt_lote_epi').value

    $.ajax({
        method: 'post',
        url: 'application/adicionar-epi-emprestimo.php',
        dataType: 'json',
        data: {
            idEmprestimo: idEmprestimo,
            EPI_selecionado: EPI_selecionado,
            CA_selecionadas: CA_selecionadas,
            QTD_selecionada: QTD_selecionada,
            SERIE_selecionada: SERIE_selecionada,
            LOTE_selecionado: LOTE_selecionado
        },
        success: function(retorno) {
            if(retorno == 2){
                alert("Não há quantidade suficiente nesse produto!");
            }else if(retorno == 3){
                alert("Não há quantidade suficiente no lote selecionado!");
            }else if(retorno == 4){
                alert("Há um número de série selecionado, adicione apenas uma unidade!");
            }else if(retorno == 0){
                alert("Há campos em branco!");
            }else{
                $('#epis_adicionados').html(retorno);

                document.getElementById('txt_id_epi').value = '';
                document.getElementById('txt_epi').value = '';
                document.getElementById('txt_qtd_epi').value = '';
                $('#txt_qtd_epi').attr('readonly');
                document.getElementById('txt_ca_epi').innerHTML = ''
                $('#txt_ca_epi').attr('readonly');;
                document.getElementById('txt_serie_epi').innerHTML = '';
                $('#txt_serie_epi').attr('readonly');
                document.getElementById('txt_lote_epi').innerHTML = '';
                $('#txt_lote_epi').attr('readonly');
            }
            
        }    
    })

}

