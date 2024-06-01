<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-5eF3AgoyLr3vT99Kz2Zq29bQPH89C67s5c0fvj8sDwAKMO4wNz8Cw4gFOq8uYRTpil5/3n5qySW8q2bBGUsfX8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="modal fade" id="editausuModal" tabindex="-1" aria-labelledby="editausuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="editausuModalLabel"><i class="fa-solid fa-user-pen"></i> Modificar datos | Usuarios</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actualizausu.php" method="POST">

                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo: </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username: </label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña: </label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" required>
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="showPasswordIcon" onclick="showHidePassword()"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electronico: </label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Rol del usuario: </label>
                        <select name="rol" id="rol" class="form-select" required>
                            <option value="">--Selecciona un rol--</option>
                            <?php while ($row_rol = $roles->fetch_assoc()) { ?>
                                <option value="<?php echo $row_rol["id"]; ?>"><?= $row_rol["nombre"] ?></option>
                            <?php } ?>
                        </select>
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

<script>
    function showHidePassword() {
        var passwordInput = document.getElementById("password");
        var showPasswordIcon = document.getElementById("showPasswordIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordIcon.classList.remove("fa-eye");
            showPasswordIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            showPasswordIcon.classList.remove("fa-eye-slash");
            showPasswordIcon.classList.add("fa-eye");
        }
    }
</script>