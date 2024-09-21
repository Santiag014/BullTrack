// Redireccion Informacion Usuario -Produccion
function RedirigirLogin() { window.location.href = '/'; }
function RedirigirHome() { window.location.href = '../../Comercial/DashboardComercial.php'; }
function ContactosCRM() { window.location.href = '../../Comercial/ContactosCRMComercial.php'; }
function RedirigirPropuestas() { window.location.href = '../../Comercial/PropuestasComercial.php'; }
function RedirigirAvancesOT() { window.location.href = '../../Comercial/AvancesOT.php'; }

// // Cambio de Clase Usuarios - Productores
// document.querySelectorAll('.productor-item').forEach(item => {
//     item.addEventListener('click', () => {
//         document.querySelectorAll('.productor-item').forEach(el => el.classList.remove('selected'));
//         item.classList.add('selected');
//     });
// });

// // Filtrado de los usuarios - Produccion
// const searchInputCrm = document.querySelector('.InputFiltrar input');
// const userItems = document.querySelectorAll('.productor-item'); // Cambié '.user-item' por '.productor-item'

// searchInputCrm.addEventListener('input', () => {
//     const searchTerm = searchInputCrm.value.toLowerCase();
    
//     userItems.forEach(item => {
//         const nombreContacto = item.querySelector('.NombreContacto').textContent.toLowerCase();
//         if (nombreContacto.includes(searchTerm)) {
//             item.style.display = '';
//         } else {
//             item.style.display = 'none';
//         }
//     });
// });

document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll('.Lista_produccion li');
    const resultadosDiv = document.querySelector('.ResultadosCentroCostos');

    function actualizarResultados(userId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../Produccion/DashboradPropduccion.php', false);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Respuesta del servidor:', xhr.responseText);
                resultadosDiv.innerHTML = xhr.responseText;
            }
        };
        xhr.send('userId=' + encodeURIComponent(userId));
    }

    items.forEach(item => {
        item.addEventListener('click', function() {
            items.forEach(el => el.classList.remove('seleccionado'));
            this.classList.add('seleccionado'); // Cambia el color del elemento clickeado

            const userId = this.getAttribute('data-id');
            console.log('userId:', userId);
            actualizarResultados(userId);
        });
    });

    if (items.length > 0) {
        const primerUsuario = items[0];
        primerUsuario.classList.add('seleccionado');
        const userId = primerUsuario.getAttribute('data-id');
        actualizarResultados(userId);
    }
});

