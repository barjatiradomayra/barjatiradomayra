$(document).ready(function(){
    tabla_usuarios = $("#tabla_usuarios").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar_user'>Editar</button><button class='btn btn-danger btnBorrar_user'>Borrar</button></div></div>"  
       }],
        
       //cambiar el lenguaje del datat a español
    "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast":"Último",
                "sNext":"Siguiente",
                "sPrevious": "Anterior"
             },
             "sProcessing":"Procesando...",
        }
    });
    
$("#btnNuevo_user").click(function(){
    $("#formUsuarios").trigger("reset");
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nuevo Registro");            
    $("#modalCRUD").modal("show");        
    id=null;
    opcion = 1; //alta
});    
    
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click", ".btnEditar_user", function(){
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text());
    nombre_user = fila.find('td:eq(1)').text();
    usuario = fila.find('td:eq(2)').text();
    tipo_user = fila.find('td:eq(3)').text();
    
    $("#nombre_user").val(nombre_user);
    $("#usuario").val(usuario);
    $("#tipo_user").val(tipo_user);
    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Usuario");            
    $("#modalCRUD").modal("show");  
    
});

//botón BORRAR
$(document).on("click", ".btnBorrar_user", function(){    
    fila = $(this);
    id = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3; //borrar
    $.ajax({
        url: "modelos/usuarios.php",
        type: "POST",
        dataType: "json",
        data: {opcion:opcion, id:id},
        success: function(){
            tabla_usuarios.row(fila.parents('tr')).remove().draw();
        }
    });
    
    

});
    
$("#formUsuarios").submit(function(e){
    e.preventDefault();    
    nombre_user = $.trim($("#nombre_user").val());
    usuario = $.trim($("#usuario").val());
    tipo_user = $.trim($("#tipo_user").val()); 
    $.ajax({
        url: "modelos/usuarios.php",
        type: "POST",
        dataType: "json",
        data: {nombre_user:nombre_user, usuario:usuario, tipo_user:tipo_user, id:id, opcion:opcion},
        success: function(data){  
            console.log(data);
            id = data[0].id;            
            nombre_user = data[0].nombre_user;
            usuario = data[0].usuario;
            tipo_user = data[0].tipo_user;
            
            if(opcion == 1){tabla_usuarios.row.add([id,nombre_user,usuario,tipo_user]).draw();}
            else{tabla_usuarios.row(fila).data([id,nombre_user,usuario,tipo_user]).draw();}            
        }        
    });
    $("#modalCRUD").modal("hide");    
    
});    
    
});