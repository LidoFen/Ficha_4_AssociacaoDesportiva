function getClubes() {

    let dados = new FormData();
    dados.append("op", 6);

    $.ajax({
        url: "assets/controller/controllerClube.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#selectClubes').html(msg);

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function registaJogador() {

    let dados = new FormData();
    dados.append("op", 1);
    dados.append("nFederativo", $('#nFederativo').val());
    dados.append("nome", $('#nome').val());
    dados.append("email", $('#email').val());
    dados.append("idade", $('#idade').val());
    dados.append("morada", $('#morada').val());
    dados.append("telefone", $('#telefone').val());
    dados.append("clube", $('#selectClubes').val()); // vai o id do clube
    dados.append("foto", $('#foto').prop('files')[0]);


    $.ajax({
        url: "assets/controller/controllerJogador.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                getListaJogadores();


            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getListaJogadores() {

    if ($.fn.DataTable.isDataTable('#tabelaJogadores')) {
        $('#tabelaJogadores').DataTable().destroy();
    }

    let dados = new FormData();
    dados.append("op", 2);

    $.ajax({
        url: "assets/controller/controllerJogador.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            $('#listaJogadores').html(msg)
            $('#tabelaJogadores').DataTable({
                aoColumnDefs: [
                    { "aTargets": [0], "bSortable": true },
                    { "aTargets": [2], "asSorting": ["asc"], "bSortable": true },
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json"
                }

            });

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function removerJogador(nFederativo) {

    let dados = new FormData();
    dados.append("op", 3);
    dados.append("nFederativo", nFederativo);

    $.ajax({
        url: "assets/controller/controllerJogador.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                getListaJogadores();
            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getDadosJogador(nFederativo) {

    let dados = new FormData();
    dados.append("op", 4);
    dados.append("nFederativo", nFederativo);

    $.ajax({
        url: "assets/controller/controllerJogador.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {
            let obj = JSON.parse(msg);
            $('#nFederativoEdit').val(obj.dadosJogador.nFederativo);
            $('#nomeEdit').val(obj.dadosJogador.nome);
            $('#emailEdit').val(obj.dadosJogador.email);
            $('#idadeEdit').val(obj.dadosJogador.idade);
            $('#moradaEdit').val(obj.dadosJogador.morada);
            $('#telefoneEdit').val(obj.dadosJogador.telefone);
            $('#selectClubesEdit').html(obj.nomeClube);

            $('#modalJogadorEdit').modal('show');

            $('#btnGuardar1').attr("onclick", "guardaEdit(" + obj.dadosJogador.nFederativo + ")")
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function guardaEdit(nFederativo) {

    let dados = new FormData();
    dados.append("op", 5);
    dados.append("nFederativoNew", $('#nFederativoEdit').val());
    dados.append("nFederativoOld", nFederativo);
    dados.append("nome", $('#nomeEdit').val());
    dados.append("email", $('#emailEdit').val());
    dados.append("idade", $('#idadeEdit').val());
    dados.append("morada", $('#moradaEdit').val());
    dados.append("telefone", $('#telefoneEdit').val());
    dados.append("clube", $('#selectClubesEdit').val());
    dados.append("foto", $('#fotoEdit').prop('files')[0]);

    $.ajax({
        url: "assets/controller/controllerJogador.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                $('#modalJogadorEdit').modal('hide');
                getListaJogadores();

            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function alerta(titulo, msg, icon) {

    Swal.fire({
        position: 'center',
        icon: icon,
        title: titulo,
        text: msg,
        showConfirmButton: true,

    })
}

function getInfo(nFederativo) {

    if ($.fn.DataTable.isDataTable('#tabelaJogadoresInfo')) {
        $('#tabelaJogadoresInfo').DataTable().destroy();
    }

    let dados = new FormData();
    dados.append("op", 7);
    dados.append("nFederativo", nFederativo);

    $.ajax({
        url: "assets/controller/controllerJogador.php",
        method: "POST",
        data: dados,
        dataType: "html",
        cache: false,
        contentType: false,
        processData: false
    })

        .done(function (msg) {

            $('#listaJogadoresInfo').html(msg)
            $('#modalJogadorInfo').modal('show');
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

$(function () {
    getListaJogadores();
    getClubes();
    $("#selectClubes").select2();

});