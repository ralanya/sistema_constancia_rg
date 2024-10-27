//CONFIGURACION EMPRESA
function modificarEmpresa() {
    const frm = document.getElementById('frmEmpresa');
    const url = base_url + "Administracion/modificar";
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200) {
           const res = JSON.parse(this.responseText);         
            if(res == 'ok'){
                Swal.fire({
                    icon: 'success',
                    title: 'Institución modificada con éxito',
                    showConfirmButton: false,
                    timer:3000
                })
                setTimeout(() => {
                    window.location.reload();
                },3000);
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