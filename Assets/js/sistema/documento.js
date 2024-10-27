//LISTAR TABLAS
let tblDocumentos;
document.addEventListener("DOMContentLoaded", function(){        
    //tabla documentos
    tblDocumentos = $('#tblDocumentos').DataTable( {
        ajax: {
            url: base_url + "Documentos/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data' : 'id'
            },
            {
                'data' : 'nombre'
            },
            {
                'data' : 'estado'
            },
            {
                'data' : 'acciones'
            }           
        ],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
            "infoEmpty": "Mostrando 0 to 0 of 0 Registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
        ,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
                //Botón para Excel
                {
                    extend: 'excelHtml5',
                    footer: true,
                    title: 'Archivo',
                    filename: 'Export_File',
     
                    //Aquí es donde generas el botón personalizado
                    text: '<span class="badge badge-success"><i class="fas fa-file-excel"></i></span>'
                },
                //Botón para PDF
                {
                    extend: 'pdfHtml5',
                    download: 'open',
                    footer: true,
                    title: 'Reporte de usuarios',
                    filename: 'Reporte de usuarios',
                    text: '<span class="badge  badge-danger"><i class="fas fa-file-pdf"></i></span>',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                //Botón para copiar
                {
                    extend: 'copyHtml5',
                    footer: true,
                    title: 'Reporte de usuarios',
                    filename: 'Reporte de usuarios',
                    text: '<span class="badge  badge-primary"><i class="fas fa-copy"></i></span>',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                //Botón para print
                {
                    extend: 'print',
                    footer: true,
                    filename: 'Export_File_print',
                    text: '<span class="badge badge-light"><i class="fas fa-print"></i></span>'
                },
                //Botón para cvs
                {
                    extend: 'csvHtml5',
                    footer: true,
                    filename: 'Export_File_csv',
                    text: '<span class="badge  badge-success"><i class="fas fa-file-csv"></i></span>'
                },
                //Filtrar columnas
                {
                    extend: 'colvis',
                    text: '<span class="badge  badge-info"><i class="fas fa-columns"></i></span>',
                    postfixButtons: ['colvisRestore']
                }
            ]
    } );  
})
//DOCUMENTOS
function frmDocumento() {
    document.getElementById("title").innerHTML = "Nuevo Documento";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmDocumento").reset();
    $("#nuevo_documento").modal("show");
    document.getElementById("txtid").value = "";    
}
function registrarDocu(e) {
    e.preventDefault();
    const nombre = document.getElementById("txtnombre");
    
    if(nombre.value == ""){
        alertas_error('Todos los campos son obligatorios','warning');  
    }else{
        const url = base_url + "Documentos/registrar";
        const frm = document.getElementById("frmDocumento");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {                
                const res = JSON.parse(this.responseText);
                if (res.icono == "success") {
                    alertas(res.msg, res.icono);                    
                    frm.reset();
                    $("#nuevo_documento").modal("hide");
                    tblDocumentos.ajax.reload();
                }else{
                    alertas_error(res.msg, res.icono);
                } 
            }
        }
    }
}
function btnEditarDoc(id) {
    document.getElementById("title").innerHTML = "Editar Documento";
    document.getElementById("btnAccion").innerHTML = "Actualizar";

    //desabilitando input dni
    //document.getElementById('txtnombre').readOnly = true;   
    
    const url = base_url + "Documentos/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {            
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.id;
            document.getElementById("txtnombre").value = res.nombre;
            $("#nuevo_documento").modal("show");
        }
    }      
}
function btnEliminarDoc(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El documento cambiara ha estado inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Documentos/eliminar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);  
                        tblDocumentos.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            } 
            
        }
      })
}
function btnReingresarDoc(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El documento cambiara ha estado activo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Reingresalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Documentos/reingresar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);  
                        tblDocumentos.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            } 
            
        }
      })
}