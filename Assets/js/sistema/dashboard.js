graficaEstudiantesxNivel();
function graficaEstudiantesxNivel() {
    const url = base_url + "Dashboard/reporteArchivoConstancia";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send();
    http.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);    
            let archivo = [];
            let cantidad = [];
            for (let i = 0; i < res.length; i++) {
                if(res[i]['archivo']=="GEN"){
                    $archivon = "Generado";
                }else if(res[i]['archivo']=="PDF"){
                    $archivon = "PDF";
                }else{
                    $archivon = "Otros";
                }
                archivo.push($archivon);
                cantidad.push(res[i]['total']);                
            }    
            //productos más vendidos
            var ctx = document.getElementById("pieArchivoConstancia");
            var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: archivo,
                datasets: [{
                data: cantidad,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                },
                legend: {
                display: false
                },
                cutoutPercentage: 80,
            },
            });
        }
    }
}