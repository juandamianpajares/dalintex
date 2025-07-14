// Implementación básica de escaneo QR
document.getElementById('btn-start-scan').addEventListener('click', function() {
    const video = document.getElementById('qr-video');
    const resultDiv = document.getElementById('qr-result');
    
    video.classList.remove('d-none');
    resultDiv.classList.add('d-none');
    
    // Simulación de escaneo (en producción usar librería como Instascan)
    setTimeout(() => {
        video.classList.add('d-none');
        resultDiv.classList.remove('d-none');
        resultDiv.textContent = "Código escaneado: FRASCO-260ML-MAD001";
        
        // Autocompletar formulario
        document.getElementById('codigo').value = "MAD001";
        document.getElementById('tipo').value = "frasco";
        document.getElementById('cantidad').focus();
    }, 2000);
});