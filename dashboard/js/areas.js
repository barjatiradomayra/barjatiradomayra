$(document).ready(function(){
    fila = $(this).closest("tr");
    id_area = parseInt(fila.find('td:eq(0)').text());

    tabla_area = $("#tabla_area").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'>"
        +"<button class='btn btn-dark btndetalle'>Detalle</button>"
        +"<button class='btn btn-success btnlista_metas'>Metas</button>"
        +"<button class='btn btn-primary btnEditar_area'>Editar</button>"
        +"<button class='btn btn-danger btnBorrar_area'>Borrar</button></div></div>"  
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


$("#btnnueva_area").click(function(){
    $("#form_area").trigger("reset");
    $(".modal-header").css("background-color", "#093C3C");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nuevo Registro");            
    $("#modalCRUD").modal("show");        
    id_area=null;
    opcion = 1; //alta
});    


var fila; //capturar la fila para editar o borrar el registro


//botón EDITAR    
$(document).on("click", ".btnEditar_area", function(){
    fila = $(this).closest("tr");
    
    id_area = parseInt(fila.find('td:eq(0)').text());
    nombre_area = fila.find('td:eq(1)').text();
    responsable = fila.find('td:eq(2)').text();
    cantidad_personal = parseInt(fila.find('td:eq(3)').text());
    
    $("#nombre_area").val(nombre_area);
    $("#responsable").val(responsable);
    $("#cantidad_personal").val(cantidad_personal);
    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Area");            
    $("#modalCRUD").modal("show");  
    
});


//mostrar metas
$(document).on("click", ".btnlista_metas", function(){
    fila = $(this).closest("tr");
    id_area = parseInt(fila.find('td:eq(0)').text());

    location.href='metas.php?id_area='+id_area;

});

//mostrar detalle de area
$(document).on("click", ".btndetalle", function(){
    fila = $(this).closest("tr");
    id_area = parseInt(fila.find('td:eq(0)').text());

    location.href='descripcion_area.php?id_area='+id_area;

});


//botón BORRAR
$(document).on("click", ".btnBorrar_area", function(){    
    fila = $(this);
    id_area = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3 //borrar
    
        $.ajax({
            url: "modelos/areas.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_area:id_area},
            success: function(){
                tabla_area.row(fila.parents('tr')).remove().draw();
            }
        });
      
});

//envio de datos al modelo

$("#form_area").submit(function(e){
    e.preventDefault();    
    nombre_area = $.trim($("#nombre_area").val());
    responsable = $.trim($("#responsable").val());
    cantidad_personal = $.trim($("#cantidad_personal").val());
    id_usuario = $("#id_usuarioa").val();
    $.ajax({
        url: "modelos/areas.php",
        type: "POST",
        dataType: "json",
        data: {nombre_area:nombre_area, responsable:responsable, cantidad_personal:cantidad_personal,id_usuario:id_usuario, id_area:id_area, opcion:opcion},
        success: function(data){  
            console.log(data);
            id_area = data[0].id_area;            
            nombre_area = data[0].nombre_area;
            responsable = data[0].responsable;
            cantidad_personal = data[0].cantidad_personal;
            
            if(opcion == 1){tabla_area.row.add([id_area,nombre_area,responsable,cantidad_personal]).draw();}
            else{tabla_area.row(fila).data([id_area,nombre_area,responsable,cantidad_personal]).draw();}            
        }        
    });
    $("#modalCRUD").modal("hide");    
  
});    
    
});