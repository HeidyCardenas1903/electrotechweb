<div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-user-pen"></i> Editar perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../../controller/actualizarperfil.php" method="POST" id="formularioEditarPerfil">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuarioData['nombre']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $usuarioData['username']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuarioData['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nueva contraseña">
                    </div>
                    <button type="submit" style="background: #0271b7;padding: 5px 10px;border-radius: 5px;color: #fafafa;font-weight: 500;border: none;" class="save"><i class="fa-solid fa-floppy-disk"></i> Guardar cambios</button>
                    <button type="button" style="background: #c3c3c3;padding: 5px 10px;border-radius: 5px;color: #fafafa;font-weight: 500;border: none;"  class="quit" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>