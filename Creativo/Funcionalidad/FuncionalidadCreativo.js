// Redireccion Informacion Usuario
function RedirigirLogin() {
    window.location.href = '/';
}

function ProyectosLideres() {
    window.location.href = '/Creativo/ProyectosLideres.html';
}

function ProyectosCreativos() {
    window.location.href = '/Creativo/ProyectosCreativos.html';
}

function ProyectosFinalizados() {
    window.location.href = '/Creativo/ProyectosFinalizados.html';
}

// Add event listeners to the buttons
document.addEventListener('DOMContentLoaded', () => {
    const botonSalir = document.querySelector('.BotonSalir');
    botonSalir.addEventListener('click', RedirigirLogin);

    const modulosDash = document.querySelectorAll('.ModulosDash');
    modulosDash.forEach((modulo) => {
        modulo.addEventListener('click', (e) => {
            switch (e.target.textContent) {
                case 'Proyectos Líderes':
                    ContactosCRM();
                    break;
                case 'Proyectos Creativos':
                    RedirigirPropuestas();
                    break;
                case 'Proyectos Finalizados':
                    RedirigirAvancesOT();
                    break;
                default:
                    console.log('Unknown module');
            }
        });
    });
});