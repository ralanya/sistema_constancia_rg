// function verradiovalue(){
//     var radiovalue=document.frmBusquedaConstancia.rdopcion.value;
//     if(radiovalue.length==0) radiovalue="ninguno";
//     alert("Valor seleccionado: " + radiovalue);
// }

//BUSQUEDA
function frmBusqueda(e) {
    e.preventDefault();
    var opcion = document.frmBusquedaConstancia.rdopcion.value;
    const documento = document.getElementById("cbodocumento");
    const busqueda = document.getElementById("txtBusqueda");
    
    if(busqueda.value == ""){        
        busqueda.focus();
    }else{
        const url = base_url + "Busqueda/validar";
        const frm = document.getElementById("idform");
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(new FormData(frm));
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                const res = JSON.parse(this.responseText);
                if(res == "ok"){
                    window.location = base_url + "Busqueda";
                }else{
                    document.getElementById("alerta").classList.remove("d-none");
                    document.getElementById("alerta").innerHTML = res;
                }
            }
        }
    }
}

function cargarTipoDocumento() {
    document.getElementById("inputdocumento").classList.remove("d-none");    
}
function ocultarTipoDocumento() {
    document.getElementById("inputdocumento").classList.add("d-none");
}
if (document.getElementById('tblResultados')) {
    cargarResultado();
}
function cargarResultado() {    
        $(document).ready(function(){
        $('#tblResultados').DataTable( {
        ajax: {
            url: base_url + "Busqueda/listados",        
            dataSrc: ''
        },
        columns: [            
            {
                'data' : 'nombre'
            },
            {
                'data' : 'codigo'
            },
            {
                'data' : 'tipo'
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
        });
    })
}

function btnDescargaCons(id) {
    $("#detalle_constancia").modal("hide");
    document.getElementById("titleDescarga").innerHTML = "Vista Previa de la Constancia";

    const url = base_url + "Busqueda/detalle/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {    
            //console.log(this.responseText);        
            const res = JSON.parse(this.responseText);
            const ruta = base_url + 'Busqueda/generarPDF/'+res.codigo+"-"+res.archivo+"-"+res.id;
            window.open(ruta);
            //document.getElementById("iframePDF").value = res.url;            
            //$('#iframePDF').attr('src',base_url + 'documentos/' + res.url);            
        }
    }    
}

function btnDescargaConstancia() {    
    document.getElementById("titleDescarga").innerHTML = "Vista Previa de la Constancia";
    const id = document.getElementById("txtid").value;
    const url = base_url + "Busqueda/detalle/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {        
            const res = JSON.parse(this.responseText);
            const ruta = base_url + 'Busqueda/generarPDF/'+res.codigo+"-"+res.archivo+"-"+res.id;
            window.open(ruta);           
        }
    }    
}

function btnDetalleCons(id) {
    document.getElementById("title").innerHTML = "Información de la Constancia";
    document.getElementById("btnAccion").innerHTML = "Descargar";    

    const url = base_url + "Busqueda/detalle/"+id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {    
            //console.log(this.responseText);        
            const res = JSON.parse(this.responseText);
            document.getElementById("txtid").value = res.id;
            document.getElementById("cbodocumento").value = res.documento;     
            document.getElementById("txtnumerodetalle").value = res.numero;            
            document.getElementById("cbosituacion").value = res.situacion;
            document.getElementById("txtnombreconcurso").value = res.nombre;
            document.getElementById("txtcodigo").value = res.codigo;
            document.getElementById("txtfechaemision").value = res.fecha;
            document.getElementById("cbotipoconstancia").value = res.id_documento;
            document.getElementById("cbopuesto").value = res.puesto;
            document.getElementById("txtnota").value = res.nota;
            document.getElementById("txthora").value = res.horas;
            document.getElementById("txtdescripcion").value = res.descripcion;
            document.getElementById("txtfechainicio").value = res.fecha_inicio;
            document.getElementById("txtfechafin").value = res.fecha_fin;
            $("#detalle_constancia").modal("show");
        }
    }  
}

function cerrar_detalle() {
    $("#detalle_constancia").modal("hide");
}
function cerrar_descarga() {
    $("#descarga_constancia").modal("hide");
}