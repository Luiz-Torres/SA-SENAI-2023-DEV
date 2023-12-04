//SCRIPTS CADASTRO EPI
function visualizarIMG(obj) {
    var img = document.getElementById('img_equipamento');
    var reader = new FileReader();
    reader.onload = () => {
    img.src =  reader.result
    };
    reader.readAsDataURL(obj.files[0]);
}

function AjustarURL(){
    window.location = 'index.php?tela=cadastro-epi&codigo=novo';
}

function AbrirEstoque(){
    window.location = 'index.php?tela=estoque';
}



//SCRIPTS MODAL SERIE
function abrirModalSerie() {
    $('#adicionar-serie').modal('show');
    document.getElementById('crud-footer').hidden = true;
}

$('#adicionar-serie').on('hidden.bs.modal', function() {
    document.getElementById('crud-footer').hidden = false;
});

function CadastrarSerie(){
    var num_serie = document.getElementById('txt_numero_serie').value;
    var idEPI = document.getElementById('txt_id').value;

    if(num_serie != ''){
        $.ajax({
            method: 'post',
            url: 'application/cadastrar-serie.php',
            dataType: 'json',
            data: {
                idEPI: idEPI,
                num_serie: num_serie
            },
            success: function(retorno) {
                location.reload();
            }
        })
    }
}

function FecharSerie(){
    $('#adicionar-serie').modal('hide');
}



//SCRIPTS MODAL LOTE
function abrirModalLote() {
    $('#adicionar-lote').modal('show');
    document.getElementById('crud-footer').hidden = true;
}

$('#adicionar-lote').on('hidden.bs.modal', function() {
    document.getElementById('crud-footer').hidden = false;
});

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

function FecharLote(){
    $('#adicionar-lote').modal('hide');
}


//SCRIPTS MODAL CA
function abrirModalCA() {
    $('#adicionar-ca').modal('show');
    document.getElementById('crud-footer').hidden = true;
}

$('#adicionar-ca').on('hidden.bs.modal', function() {
    document.getElementById('crud-footer').hidden = false;
});

function CadastrarCA() {
    var num_ca = document.getElementById('txt_numero_ca').value;
    var idEPI = document.getElementById('txt_id').value;

    if(num_ca != ''){
        $.ajax({
            method: 'post',
            url: 'application/cadastrar-ca.php',
            dataType: 'json',
            data: {
                idEPI: idEPI,
                num_ca: num_ca
            },
            success: function(retorno) {
                location.reload();
            }
        })
    }
}



function FecharCA(){
    $('#adicionar-ca').modal('hide');
}