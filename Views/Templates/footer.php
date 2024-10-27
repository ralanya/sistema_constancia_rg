    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Derechos de autor: RAC ENGINEERS PROFESIONAL 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Desea salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Salir" para cerrar sesión.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="<?php echo base_url; ?>Usuarios/salir">Salir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url; ?>Assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url; ?>Assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url; ?>Assets/js/sb-admin-2.min.js"></script>   

    <!-- Page level custom scripts -->
    <!-- <script src="<?php echo base_url; ?>Assets/js/demo/chart-area-demo.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/demo/chart-pie-demo.js"></script> -->

    <!-- Page level plugins -->
    <!-- <script src="<?php echo base_url; ?>Assets/vendor/datatables/jquery.dataTables.min.js"></script> -->
    <!-- <script src="<?php echo base_url; ?>Assets/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
    <script src="<?php echo base_url; ?>Assets/DataTables/datatables.min.js"></script>
    
    <!-- Page level custom scripts -->
    
    <!-- JS -->
    <script>
        const base_url = "<?php echo base_url; ?>";
    </script>
    <script src="<?php echo base_url; ?>Assets/js/sweetalert2.all.min.js"></script>

    <script src="<?php echo base_url; ?>Assets/js/select2.min.js"></script>

    <script src="<?php echo base_url; ?>Assets/js/sistema/funciones.js"></script>
    
    <?php 
    $host= $_SERVER["HTTP_HOST"];
    $url= $_SERVER["REQUEST_URI"];
    list($url1,$url2,$url3) = explode("/",$url);
    if($url3=="Administracion"){?>
        <script src="<?php echo base_url; ?>Assets/js/sistema/empresa.js"></script>
    <?php }else if($url3=="Constancias"){ ?>
        <script src="<?php echo base_url; ?>Assets/js/sistema/constancia.js"></script>
    <?php }else if($url3=="Emisiones"){ ?>
        <script src="<?php echo base_url; ?>Assets/js/sistema/emision.js"></script>
    <?php }else if($url3=="Documentos"){ ?>
        <script src="<?php echo base_url; ?>Assets/js/sistema/documento.js"></script>
    <?php }else if($url3=="Roles"){ ?>
        <script src="<?php echo base_url; ?>Assets/js/sistema/rol.js"></script>
    <?php }else if($url3=="Usuarios"){ ?>
        <script src="<?php echo base_url; ?>Assets/js/sistema/usuario.js"></script>
    <?php }else if($url3=="Excel"){ ?>
        <script src="<?php echo base_url; ?>Assets/js/sistema/excel.js"></script>    
    <?php }else if($url3=="Dashboard"){ ?>
        <!-- Page level plugins -->
        <script src="<?php echo base_url; ?>Assets/js/chart.min.js"></script>
        <script src="<?php echo base_url; ?>Assets/js/sistema/dashboard.js"></script>
    <?php }else{ ?>

    <?php } ?>     

</body>

</html>