$(document).ready(function(){
    //*************tabla_
    tabla_meta = $("#tabla_meta").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success btnlista_ejecucion'>Ejecucion</button><div class='btn-group'><button class='btn btn-primary btnEditar_meta'>Editar</button><button class='btn btn-danger btnBorrar_meta'>Borrar</button></div></div>"  
       }],
        
       //cambiar el lenguaje del datatable a español
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
//********btnnueva_ */
$("#btnnueva_meta").click(function(){
    $("#form_meta").trigger("reset");
    $(".modal-header").css("background-color", "#093C3C");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nuevo Meta");            
    $("#modalCRUD").modal("show"); 
    id_area = $.trim($("#id_area").val());
    //********id       
    id_meta=null;
    opcion = 1; //alta
});    
    
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click", ".btnEditar_meta", function(){
    fila = $(this).closest("tr");

    id_area = $.trim($("#id_area").val());
    id_meta = parseInt(fila.find('td:eq(0)').text());
    descripcion = fila.find('td:eq(1)').text();
    unidad_medida = fila.find('td:eq(2)').text();
    cantidad = parseInt(fila.find('td:eq(3)').text());
    gestion = parseInt(fila.find('td:eq(4)').text());
    periodo_meta = fila.find('td:eq(5)').text();
    
    $("#id_meta").val(id_meta);
    $("#descripcion").val(descripcion);
    $("#unidad_medida").val(unidad_medida);
    $("#cantidad").val(cantidad);
    $("#gestion").val(gestion);
    $("#periodo_meta").val(periodo_meta);

    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar meta");            
    $("#modalCRUD").modal("show");  
    
});

//mostrar ejecuciones
$(document).on("click", ".btnlista_ejecucion", function(){
    fila = $(this).closest("tr");
    id_meta = parseInt(fila.find('td:eq(0)').text());

    location.href='ejecucion.php?id_meta='+id_meta;

});

//botón BORRAR
$(document).on("click", ".btnBorrar_meta", function(){    
    fila = $(this);
    /*rescatamos el id_meta para poder mandarlo y eliminar*/
    id_meta = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3 //borrar
    
        $.ajax({
            url: "modelos/metas.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id_meta:id_meta},
            success: function(){
                tabla_meta.row(fila.parents('tr')).remove().draw();
            }
        });
       
});


$("#form_meta").submit(function(e){
    e.preventDefault();    
    descripcion = $.trim($("#descripcion").val());
    unidad_medida = $.trim($("#unidad_medida").val());
    cantidad = $.trim($("#cantidad").val());
    gestion = $.trim($("#gestion").val());
    periodo_meta = $.trim($("#periodo_meta").val());

    $.ajax({
        url: "modelos/metas.php",
        type: "POST",
        dataType: "json",
        data: {descripcion:descripcion, unidad_medida:unidad_medida, cantidad:cantidad, gestion:gestion, periodo_meta:periodo_meta, id_meta:id_meta, opcion:opcion, id_area:id_area},

        success: function(data){  
            console.log(data);
            id_meta = data[0].id_meta;            
            descripcion = data[0].descripcion;
            unidad_medida = data[0].unidad_medida;
            cantidad = data[0].cantidad;
            gestion = data[0].gestion;
            periodo_meta = data[0].periodo_meta;
            //*******tabla_
            if(opcion == 1){tabla_meta.row.add([id_meta,descripcion,unidad_medida,cantidad,gestion,periodo_meta]).draw();}
            else{tabla_meta.row(fila).data([id_meta,descripcion,unidad_medida,cantidad,gestion,periodo_meta]).draw();}          
        }        
    });
    $("#modalCRUD").modal("hide");    
    
});    
    
});