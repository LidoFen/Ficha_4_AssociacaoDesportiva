function registaClube() {

    let dados = new FormData();
    dados.append("op", 1);
    dados.append("nome", $('#nome').val());
    dados.append("localidade", $('#localidade').val());
    dados.append("email", $('#email').val());
    dados.append("ano", $('#ano').val());
    dados.append("telefone", $('#telefone').val());
    dados.append("logotipo", $('#logotipo').prop('files')[0]);


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

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                getListaClubes();

            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getListaClubes() {

    if ($.fn.DataTable.isDataTable('#tabelaClubes')) {
        $('#tabelaClubes').DataTable().destroy();
    }

    let dados = new FormData();
    dados.append("op", 2);

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
            $('#listaClubes').html(msg)
            $('#tabelaClubes').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json"
                }

            });
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function removerClube(id) {

    let dados = new FormData();
    dados.append("op", 3);
    dados.append("id", id);

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

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                getListaClubes();
            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getDadosClube(id) {

    let dados = new FormData();
    dados.append("op", 4);
    dados.append("id", id);

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
            let obj = JSON.parse(msg);
            $('#nomeEdit').val(obj.nome);
            $('#localidadeEdit').val(obj.localidade);
            $('#emailEdit').val(obj.email);
            $('#anoEdit').val(obj.ano);
            $('#telefoneEdit').val(obj.telefone);

            $('#modalClubeEdit').modal('show');

            $('#btnGuardar').attr("onclick", "guardaEdit(" + obj.id + ")")
        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function guardaEdit(id) {

    let dados = new FormData();
    dados.append("op", 5);
    dados.append("id", id);
    dados.append("nome", $('#nomeEdit').val());
    dados.append("localidade", $('#localidadeEdit').val());
    dados.append("email", $('#emailEdit').val());
    dados.append("ano", $('#anoEdit').val());
    dados.append("telefone", $('#telefoneEdit').val());
    dados.append("logotipo", $('#logotipoEdit').prop('files')[0]);

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

            let obj = JSON.parse(msg);
            if (obj.flag) {
                alerta("Sucesso", obj.msg, "success");
                $('#modalClubeEdit').modal('hide');
                getListaClubes();

            } else {
                alerta("Erro", obj.msg, "error");
            }

        })

        .fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
}

function getInfo(id) {

    if ($.fn.DataTable.isDataTable('#tabelaClubesInfo')) {
        $('#tabelaClubesInfo').DataTable().destroy();
    }

    let dados = new FormData();
    dados.append("op", 7);
    dados.append("id", id);

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
            $('#listaClubesInfo').html(msg)
            $('#modalClubeInfo').modal('show');
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

$(function () {
    getListaClubes();
    
});