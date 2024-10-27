//LISTAR TABLAS
let tblRoles;
document.addEventListener("DOMContentLoaded", function(){        
    //tabla roles
    tblRoles = $('#tblRoles').DataTable( {
        ajax: {
            url: base_url + "Roles/listar",
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
//ROLES
function frmRol() {
    document.getElementById("title").innerHTML = "Nuevo Rol";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("frmRol").reset();
    $("#nuevo_rol").modal("show");
    document.getElementById("txtid").value = "";    
}
function registrarRo(e) {
    e.preventDefault();
    const nombre = document.getElementById("txtnombre");
    
    if(nombre.value == ""){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
          
        Toast.fire({
            icon: 'error',
            title: 'Todos los campos son obligatorios'
        })   
    }else{
        const url = base_url + "Roles/registrar";
        const frm = document.getElementById("frmRol");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {                
                const res = JSON.parse(this.responseText);
                if (res === "si") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rol registrado con éxito',
                        showConfirmButton: false,
                        timer:3000                        
                    })
                    frm.reset();
                    $("#nuevo_rol").modal("hide");
                    tblRoles.ajax.reload();
                }else if(res == "modificado"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Rol actualizado con éxito',
                        showConfirmButton: false,
                        timer:3000                        
                    })
                    $("#nuevo_rol").modal("hide");
                    tblRoles.ajax.reload();
                }                
                else{
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.addEventListener('mouseenter', Swal.stopTimer)
                          toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                      
                    Toast.fire({
                        icon: 'error',
                        title: res
                    })
                }
            }
        }
    }
}
function btnEditarRo(id) {
    document.getElementById("title").innerHTML = "Editar Rol";
    document.getElementById("btnAccion").innerHTML = "Actualizar";

    //desabilitando input dni
    //document.getElementById('txtnombre').readOnly = true;   
    
    const url = base_url + "Roles/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {            
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.id;
            document.getElementById("txtnombre").value = res.nombre;
            $("#nuevo_rol").modal("show");
        }
    }      
}
function btnEliminarRo(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El rol cambiara ha estado inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Roles/eliminar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Rol eliminado con éxito',
                            showConfirmButton: false,
                            timer:3000
                        })
                        tblRoles.ajax.reload();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: res,
                            showConfirmButton: false,
                            timer:3000
                        })
                    }
                }
            } 
            
        }
      })
}
function btnReingresarRo(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El rol cambiara ha estado activo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Reingresalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Roles/reingresar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Rol reingresado con éxito',
                            showConfirmButton: false,
                            timer:3000
                        })
                        tblRoles.ajax.reload();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: res,
                            showConfirmButton: false,
                            timer:3000
                        })
                    }
                }
            } 
            
        }
      })
}