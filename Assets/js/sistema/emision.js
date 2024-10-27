//LISTAR TABLAS
let tblEmisiones;
document.addEventListener("DOMContentLoaded", function(){      
    $('#cboconstancias').select2({        
        width: '100%',
        dropdownParent: $('#nueva_emision'), 
        language: {
            noResults: function() {        
              return "No hay resultados";        
            },
            searching: function() {        
              return "Buscando..";
            }
          }
    });
    //tabla estudiantes
    tblEmisiones = $('#tblEmisiones').DataTable( {
        ajax: {
            url: base_url + "Emisiones/listar",
            dataSrc: ''
        },
        columns: [
            {
                'data' : 'id'
            },
            {
                'data' : 'codigo'
            },
            {
                'data' : 'FEmision'
            },
            {
                'data' : 'documento'
            },
            {
                'data' : 'numero'
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
    } );       
})
//ESTUDIANTES
function frmEmision() {
    document.getElementById("title").innerHTML = "Nueva Emisión";
    document.getElementById("btnAccion").innerHTML = "Registrar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline';
    
    deleteImg();   
    document.getElementById("txtmensajearchivo").classList.remove("d-none"); 
    document.getElementById("iframePDF-preview").classList.add("d-none"); 
    document.getElementById("grupoarchivo").classList.add("d-none"); 
    document.getElementById("frmEmision").reset();

    $('#cboconstancias').select2({        
        width: '100%',
        dropdownParent: $('#nueva_emision'), 
        language: {
            noResults: function() {        
              return "No hay resultados";        
            },
            searching: function() {        
              return "Buscando..";
            }
          }
    });     
    
    $('.nav-tabs li:eq(0) a').tab('show');
    $("#nueva_emision").modal("show");
    document.getElementById("txtid").value = "";    
}

function ocultarArchivo() {    
    document.getElementById("grupoarchivo").classList.add("d-none");
    document.getElementById("txtmensajearchivo").classList.remove("d-none");
    document.getElementById("iframePDF-preview").classList.add("d-none"); 
}
function cargarArchivo() {
    deleteImg();
    document.getElementById("grupoarchivo").classList.remove("d-none");
    document.getElementById("txtmensajearchivo").classList.add("d-none");
    document.getElementById("iframePDF-preview").classList.remove("d-none"); 
    $('.nav-tabs li:eq(3) a').tab('show');    
}
function cargarConstancia() {
    const $id = document.getElementById("cboconstancias").value;
    if($id!="NA"){
        const url = base_url + "Emisiones/buscaConstancia/"+$id;
        const http = new XMLHttpRequest();
        http.open("GET", url, true);
        http.send();
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {            
                const res = JSON.parse(this.responseText);
                document.getElementById("txtidconstancia").value = res.id;
                document.getElementById("cbodocumento").value = res.id_documento;   
                document.getElementById("txtdescripcion").value = res.descripcion;   
                document.getElementById("txthoras").value = res.horas;   
                document.getElementById("txtfechainicio").value = res.fecha_inicio;    
                document.getElementById("txtfechafin").value = res.fecha_fin;   
            }
        }
    }else if($id=="NA"){
        document.getElementById("cbodocumento").value="NA";
        document.getElementById("txthoras").value=0;  
        document.getElementById("txtdescripcion").value="Descripción"
        document.getElementById("txtfechainicio").value="dd/mm/aaa"; 
        document.getElementById("txtfechafin").value="dd/mm/aaa"; 
    }
}

function cargarRemitente() {    
    const url = base_url + "Emisiones/buscaRemitente";
    const frm = document.getElementById("frmEmision");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200){      
        const res = JSON.parse(this.responseText);
            if(res.icono == "warning"){
                alertas_error(res.msg,res.icono);
                habilitarcontrolesremitente(true);     
                document.getElementById("txtapellidos").value= "";
                document.getElementById("txtnombres").value= "";
                document.getElementById("cbosexo").value="NA";
                document.getElementById("cbosituacion").value="NA";  
                document.getElementById("txtsituacion").value="";
            }else{
                habilitarcontrolesremitente(true);
                document.getElementById("cbosituacion").disabled = true;                
                document.getElementById("txtapellidos").value=res.apellidos;
                document.getElementById("txtnombres").value=res.nombres;
                document.getElementById("cbosexo").value=res.sexo;
                document.getElementById("cbosituacion").value=res.situacion; 
                document.getElementById("txtsituacion").value=res.situacion; 
                document.getElementById("txtverificanumero").value=res.numero; 
                
            }    
        }
    }    
}

function habilitarcontrolesremitente($valor) {
    document.getElementById("txtapellidos").disabled = $valor;  
    document.getElementById("txtnombres").disabled = $valor;
    document.getElementById("cbosexo").disabled = $valor;   
}
function habilitarcontroles($valor) {
    document.getElementById("txtfecha").disabled = $valor;        
    document.getElementById("cboarchivo").disabled = $valor; 
    document.getElementById("cbopuesto").disabled = $valor; 
    document.getElementById("txtnota").disabled = $valor; 
    document.getElementById("cboconstancias").disabled = $valor; 
    document.getElementById("btnBuscar").disabled = $valor;      
}
function registrarEmi(e) {
    e.preventDefault();
    //Emisión
    const fecha = document.getElementById("txtfecha");        
    const archivo = document.getElementById("cboarchivo");    

    //constancia
    const constancia = document.getElementById("cboconstancias");

    //remitente
    const documentopersona = document.getElementById("cbodocumentopersona");        
    const numero = document.getElementById("txtnumero");  
    const apellidos = document.getElementById("txtapellidos");  
    const nombres = document.getElementById("txtnombres");  
    const sexo = document.getElementById("cbosexo");   
    const situacion = document.getElementById("cbosituacion");   

    habilitarcontroles(false);
    //validacion    
    if(fecha.value == "" || archivo.value == "NA"){
        $('.nav-tabs li:eq(0) a').tab('show'); 
        alertas_error('Campos obligatorios (*) de la emisión','warning');    
    }
    else if(constancia.value == "NA"){
        $('.nav-tabs li:eq(1) a').tab('show'); 
        alertas_error('Campos obligatorios (*) de la constancia','warning');           
    }
    else if(documentopersona.value == "NA" || numero.value == ""){
        $('.nav-tabs li:eq(2) a').tab('show'); 
        alertas_error('Campos obligatorios (*) del remitente','warning');   
    }
    else if(apellidos == ""  || situacion.value == "NA"){
        alertas_error('No ha buscado el remitente','warning');                       
    }
    else{
        const url = base_url + "Emisiones/registrar";
        const frm = document.getElementById("frmEmision");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {                
                const res = JSON.parse(this.responseText);
                if (res.icono == "success") {
                    alertas(res.msg,res.icono);
                    frm.reset();
                    $("#nueva_emision").modal("hide");
                    tblEmisiones.ajax.reload();
                }else{
                    alertas_error(res.msg,res.icono);
                }
            }
        }
    }
}

//IMAGEN
function preview(e) {
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("iframePDF-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML = `
    <button class="btn btn-danger mb-2" onclick="deleteImg();"><i class="fas fa-times"></i></button>
    ${url['name']}`;
}
function deleteImg() {    
    document.getElementById("icon-cerrar").innerHTML = '';
    document.getElementById("icon-image").classList.remove("d-none");
    document.getElementById("iframePDF-preview").src = '';
    document.getElementById("imagen").value = '';
    document.getElementById("foto-actual").value = '';
}

function btnEditarEmi(id) {
    document.getElementById("title").innerHTML = "Editar Emisión";
    document.getElementById("btnAccion").innerHTML = "Actualizar";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'inline'; 
     
    $('.nav-tabs li:eq(0) a').tab('show'); 
    habilitarcontroles(false);
    const url = base_url + "Emisiones/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {          
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.id;
            document.getElementById("txtfecha").value = res.fecha;             
            document.getElementById("cboarchivo").value = res.archivo; 
            const archivo = res.archivo;            

            if(archivo == "GEN"){
                ocultarArchivo();                                
            }else{
                cargarArchivo(); 
                document.getElementById("iframePDF-preview").src = base_url + 'Assets/documentos/PDF/'+res.url;
                document.getElementById("icon-cerrar").innerHTML = `
                <button class="btn btn-danger mb-2" onclick="deleteImg();"><i class="fas fa-times"></i></button>`;
                document.getElementById("icon-image").classList.add("d-none");
                document.getElementById("foto-actual").value = res.url;                            
            }

            const puesto = res.puesto;
            if(puesto != 0){ document.getElementById("cbopuesto").value = res.puesto; 
            }else{ document.getElementById("cbopuesto").value = "NA"; }  

            document.getElementById("txtnota").value = res.nota;                         

            $("#cboconstancias").select2("val", res.id_constancia); 
            cargarConstancia(res.id_constancia);     

            document.getElementById("cbodocumentopersona").value = res.documento;
            document.getElementById("txtnumero").value = res.numero;  
            cargarRemitente();
            $("#nueva_emision").modal("show");
        }
    }      
}
function btnDetalleEmi(id) {
    document.getElementById("title").innerHTML = "Detalle Emisión";
    $btnAccion = document.getElementById("btnAccion");
    btnAccion.style.display = 'none';  

    $('.nav-tabs li:eq(0) a').tab('show'); 

    habilitarcontroles(true);

    const url = base_url + "Emisiones/editar/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {            
            const res = JSON.parse(this.responseText);
            document.getElementById("txtfecha").value = res.fecha;             
            document.getElementById("cboarchivo").value = res.archivo; 
            const archivo = res.archivo;            

            if(archivo == "GEN"){
                ocultarArchivo();                                
            }else{
                cargarArchivo(); 
                document.getElementById("iframePDF-preview").src = base_url + 'Assets/documentos/PDF/'+res.url;
                document.getElementById("icon-cerrar").innerHTML = `
                <button class="btn btn-danger mb-2" onclick="deleteImg();"><i class="fas fa-times"></i></button>`;
                document.getElementById("icon-image").classList.add("d-none");
                document.getElementById("foto-actual").value = res.url;                            
            }

            const puesto = res.puesto;
            if(puesto != 0){ document.getElementById("cbopuesto").value = res.puesto; 
            }else{ document.getElementById("cbopuesto").value = "NA"; }  

            document.getElementById("txtnota").value = res.nota;                         

            $("#cboconstancias").select2("val", res.id_constancia); 
            cargarConstancia(res.id_constancia);     

            document.getElementById("cbodocumentopersona").value = res.documento;
            document.getElementById("txtnumero").value = res.numero;  
            cargarRemitente();
            $("#nueva_emision").modal("show");
        }
    }      
}
function cerrar_emision() {
    $("#nueva_emision").modal("hide");   
}
function btnEliminarEmi(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La emisión cambiara ha estado inactivo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Eliminalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Emisiones/eliminar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblEmisiones.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            } 
            
        }
      })
}
function btnReingresarEmi(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "La emisión cambiara ha estado activo",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, ¡Reingresalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "Emisiones/reingresar/"+id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    if (res.icono == "success") {
                        alertas(res.msg, res.icono);
                        tblEmisiones.ajax.reload();
                    }else{
                        alertas_error(res.msg, res.icono);
                    }
                }
            }             
        }
      })
}

function generarPDFEmision() {
    const ruta = base_url + 'Emisiones/generarPDF';
    window.open(ruta); 
}