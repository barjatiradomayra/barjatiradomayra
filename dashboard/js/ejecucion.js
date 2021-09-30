$(document).ready(function(){
    tabla_ejecucion = $("#tabla_ejecucion").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<button class='btn btn-danger btnBorrar_ejecucion'>Borrar</button></div></div>"  
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

//NUEVA EJECUCION
$("#btnnueva_ejecucion").click(function(){
    $("#form_ejecucion").trigger("reset");
    $(".modal-header").css("background-color", "#093C3C");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nueva Ejecucion");            
    $("#modalCRUD").modal("show");  
    id_meta = $.trim($("#id_meta").val());

    $.ajax({
        url: "modelos/sum_ejecucion.php",
        type: "POST",
        data: {id_meta:id_meta},
        dataType: "json",
        success: function(datos){
            $("#suma_ejecutado").val(datos[0]);

            $("#alert_no").html(datos[1]);
        }
    });
    id_ejecucion =null;
    opcion = 1; //alta
    
});    
    
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click", ".btnEditar_ejecucion", function(){
    fila = $(this).closest("tr");
    id_meta = $.trim($("#id_meta").val());

    id_ejecucion = parseInt(fila.find('td:eq(0)').text());
    fecha_actual = fila.find('td:eq(1)').text();
    cantidad_ejecutado = parseInt(fila.find('td:eq(2)').text());
    porcentaje_completo = fila.find('td:eq(3)').text();
    
    $("#fecha_actual").val(fecha_actual);
    $("#cantidad_ejecutado").val(cantidad_ejecutado);
    $("#porcentaje_completo").val(porcentaje_completo);

    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Ejecucion");            
    $("#modalCRUD").modal("show");  
    
});

//botón BORRAR
$(document).on("click", ".btnBorrar_ejecucion", function(){    
    fila = $(this);
    id_ejecucion = parseInt($(this).closest("tr").find('td:eq(0)').text());

    opcion = 3; //borrar
    
        $.ajax({
            url: "modelos/ejecucion.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_ejecucion:id_ejecucion},
            success: function(){
                tabla_ejecucion.row(fila.parents('tr')).remove().draw();
            }
        });
      
});

/*ocultamos el alert*/
$("#alert_no").hide();

//envio de datos al modelo
$("#form_ejecucion").submit(function(e){
    e.preventDefault();    
    fecha_actual = $.trim($("#fecha_actual").val());
    cantidad_ejecutado = $.trim($("#cantidad_ejecutado").val());
    porcentaje_completo = $.trim($("#porcentaje_completo").val());

    suma_ejecutado = $.trim($("#suma_ejecutado").val());
    meta_cantidad = $.trim($("#meta_cantidad").val());

    restante = meta_cantidad - suma_ejecutado;
    
    if(cantidad_ejecutado > restante){
        
        $("#alert_no").fadeTo(3000, 500).slideUp(500, function(){
            $("#alert_no").slideUp(500);
        });
        
    }
    else{

    $.ajax({
        url: "modelos/ejecucion.php",
        type: "POST",
        //indicamos el tipo de dato que queremos que se nos devuelva
        dataType: "json",
        data: {fecha_actual:fecha_actual, cantidad_ejecutado:cantidad_ejecutado, id_ejecucion:id_ejecucion, porcentaje_completo:porcentaje_completo, opcion:opcion, id_meta:id_meta},
        
        success: function(data){  
            console.log(data);
            id_ejecucion = data[0].id_ejecucion;            
            fecha_actual = data[0].fecha_actual;
            cantidad_ejecutado = data[0].cantidad_ejecutado;
            porcentaje_completo = data[0].porcentaje_completo;

            if(opcion == 1){tabla_ejecucion.row.add([id_ejecucion,fecha_actual,cantidad_ejecutado,porcentaje_completo+" %"]).draw();}
            else{tabla_ejecucion.row(fila).data([id_ejecucion,fecha_actual,cantidad_ejecutado,porcentaje_completo+" %"]).draw();}            
        }        
    });
    $("#modalCRUD").modal("hide");   
    
    }
    
});    
    
});