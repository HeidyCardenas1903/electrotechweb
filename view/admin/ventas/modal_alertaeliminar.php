<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-5eF3AgoyLr3vT99Kz2Zq29bQPH89C67s5c0fvj8sDwAKMO4wNz8Cw4gFOq8uYRTpil5/3n5qySW8q2bBGUsfX8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Modal -->
<div class="modal fade" id="alertaModal" tabindex="-1" aria-labelledby="alertaModalLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
      
        <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="eliminaprovModalLabel"><i class="fa-solid fa-circle-exclamation"></i> Advertencia de eliminación </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                    <strong>⚠ A D V E R T E N C I A ⚠</strong>
                    <br>¿Esta usted seguro de anular esta factura?
                    <br>
                    Al ejecutar esta acción se reestablecerán los productos al stock</center>
                </div>
        <div class="modal-footer">
            <form action="anularventa.php" method="post">
                <input type="hidden" name="nit" id="nit">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger">Anular</button>
            </form>
        </div>
    </div>
  </div>
</div>