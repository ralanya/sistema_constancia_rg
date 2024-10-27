function solonumeros(evt){    
    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;
    
    if(code==8) { // backspace.
      return true;
    } else if(code>=48 && code<=57) { // is a number.
      return true;
    } else{ // other keys.
      return false;
    }
}
function sololetras(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-39-46";

    tecla_especial = false
    for(var i in especiales){
         if(key == especiales[i]){
             tecla_especial = true;
             break;
         }
     }

     if(letras.indexOf(tecla)==-1 && !tecla_especial){
         return false;
     }
 }
 function validarcorreo(e) {
    //$('.nav-tabs li:eq(2) a').tab('show');
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;W
    if (emailRegex.test(correo.value)) {
       alert("valido");     
    }else{
        alert("no valido");
    }    
 }

 function alertas(mensaje, icono) {
  Swal.fire({
      icon: icono,
      title: mensaje,
      showConfirmButton: false,
      timer:3000                        
  })
}
function alertas_error(mensaje, icono) {
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
      icon: icono,
      title: mensaje
  }) 
}