document.addEventListener('DOMContentLoaded', function() {
    calcularTotales();
});

function calcularTotales() {
    const cantidad = document.getElementById('cantidad').value;
    const precioPorUnidad = 650; 
    const ivaPorcentaje = 0.21; 

    const subtotal = cantidad * precioPorUnidad;
    const iva = subtotal * ivaPorcentaje;
    const total = subtotal + iva;

    document.getElementById('subtotal').innerText = subtotal.toFixed(2);
    document.getElementById('iva').innerText = iva.toFixed(2);
    document.getElementById('total').innerText = total.toFixed(2);
}

