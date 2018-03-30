var direccion = "null";
function create_folder(){
	var data = new FormData();
	data.append('nameFolder', $("#nameFolder").val());
	if (direccion == null) {
		data.append('direccion', "null");
	}else{
		data.append('direccion', direccion);
	};
	$.ajax({
		url: "data/createFolder",
		method: "POST",
		contentType:false,
		data:data,
		processData:false
	})
	.done(function( msg ) {
        view_folder(direccion);
    })
	.error(function(){
		alert("Carpeta no creada");
	});
}
function upload_file(){
	var inputFileImage = document.getElementById("fileToUpload");
	var file = inputFileImage.files[0];
	var data = new FormData();
	data.append('fileToUpload', file);
	data.append('direccion', direccion);
	var url = "data/upload";
	$.ajax({
		url:url,
		type:'POST',
		contentType:false,
		data:data,
		processData:false,
		cache:false
	})

.done(function(msg) {
	view_folder(direccion);
})
.error(function(){
	alert("Archivo no creado.");
});
}
function remove(event){
	var id = $(event.target).attr("data-reference");
	$.ajax({
		url: "data/remove/"+id,
		method: "GET"
	}).done(function( msg ) {
		view_folder(direccion);
	}).error(function(){
		alert("Imposible borrar");
	});
}
function view_folder(id){
	direccion= id;
	$.ajax({
		url: "data/view/" + id,
		method: "POST",
		dataType: "JSON"
	}).done(function( msg ) {
		mostrar(msg);
		$(".remove").on('click',remove);
	}).error(function(){
		mostrar(direccion);
	});
}

function mostrar(msg){
	var table = document.getElementById('ficheros');
	ficheros.innerHTML = "";
	if(direccion != null){
		$.ajax({
			url: "data/contenedor/" + direccion,
			method: "POST",
			dataType: "JSON"
		}).done(function( msg2 ) {
			var tr = document.createElement('tr');
			var td1 = document.createElement('td');
			table.appendChild(tr);
			td1.innerHTML = "<a href='#' onclick='view_folder(" + msg2.contenedor + ");' >...</a>";
			tr.appendChild(td1);
		});
	}

	for (var i = 0; i < msg.length; i++) {
		var tr = document.createElement('tr');
		var td1 = document.createElement('td');
		var td2 = document.createElement('td');
		var td3 = document.createElement('td');



		var td4 = document.createElement('td');
		td4.innerHTML = "<input class='remove' type='submit' data-reference='"+msg[i].id+"' value='Eliminar'/>"
		
		if(msg[i].contenedor == direccion){
			table.appendChild(tr);
			if(msg[i].tipo == "folder"){
				td1.innerHTML = "<a href='#' onclick='view_folder(" + msg[i].id + ");'>" + msg[i].nombre; + "</a>";
				td3.innerHTML = "--";
				td2.innerHTML = "Carpeta";
			}
			else{
				td1.innerHTML = "<a href='data/download/" + msg[i].id + "'>" + msg[i].nombre + "</a>";
				td3.innerHTML = msg[i].fechaModificacion;
				td2.innerHTML = msg[i].tipo;
			}
			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			tr.appendChild(td4);
		}
	}
}

$(document).ready(function() {
	view_folder(null);
	// $("#create").click(function() { 
 //        $("#dialogo").dialog({ 
 //            width: 200, 
 //            height: 100,
 //            show: "scale",
 //            hide: "scale",
 //            resizable: "false",
 //            position: "center",
 //            modal: "true"
 //        });
 //    });
 //    $("#upload").click(function() { 
 //        $("#dialogo2").dialog({ 
 //            width: 150, 
 //            height: 100,
 //            show: "scale",
 //            hide: "scale",
 //            resizable: "false",
 //            position: "center",
 //            modal: "true"
 //        });
 //    });
   
})