const tipoEnvio = document.getElementById('tipo-envio');
const direccionEnvio = document.getElementById('direccion-envio');

// Oculta el campo de dirección al cargar la pági
tipoEnvio.addEventListener('change', () => {
    if (tipoEnvio.value === 'domicilio') {
        direccionEnvio.style.display = 'block';  // Muestra el campo de dirección
        direccionEnvio.value = "";               // Resetea el valor del campo
    } else {
        direccionEnvio.style.display = 'none';   // Oculta el campo de dirección
        direccionEnvio.querySelector('input').value = "";               // Limpia el valor del campo   
    }
});
