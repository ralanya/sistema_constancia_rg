//LISTAR TABLAS
let tblConstancias;
document.addEventListener("DOMContentLoaded", function(){     
    //tabla constancias
    tblConstancias = $('#tblConstancias').DataTable( {
        ajax: {
            url: base_url + "Constancias/listar",
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
                'data' : 'imagen'
            },
            {
                'data' : 'nombre_documento'
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
    } );    
})
//PERSONAL
function frmConstancia() {
    document.getElementById("title").innerHTML = "Nueva Constancia";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline';
    deleteImg();
    document.getElementById("frmConstancia").reset();
    $("#nueva_constancia").modal("show");
    document.getElementById("txtid").value = "";      
}
function registrarConst(e) {
    e.preventDefault(); 
    ControlesFormulario(false);
    
    const url = base_url + "Constancias/registrar";
    const frm = document.getElementById("frmConstancia");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {         
            console.log(this.responseText);
            const res = JSON.parse(this.responseText);
            if (res.icono == "success") {
                alertas(res.msg, res.icono);                    
                frm.reset();
                $("#nueva_constancia").modal("hide");
                tblConstancias.ajax.reload();
            }else{
                alertas_error(res.msg, res.icono);
            }       
        }
    }
    
}
function btnEditarCons(id) {
    document.getElementById("title").innerHTML = "Editar Constancia";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline';
    ControlesFormulario(false);

    const url = base_url + "Constancias/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) { 
            console.log(this.responseText);           
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.id;
            document.getElementById("txtnombre").value = res.nombre;     
            document.getElementById("txthoras").value = res.horas;            
            document.getElementById("txtfechainicio").value = res.fecha_inicio;
            document.getElementById("txtfechafin").value = res.fecha_fin;
            document.getElementById("txtdescripcion").value = res.descripcion;
            document.getElementById("cbodocumento").value = res.id_documento;
            document.getElementById("img-preview").src = base_url + 'Assets/documentos/images/'+res.imagen;
            document.getElementById("icon-cerrar").innerHTML = `
            <button class="btn btn-danger mb-2" onclick="deleteImg();"><i class="fas fa-times"></i></button>`;
            document.getElementById("icon-image").classList.add("d-none");
            document.getElementById("foto-actual").value = res.imagen;
            $("#nueva_constancia").modal("show");
        }
    }      
}
function btnDetalleCons(id) {
    document.getElementById("title").innerHTML = "Detalle Constancia";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'none';      
    ControlesFormulario(true);
    
    const url = base_url + "Constancias/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {            
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.id;
            document.getElementById("txtnombre").value = res.nombre;     
            document.getElementById("txthoras").value = res.horas;            
            document.getElementById("txtfechainicio").value = res.fecha_inicio;
            document.getElementById("txtfechafin").value = res.fecha_fin;
            document.getElementById("txtdescripcion").value = res.descripcion;
            document.getElementById("cbodocumento").value = res.id_documento;
            document.getElementById("img-preview").src = base_url + 'Assets/documentos/images/'+res.imagen;
            document.getElementById("icon-image").classList.add("d-none");
            document.getElementById("foto-actual").value = res.imagen;
            $("#nueva_constancia").modal("show");
        }
    }
}

function ControlesFormulario($valor) {
    document.getElementById("txtnombre").disabled = $valor;     
    document.getElementById("txthoras").disabled = $valor;       
    document.getElementById("txtfechainicio").disabled = $valor; 
    document.getElementById("txtfechafin").disabled = $valor; 
    document.getElementById("txtdescripcion").disabled = $valor; 
    document.getElementById("cbodocumento").disabled = $valor; 
}

function cerrar_constancia() {
    $("#nueva_constancia").modal("hide");
}
function btnEliminarCons(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La constancia cambiara ha estado inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Constancias/eliminar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblConstancias.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            } 
            
        }
      })
}
function btnReingresarCons(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La constancia cambiara ha estado activo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Reingresalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Constancias/reingresar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblConstancias.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            }             
        }
      })
}

//IMAGEN
function preview(e) {
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML = `
    <button class="btn btn-danger mb-2" onclick="deleteImg();"><i class="fas fa-times"></i></button>
    ${url['name']}`;
}
function deleteImg() {    
    document.getElementById("icon-cerrar").innerHTML = '';
    document.getElementById("icon-image").classList.remove("d-none");
    document.getElementById("img-preview").src = '';
    document.getElementById("imagen").value = '';
    document.getElementById("foto-actual").value = '';
}

function generarPDFConstancia() {
    const ruta = base_url + 'Constancias/generarPDF';
    window.open(ruta); 
}