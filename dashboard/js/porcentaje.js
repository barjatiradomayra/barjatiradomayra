var select_area = $("#select_area_1").val();

$(document).ready(mostrar(select_area_1));
function mostrar(area){

    $.ajax({
        url:"modelos/graficos.php",
        type:"POST",
        data:'area='+area,
    }).done(function(resp){
        var titulo=[];
        var cantidad_m=[];
        var cantidad_e=[];
        var porcentaje_e=[];
        data=JSON.parse(resp);

        for(var i=0;i<data.length;i++){
            titulo.push(data[i][1]);
            cantidad_m.push(data[i][0]);
            cantidad_e.push(data[i][2]);
            porcentaje_e.push(data[i][3]);
        }

        var data = {
            labels:titulo,
            datasets:[
                {
                    label:"ejecucion",
                    backgroundColor :"yellow",
                    data:cantidad_m

                },
                {
                    label: "meta",
                    backgroundColor: "green",
                    data: cantidad_e
                }
            ]
        };
        var ctx = document.getElementById("myBarChart").getContext('2d');
        
        
        var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
            padding: {
                left: 5,
                right: 10,
                top: 5,
                bottom: 0
            }
            },
            scales: {
                
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 800, //limite de altura en y
                    // maxTicksLimit: 10,
                    
                    },
                }],
            },
        }
        });
    

    })

} 