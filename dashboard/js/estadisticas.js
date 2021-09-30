
var selectArea= $("#selectArea").val();

$(document).ready(mostrarGrafico(selectArea));
function mostrarGrafico(area){
    $.ajax({
        url: "modelos/graficos.php",
        type: "POST",
        data:'area='+area,
    }).done(function(resp) {
        var titulo=[];
        var cantidad_m=[];
        var cantidad_e=[];
        var porcentaje_e=[];
        data=JSON.parse(resp);
        for(var i=0; i<data.length ; i++){
            titulo.push(data[i][1]);
            cantidad_m.push(data[i][0]);
            cantidad_e.push(data[i][2]);
            porcentaje_e.push(data[i][3]);
        }


        var data = {
        labels: titulo,
        datasets: [
            {
                label: "Meta",
                backgroundColor: "blue",
                data: cantidad_m
            },
            {
                label: "Ejecución",
                backgroundColor: "green",
                data: cantidad_e
            }
        ]
        };
        // Bar Chart Example
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




        // Pie Chart Example
        // var ctx = document.getElementById("myPieChart");
        // var myPieChart = new Chart(ctx, {
        // type: 'pie',
        // data: {
        //     labels: titulo, // de la bd
        //     datasets: [{
        //     data: porcentaje_e, // de la bd
        //     backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc','#72FCCC', '#E7E68E'],
        //     hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf','#72FCCC', '#E7E68E'],
        //     hoverBorderColor: "rgba(234, 236, 244, 1)",
        //     }],
        // },
        // options: {
        //     maintainAspectRatio: false,
        //     tooltips: {
        //     backgroundColor: "rgb(255,255,255)",
        //     bodyFontColor: "#858796",
        //     borderColor: '#dddfeb',
        //     borderWidth: 1,
        //     xPadding: 10,
        //     yPadding: 10,
        //     displayColors: true,
        //     caretPadding: 10,
        //     },
        //     legend: {
        //     display: true,
        //     position: 'top'

        //     },

        // },
        // });
// 
    });
}