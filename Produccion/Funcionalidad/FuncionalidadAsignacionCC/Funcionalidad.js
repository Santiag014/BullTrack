// Redireccion Informacion Usuario -Produccion
function RedirigirLogin() { window.location.href = '/'; }
function DashboardGerencial() { window.location.href = '../../../Produccion/DashboardGerencia.php'; }
function DashboardProduccion() { window.location.href = '../../../Produccion/DashboardProduccion.php'; }
function AsignaccionCC() { window.location.href = '../../../Produccion/AsignacionCC.php'; }


// Declara userId como variable global
let userId; 

document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll('.Lista li');
    const resultadosDiv = document.querySelector('.ResultadosCentroCostos_1');

    function actualizarResultados(userId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../Produccion/AsignacionCC.php', false);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                //console.log('Respuesta del servidor:', xhr.responseText);
                resultadosDiv.innerHTML = xhr.responseText;
            }
        };
        xhr.send('userId=' + encodeURIComponent(userId));
    }

    items.forEach(item => {
        item.addEventListener('click', function() {
            // Resetea el color de fondo de todos los elementos NombreContacto
            items.forEach(el => {
                const nombreContacto = el.querySelector('.productor-item');
                if (nombreContacto) {
                    nombreContacto.style.backgroundColor = ''; // Resetea el color de fondo
                }
            });

            // Cambia el color de fondo del NombreContacto del elemento clickeado
            const nombreContacto = this.querySelector('.productor-item');
            if (nombreContacto) {
                nombreContacto.style.backgroundColor = 'rgba(51, 51, 51, 0.2)'; // Color de fondo al seleccionar
            }

            // Asigna el valor de userId globalmente
            userId = this.getAttribute('data-id'); 
            console.log('userId:', userId);
            actualizarResultados(userId);
        });
    });

    // Selecciona el primer usuario y cambia el color
    if (items.length > 0) {
        const primerUsuario = items[0];
        const nombreContacto = primerUsuario.querySelector('.productor-item');
        if (nombreContacto) {
            nombreContacto.style.backgroundColor = 'rgba(51, 51, 51, 0.2)'; // Color de fondo al seleccionar
        }
        userId = primerUsuario.getAttribute('data-id'); // Asigna el userId globalmente
        actualizarResultados(userId);
    }
});

console.log("Numeor de Id de Usuario: " + userId)

//Logica Encaraga de Seleccionar los registros de los Divs
document.addEventListener('click', function(event) {
    // Verifica si el elemento clicado tiene la clase 'registroCC_2' o 'registroCC'
    if (event.target.classList.contains('registroCC_2') || event.target.classList.contains('registroCC_1')) {
        // Selecciona todos los elementos que tienen la clase 'registroCC_2' o 'registroCC'
        const elementos = document.querySelectorAll('.registroCC_2, .registroCC_1');
        
        // Resetea el color de fondo de todos los elementos
        elementos.forEach(function(elemento) {
            elemento.style.backgroundColor = ''; // Resetea el color de fondo
        });

        // Cambia el color de fondo del elemento clicado
        event.target.style.backgroundColor = 'rgba(51, 51, 51, 0.7)'; // Color de fondo al seleccionar

        // Obtiene el valor del atributo 'data-user-id'
        var userId = event.target.getAttribute('data-registro-id');
        // Muestra una alerta con el ID del usuario
        //alert("User ID: " + userId);
    }
});

function AsignarCC() {
    const CCConproductor = document.querySelectorAll('.registroCC_2');
    const CCSinproductor = document.querySelectorAll('.registroCC_1');
    let seleccionadoValido = false;
    let userIdSeleccionado = userId; // Variable global para almacenar el userId
    let registroIdSeleccionado = null; // Variable para almacenar el ID del registro

    // Verifica si alguno de los elementos registroCC_2 está seleccionado
    CCConproductor.forEach(elemento => {
        if (elemento.style.backgroundColor === 'rgba(51, 51, 51, 0.7)') {
            seleccionadoValido = true;
            registroIdSeleccionado = elemento.getAttribute('data-registro-id');
        }
    });

    // Si no hay nada seleccionado, muestra un mensaje de error
    if (!seleccionadoValido) {
        alert("Por Favor, Seleccione un registro para asignar.");
    } else {
        // Crea un nuevo objeto XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../Produccion/Funcionalidad/ActualizarCC.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Cuando la solicitud esté completa y la respuesta lista
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log('Respuesta del servidor: ', xhr.responseText);
                    alert('Asignación realizada correctamente.');
                    location.reload(); // Recarga la página actual
                } else {
                    console.error('Error en la solicitud: ', xhr.status, xhr.statusText);
                    alert('Error en la asignación.');
                }
            }
        };

        // Envía los datos al servidor
        const params = `userId=${encodeURIComponent(userIdSeleccionado)}&registroId=${encodeURIComponent(registroIdSeleccionado)}`;
        xhr.send(params);
    }
}

function LiberarCC() {
    const CCConproductor = document.querySelectorAll('.registroCC_2');
    const CCSinproductor = document.querySelectorAll('.registroCC_1');
    let seleccionadoValido = false;
    let registroIdSeleccionado = null;
    let userIdSeleccionado = null; // Inicialmente lo establecemos como null

    // Verifica si alguno de los elementos de registroCC (sin productor) está seleccionado
    CCSinproductor.forEach(elemento => {
        if (elemento.style.backgroundColor === 'rgba(51, 51, 51, 0.7)') {
            seleccionadoValido = true;
            registroIdSeleccionado = elemento.getAttribute('data-registro-id'); // Obtiene el ID del registro
        }
    });

    // Si hay un registro seleccionado para liberar (sin productor)
    if (seleccionadoValido) {
        //alert(`Has seleccionado correctamente un registro para liberar. ID del registro: ${registroIdSeleccionado}`);

        // Enviar los datos al archivo PHP para actualizar
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../Produccion/Funcionalidad/Actualizar_Liberar_CC.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Registro actualizado correctamente.');
                console.log(xhr.responseText);
                location.reload(); // Recarga la página actual
            }
        };

        // Enviar userId como NULL y el ID del registro seleccionado
        const params = `userId=${encodeURIComponent(userIdSeleccionado)}&registroId=${encodeURIComponent(registroIdSeleccionado)}`;
        xhr.send(params);

    } else {
        // Verifica si hay un registro de registroCC_2 (con productor) seleccionado
        let seleccionadoConProductor = false;
        CCConproductor.forEach(elemento => {
            if (elemento.style.backgroundColor === 'rgba(51, 51, 51, 0.7)') {
                seleccionadoConProductor = true;
                registroIdSeleccionado = elemento.getAttribute('data-registro-id'); // Obtiene el ID del registro
            }
        });

        if (seleccionadoConProductor) {
            // Si se seleccionó un registro de registroCC_2 (con productor), mostrar mensaje
            alert("Solo puedes liberar registros con productor asignado.");
        } else {
            // Si no se seleccionó nada, mostrar mensaje de error
            alert("Por favor, seleccione un registro para liberar.");
        }
    }
}

// Logica encarga de FIltrar por Nombre de Prodcutor
document.addEventListener('DOMContentLoaded', () => {
    const searchInputCrm = document.querySelector('.InputFiltrar input');
    const userItems = document.querySelectorAll('.productor-item');

    searchInputCrm.addEventListener('input', () => {
        const searchTerm = searchInputCrm.value.toLowerCase();

        userItems.forEach(item => {
            const nombreContacto = item.querySelector('.NombreContacto').textContent.toLowerCase();

            if (nombreContacto.includes(searchTerm)) {
                item.style.display = 'block'; // Mostrar elemento
            } else {
                item.style.display = 'none'; // Ocultar elemento
            }
        });
    });
});

//Lógica Encargada de Filtrar Los CC sin producctor
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.divCentroCostos2 input');
    const resultadosDiv = document.querySelector('.ResultadosCentroCostos_2');

    // Asegúrate de que los elementos existan
    if (!searchInput || !resultadosDiv) {
        console.error('No se encontraron los elementos necesarios');
        return;
    }

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const registros = resultadosDiv.querySelectorAll('.registroCC_2');

        registros.forEach(registro => {
            const codCCElement = registro.querySelector('.codigoCC_2');
            
            // Verifica si el elemento .codigoCC existe
            if (codCCElement) {
                const codCC = codCCElement.textContent.toLowerCase().trim();
                
                // Usa una comparación más flexible
                if (codCC.indexOf(searchTerm) !== -1) {
                    registro.style.display = '';
                } else {
                    registro.style.display = 'none';
                }
            }
        });

        // Agrega un log para depuración
        console.log(`Buscando: "${searchTerm}", Registros encontrados: ${Array.from(registros).filter(r => r.style.display !== 'none').length}`);
    });
});

//Lógica Encargada de Filtrar Los CC copn producctor
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.divCentroCostos1 input');
    const resultadosDiv = document.querySelector('.ResultadosCentroCostos_1');

    // Asegúrate de que los elementos existan
    if (!searchInput || !resultadosDiv) {
        console.error('No se encontraron los elementos necesarios');
        return;
    }

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const registros = resultadosDiv.querySelectorAll('.registroCC_1');

        registros.forEach(registro => {
            const codCCElement = registro.querySelector('.codigoCC_1');
            
            // Verifica si el elemento .codigoCC existe
            if (codCCElement) {
                const codCC = codCCElement.textContent.toLowerCase().trim();
                
                // Usa una comparación más flexible
                if (codCC.indexOf(searchTerm) !== -1) {
                    registro.style.display = '';
                } else {
                    registro.style.display = 'none';
                }
            }
        });

        // Agrega un log para depuración
        console.log(`Buscando: "${searchTerm}", Registros encontrados: ${Array.from(registros).filter(r => r.style.display !== 'none').length}`);
    });
});









