<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-5eF3AgoyLr3vT99Kz2Zq29bQPH89C67s5c0fvj8sDwAKMO4wNz8Cw4gFOq8uYRTpil5/3n5qySW8q2bBGUsfX8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="modal fade" id="editaprovModal" tabindex="-1" aria-labelledby="editaprovModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="editaprovModalLabel"><i class="fa-solid fa-building-pen"></i> Modificar datos | Proveedores</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actualizaprov.php" method="POST">

                    <input type="hidden" id="nit" name="nit">

                    <div class="mb-3">
                        <label for="razonsocial" class="form-label">Razón Social: </label>
                        <input type="text" name="razonsocial" id="razonsocial" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="encargado" class="form-label">Encargado: </label>
                        <input type="text" name="encargado" id="encargado" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="celular" class="form-label">Celular: </label>
                        <input type="text" name="celular" id="celular" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico: </label>
                        <input type="email" name="correo" id="correo" class="form-control" required>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
