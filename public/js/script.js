
// Script para el hero en el boton leer mas

document.addEventListener("DOMContentLoaded", function () {
    var contInfo = document.querySelector(".cont-info");
    var parrafoOculto = document.getElementById("parrafoOculto");

    var leerMasBtn = document.createElement("button");
    leerMasBtn.textContent = "Leer más";
    leerMasBtn.className = "leer-mas";

    leerMasBtn.addEventListener("click", function (event) {
        event.preventDefault();
        if (parrafoOculto.style.display === "none") {
            parrafoOculto.style.display = "block";
            contInfo.appendChild(leerMasBtn);
            leerMasBtn.textContent = "Leer menos";
        } else {
            parrafoOculto.style.display = "none";
            contInfo.appendChild(leerMasBtn);
            leerMasBtn.textContent = "Leer más";
        }
    });

    contInfo.appendChild(leerMasBtn); 
});

// Ojo mostrar contraseña
var passwordInput = document.getElementById('password');
var togglePasswordButton = document.getElementById('togglePassword');
var eyeIcon = document.getElementById('eyeIcon');

togglePasswordButton.addEventListener('click', function () {
    var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Cambiar el ícono del ojo
    if (type === 'password') {
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    } else {
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    }
});
