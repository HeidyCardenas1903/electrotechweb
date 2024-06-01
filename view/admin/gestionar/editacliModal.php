<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-5eF3AgoyLr3vT99Kz2Zq29bQPH89C67s5c0fvj8sDwAKMO4wNz8Cw4gFOq8uYRTpil5/3n5qySW8q2bBGUsfX8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="modal fade" id="editacliModal" tabindex="-1" aria-labelledby="editacliModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="editacliModalLabel"><i class="fa-solid fa-user-pen"></i> Modificar datos | Clientes</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actualizacli.php" method="POST">

                    <input type="hidden" id="id" name="id">

                    <div class="form-group">
                        <label for="nombres" class="label-color">Nombres:</label>
                        <input type="text" class="form-control form-input" id="nombres" name="nombres" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos" class="label-color">Apellidos:</label>
                        <input type="text" class="form-control form-input" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="form-group">
                        <label for="correo" class="label-color">Correo electrónico:</label>
                        <input type="email" class="form-control form-input" id="correo" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="label-color">Telefono:</label>
                        <input type="text" class="form-control form-input" id="telefono" name="telefono" required>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>