function cargarConstancia() {
    const archivoexcel = document.getElementById("file-constancia");
    if(archivoexcel.value==""){
        Swal.fire({
            icon: 'error',
            title: 'Seleccione un archivo excel',
            showConfirmButton: false,
            timer:3000
        })
    }else{
        const url = base_url + "Excel/registrarCons";
        const frm = document.getElementById("frmcargaConstancia");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {    
            //console.log(this.responseText);           
            const res = JSON.parse(this.responseText);
            const split = res.split(',');
                Swal.fire({
                    icon: 'success',
                    title: 'Resumen de constancias: ',
                    text: 'Nuevos: '+split[0]+' - Actualizados: '+split[1] + ' - Errores: '+split[2],
                    showConfirmButton: true,
                    confirmButtonText: "Aceptar"                                                
                })
                document.getElementById("file-constancia").value = "";
            }
        }
    }  
}

function cargarExcelEmision() {
    const archivoexcel = document.getElementById("file-emision");
    if(archivoexcel.value==""){
        Swal.fire({
            icon: 'error',
            title: 'Seleccione un archivo excel',
            showConfirmButton: false,
            timer:3000
        })
    }else{
        const url = base_url + "Excel/registrarEmi";
        const frm = document.getElementById("frmcargaEmision");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {      
            console.log(this.responseText);         
            const res = JSON.parse(this.responseText);
            const split = res.split(',');
                Swal.fire({
                    icon: 'success',
                    title: 'Resumen de emisiones: ',
                    text: 'Nuevos: '+split[0]+' - Actualizados: '+split[1] + ' - Errores: '+split[2],
                    showConfirmButton: true,
                    confirmButtonText: "Aceptar"                                                
                })
                document.getElementById("file-emision").value = "";
            }
        }
    }  
}

function cargarExcelPersonal() {
    const archivoexcel = document.getElementById("file-personal");
    if(archivoexcel.value==""){
        Swal.fire({
            icon: 'error',
            title: 'Seleccione un archivo excel',
            showConfirmButton: false,
            timer:3000
        })
    }else{
        const url = base_url + "Excel/registrarPers";
        const frm = document.getElementById("frmcargaPersonal");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {    
            //console.log(this.responseText);           
            const res = JSON.parse(this.responseText);
            const split = res.split(',');
                Swal.fire({
                    icon: 'success',
                    title: 'Resumen de personal: ',
                    text: 'Nuevos: '+split[0]+' - Actualizados: '+split[1] + ' - Errores: '+split[2],
                    showConfirmButton: true,
                    confirmButtonText: "Aceptar"                                                
                })
                document.getElementById("file-personal").value = "";
            }
        }
    }  
}

function cargarExcelFamilia() {
    const archivoexcel = document.getElementById("file-familia");
    if(archivoexcel.value==""){
        Swal.fire({
            icon: 'error',
            title: 'Seleccione un archivo excel',
            showConfirmButton: false,
            timer:3000
        })
    }else{
        const url = base_url + "Excel/registrarFam";
        const frm = document.getElementById("frmcargaFamilia");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {    
            //console.log(this.responseText);           
            const res = JSON.parse(this.responseText);
            const split = res.split(',');
                Swal.fire({
                    icon: 'success',
                    title: 'Resumen de familia: ',
                    text: 'Nuevos: '+split[0]+' - Actualizados: '+split[1] + ' - Errores: '+split[2],
                    showConfirmButton: true,
                    confirmButtonText: "Aceptar"                                                
                })
                document.getElementById("file-familia").value = "";
            }
        }
    }  
}

//validacion archivo excel
$('input[type="file"]').on('change', function(){
var ext = $( this ).val().split('.').pop();
    if ($( this ).val() != '') {
        if(ext == "xls" || ext == "xlsx" || ext == "csv"){
            if($(this)[0].files[0].size > 1048576){
                Swal.fire({
                    icon: 'error',
                    title: 'El documento excede el tamaño máximo',
                    showConfirmButton: false,
                    timer:3000
                })
            }else{}
        }
        else
        {
            $(this ).val('');
            Swal.fire({
                icon: 'error',
                title: 'Extension no permitida: '+ext,
                showConfirmButton: false,
                timer:3000
            })
        }
    }
});
