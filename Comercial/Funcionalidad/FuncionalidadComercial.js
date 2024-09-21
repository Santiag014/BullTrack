    // Redireccion Informacion Usuario
    function RedirigirLogin() { window.location.href = '/'; }
    function RedirigirHome() { window.location.href = '../../Comercial/DashboardComercial.php'; }
    function ContactosCRM() { window.location.href = '../../Comercial/ContactosCRMComercial.php'; }
    function RedirigirPropuestas() { window.location.href = '../../Comercial/PropuestasComercial.php'; }
    function RedirigirAvancesOT() { window.location.href = '../../Comercial/AvancesOT.php'; }

    // Cambio de Clase Usuarios
    document.querySelectorAll('.user-item').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.user-item').forEach(el => el.classList.remove('selected'));
            item.classList.add('selected');
        });
    });

    // Cambio de Clase Usuarios del Propuestas
    document.querySelectorAll('.propuesta-item').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.propuesta-item').forEach(el => el.classList.remove('selected'));
            item.classList.add('selected');
        });
    });

    // Filtrado de las clases de los Usuarios en CRM
    const searchInputCrm = document.querySelector('.InputFiltrar input');
    const userItems = document.querySelectorAll('.user-item');

    searchInputCrm.addEventListener('input', () => {
        const searchTerm = searchInputCrm.value.toLowerCase();
        
        userItems.forEach(item => {
            const nombreContacto = item.querySelector('.NombreContacto').textContent.toLowerCase();
            if (nombreContacto.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Filtrado de las clases de las Propuestas
    const searchInputPropuestas = document.querySelector('.InputFiltrar input');
    const propuestasItems = document.querySelectorAll('.propuesta-item');

    searchInputPropuestas.addEventListener('input', () => {
        const searchTerm = searchInputPropuestas.value.toLowerCase();
        
        propuestasItems.forEach(item => {
            const nombreContacto = item.querySelector('.NombreContacto').textContent.toLowerCase();
            if (nombreContacto.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    const estados = {
        editar: {
            iconoOriginal: '../Media/Iconos/editar.png',
            textoOriginal: 'Editar',
            iconoModificado: '../Media/Iconos/guardar.png', // Nuevo icono para guardar
            textoModificado: 'Guardar'
        },
        agregar: {
            iconoOriginal: '../Media/Iconos/Agregar.png',
            textoOriginal: 'Agregar',
            iconoModificado: '../Media/Iconos/guardar.png', // Nuevo icono para guardar
            textoModificado: 'Guardar'
        },
    };

    // Initialize the button states
    document.getElementById('editarBtn').dataset.estado = 'original';
    document.getElementById('agregarBtn').dataset.estado = 'original';
    document.getElementById('eliminarBtn').dataset.estado = 'original';

    // Función para alternar el estado del botón
    function alternarEstado(btnId) {
        const boton = document.getElementById(btnId);
        const img = boton.querySelector('img');
        const span = boton.querySelector('span');

        // Configurar el estado basado en el id del botón
        if (btnId === 'editarBtn' || btnId === 'agregarBtn') {
            const estadoActual = boton.dataset.estado;

            if (estadoActual === 'original') {
                // Cambiar a estado de guardar
                img.src = estados[btnId].iconoModificado;
                span.textContent = 'Guardar';
                boton.dataset.estado = 'guardar';
            } else {
                // Volver al estado original
                img.src = estados[btnId].iconoOriginal;
                span.textContent = estados[btnId].textoOriginal;
                boton.dataset.estado = 'original';
            }
        } else {
            // Manejar el botón eliminar
            const estadoActual = boton.dataset.estado;

            if (estadoActual === 'modificado') {
                // Restablecer al estado original
                img.src = estados[btnId].iconoOriginal;
                span.textContent = estados[btnId].textoOriginal;
                boton.dataset.estado = 'original';
            } else {
                // Cambiar al estado modificado
                img.src = estados[btnId].iconoModificado;
                span.textContent = estados[btnId].textoModificado;
                boton.dataset.estado = 'modificado';
            }
        }
    }

    // Asignar Si Necesita OT
    document.getElementById('editarBtn').addEventListener('click', () => alternarEstado('editarBtn'));
    document.getElementById('agregarBtn').addEventListener('click', () => alternarEstado('agregar'));
    document.getElementById('eliminarBtn').addEventListener('click', () => alternarEstado('eliminar'));

    const editarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(1)');
    const agregarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(2)');
    const eliminarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(3)');

    const formPropuestas = document.querySelectorAll('.ParteFormulario input, .ParteFormulario select');
    const formOT = document.querySelectorAll('.ParteFormularioOT-Agregar input, .ParteFormularioOT-Agregar select');

    // Variable para rastrear el estado de los campos
    let fieldsEnabled = false;

    function toggleAddMode() {
        isAddMode = !isAddMode;
        if (isAddMode) {
            parteFormulario.style.display = 'none';
            selectUserPropuestas.style.display = 'block';
        } else {
            parteFormulario.style.display = 'block';
            selectUserPropuestas.style.display = 'none';
        }
    }

    function toggleFormFields() {
        fieldsEnabled = !fieldsEnabled; // Alternar el estado
        
        if (fieldsEnabled) {
            formPropuestas.forEach(field => {
                field.removeAttribute('readonly');
                field.removeAttribute('disabled');
            });
            formOT.forEach(field => {
                field.removeAttribute('readonly');
                field.removeAttribute('disabled');
            });
        } else {
            formPropuestas.forEach(field => {
                field.setAttribute('readonly', 'readonly');
                field.setAttribute('disabled', 'disabled');
            });
            formOT.forEach(field => {
                field.setAttribute('readonly', 'readonly');
                field.setAttribute('disabled', 'disabled');
            });
        }
    }

    editarButton.addEventListener('click', () => {
        toggleFormFields();
        // Optional: Add additional logic if needed when clicking "Edit"
    });

    agregarButton.addEventListener('click', () => {
        toggleFormFields();
        toggleAddMode();
        // Optional: Add additional logic if needed when clicking "Add"
    });

    eliminarButton.addEventListener('click', () => {
        // Add logic for the "Delete" button if needed
    });

    // Initial setup: disable fields on page load
    disableFormFields();