function addEvent() {
    $(".roleUser").on("click", function (event) {
        var fila = $(event.target).parent().parent();
        var userID = $(fila).attr('data-userid');
        $.ajax({
            url: "user/changeRole/" + userID,
            method: "GET",
            data: {}
        }).done(function () {
            refresh();
        }).error(function () {
            console.log("Error al intentar conectar con UserController");
        });

    });
    $(".remove").on("click", function (event) {
        var fila = $(event.target).parent().parent();
        var userID = $(fila).attr('data-userid');
        $.ajax({
            url: "user/remove/" + userID,
            method: "GET",
            data: {}
        }).done(function () {
            refresh();
        }).error(function () {
            console.log("Error al intentar conectar con UserController");
        });

    });
}
function refresh(){
    //$('#tableConteiner').html("");
    $.ajax({
        url: "user/view/",
        method: "GET",
        dataType: "JSON"
    }).done(function(msg) {
        $("#tableConteiner").html("");
        for(var i in msg) {
            var str = "<tr data-userid=\"" + msg[i].id + "\">" +
                "<th>" + msg[i].email + "</th>" +
                "<th>" + msg[i].nombre + "</th>" +
                "<th>" + msg[i].fechaNacimiento + "</th>" +
                "<th><button class='roleUser'>";
            if (msg[i].permiso==1)
                str += "Admin";
            else
                str += "User";
            str += "</button>";

            str += "</th>";
            str += "<th><button class=\"remove\">Borrar</button></th>";
            str += "</tr>";
            $("#tableConteiner").append(str);
        }
        addEvent();

    }).error(function(){
        console.log("Error al intentar conectar con UserController");
    });
}

$(function(){
    addEvent();

});