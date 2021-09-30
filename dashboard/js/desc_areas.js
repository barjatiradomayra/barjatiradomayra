$(document).ready(function(){
    tabla_desc_areas = $("#tabla_desc_areas").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar_d_areas'>Editar</button><button class='btn btn-danger btnBorrar_d_areas'>Borrar</button></div></div>"  
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
    
$("#btnNuevo_d_areas").click(function(){
    $("#formDesArea").trigger("reset");
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nuevo Registro");            
    $("#modalCRUD").modal("show");        
    id_descripcion=null;
    opcion = 1; //alta
});    
    
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click", ".btnEditar_d_areas", function(){
    fila = $(this).closest("tr");
    id_descripcion = parseInt(fila.find('td:eq(0)').text());
    titulo = fila.find('td:eq(1)').text();
    descripcion = fila.find('td:eq(2)').text();
    // id_area = fila.find('td:eq(3)').text();
    
    $("#titulo").val(titulo);
    $("#descripcion").val(descripcion);
    // $("#id_area").val(id_area);
    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Descripcion de la area");            
    $("#modalCRUD").modal("show");  
    
});

//botón BORRAR
$(document).on("click", ".btnBorrar_d_areas", function(){    
    fila = $(this);
    id_descripcion = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3 //borrar
    $.ajax({
        url: "modelos/desc_areas.php",
        type: "POST",
        dataType: "json",
        data: {opcion:opcion, id_descripcion:id_descripcion},
        success: function(){
            tabla_desc_areas.row(fila.parents('tr')).remove().draw();
        }
    });
    
    

});
    

$("#formDesArea").submit(function(e){
    e.preventDefault();    
    titulo = $.trim($("#titulo").val());
    descripcion = $.trim($("#descripcion").val());
    id_area = parseInt($.trim($("#id_area").val()));
    imagen_area = $.trim($("#imagen_area").val());

    
    const formData= new FormData();
    var foto= $("#imagen_area")[0].files[0];
    formData.append('titulo',titulo);
    formData.append('descripcion',descripcion);
    formData.append('id_area',id_area);
    formData.append('opcion',opcion);
    formData.append('f',foto);
    // debugger
    $.ajax({
        url: "modelos/desc_areas.php",
        type: "POST",
        dataType: "json",
        data:formData,
        processData: false,
        contentType: false,
        cache:false,
        // data: {titulo:titulo, descripcion:descripcion, id_area:id_area, id_descripcion:id_descripcion,imagen_area, opcion:opcion},
        success: function(data){  
            console.log(data);
            id_descripcion = data[0].id_descripcion;            
            titulo = data[0].titulo;
            descripcion = data[0].descripcion;
            if(opcion == 1){tabla_desc_areas.row.add([id_descripcion,titulo,descripcion]).draw();}
            else{tabla_desc_areas.row(fila).data([id_descripcion,titulo,descripcion]).draw();}          
        }        
    });
    $("#modalCRUD").modal("hide");    
    
}); 
    
});