//LISTAR TABLAS
let tblUsuarios;
document.addEventListener("DOMContentLoaded", function(){
    //tabla usuarios
    tblUsuarios = $('#tblUsuarios').DataTable( {
        ajax: {
            url: base_url + "Usuarios/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data' : 'id'
            },
            {
                'data' : 'usuario'
            },
            {
                'data' : 'apellidos'
            },
            {
                'data' : 'nombres'
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
            
        },
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
//USUARIOS
function frmUsuario() {
    document.getElementById("title").innerHTML = "Nuevo Usuario";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    document.getElementById("claves").classList.remove("d-none");
    document.getElementById("frmUsuario").reset();
    $("#nuevo_usuario").modal("show");
    document.getElementById("txtid").value = "";

    //habilitando input usuario
    document.getElementById('txtusuario').readOnly = false;   
}
function registrarUser(e) {
    e.preventDefault();
    const usuario = document.getElementById("txtusuario");
    const nombre = document.getElementById("txtnombre");
    const apellido = document.getElementById("txtapellido");
    const password = document.getElementById("txtclave");
    const confirmar = document.getElementById("txtconfirmar");
    const rol = document.getElementById("cborol");
    if(usuario.value == "" || apellido.value == "" || nombre.value == "" || rol.value == ""){
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
    }/*else if(password.value != confirmar.value){
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
            title: 'Las contraseñas no coinciden'
        })
    }*/else{
        const url = base_url + "Usuarios/registrar";
        const frm = document.getElementById("frmUsuario");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res === "si") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario registrado con éxito',
                        showConfirmButton: false,
                        timer:3000                        
                    })
                    frm.reset();
                    $("#nuevo_usuario").modal("hide");
                    tblUsuarios.ajax.reload();
                }else if(res == "modificado"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario actualizado con éxito',
                        showConfirmButton: false,
                        timer:3000                        
                    })
                    $("#nuevo_usuario").modal("hide");
                    tblUsuarios.ajax.reload();
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
function btnEditarUser(id) {
    document.getElementById("title").innerHTML = "Editar Usuario";
    document.getElementById("btnAccion").innerHTML = "Actualizar";

    //desabilitando input usuario
    document.getElementById('txtusuario').readOnly = true;   
    
    const url = base_url + "Usuarios/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.id;
            document.getElementById("txtusuario").value = res.usuario;
            document.getElementById("txtapellido").value = res.apellidos;
            document.getElementById("txtnombre").value = res.nombres;
            document.getElementById("cborol").value = res.id_rol;
            document.getElementById("claves").classList.add("d-none");
            $("#nuevo_usuario").modal("show");
        }
    }      
}
function btnEliminarUser(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El usuario cambiara ha estado inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/eliminar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario eliminado con éxito',
                            showConfirmButton: false,
                            timer:3000
                        })
                        tblUsuarios.ajax.reload();
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
function btnReingresarUser(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "El usuario cambiara ha estado activo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Reingresalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Usuarios/reingresar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res == "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario reingresado con éxito',
                            showConfirmButton: false,
                            timer:3000
                        })
                        tblUsuarios.ajax.reload();
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

//CONFIGURACION PERFIL
function modificarPerfil() {
    const frm = document.getElementById('frmPerfil');
    const url = base_url + "Usuarios/modificaPerfil";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {        
           const res = JSON.parse(this.responseText);         
            if(res == 'ok'){
                Swal.fire({
                    icon: 'success',
                    title: 'Perfil modificado con éxito',
                    showConfirmButton: false,
                    timer:3000
                })
                document.getElementById('clave').value = "";
                document.getElementById('repitaclave').value = "";
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