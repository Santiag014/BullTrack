// Redireccion Informacion Usuario
function RedirigirLogin() { window.location.href = '../../logout.php'; }
function RedirigirHome() { window.location.href = '../../Comercial/DashboardComercial.php'; }
function ContactosCRM() { window.location.href = '../../Comercial/ContactosCRMComercial.php'; }
function RedirigirPropuestas() { window.location.href = '../../Comercial/PropuestasComercial.php'; }
function RedirigirAvancesOT() { window.location.href = '../../Comercial/AvancesOT.php'; }
function RedirigirGerencia() { window.location.href = '../../Comercial/DashboardGerencia.php'; }


/*----------------FUncionalidad Contactos Comercial----------------*/

// Cambio de Clase Usuarios
document.querySelectorAll('.user-item').forEach(item => {
    item.addEventListener('click', () => {
        // Cambia la clase 'selected' a este elemento
        document.querySelectorAll('.user-item').forEach(el => el.classList.remove('selected'));
        item.classList.add('selected');

        // Obtener los datos del contacto
        const id = item.getAttribute('data-id');
        const nombre = item.getAttribute('data-nombre');
        const apellido = item.getAttribute('data-apellido');
        const cargo = item.getAttribute('data-cargo');
        const celular = item.getAttribute('data-celular');
        const correo = item.getAttribute('data-correo');
        const empresa = item.getAttribute('data-empresa');
        const ciudad = item.getAttribute('data-ciudad');
        const direccion = item.getAttribute('data-direccion');
        const web = item.getAttribute('data-web');
        const nit = item.getAttribute('data-nit');
        const razon_social = item.getAttribute('data-razon-social');

        // Llenar los campos con la información del contacto
        document.getElementById('id').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('apellido').value = apellido;
        document.getElementById('cargo').value = cargo;
        document.getElementById('celular').value = celular;
        document.getElementById('correo').value = correo;
        document.getElementById('empresa').value = empresa;
        document.getElementById('ciudad').value = ciudad;
        document.getElementById('direccion').value = direccion; // Asegúrate de que el ID del campo sea correcto
        document.getElementById('web').value = web; // Asegúrate de que el ID del campo sea correcto
        document.getElementById('NIT').value = nit; // Asegúrate de que el ID del campo sea correcto
        document.getElementById('razon_social').value = razon_social; // Asegúrate de que el ID del campo sea correcto

        console.log(id)
    });
});

// Filtrado de las clases de los Usuarios en CRM
const searchInputCrm = document.querySelector('.InputFiltrar input');
const userItems = document.querySelectorAll('.user-item');

searchInputCrm.addEventListener('input', () => {
    const searchTerm = searchInputCrm.value.toLowerCase();
    
    userItems.forEach(item => {
        const nombreContacto = item.querySelector('.NombreContacto').textContent.toLowerCase();
        const empresaContacto = item.querySelector('.EmpresaContacto').textContent.toLowerCase();

        // Verifica si el término de búsqueda está en el nombre o en la empresa
        if (nombreContacto.includes(searchTerm) || empresaContacto.includes(searchTerm)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});


//Parte Encargada de Actualizar un Usuario tanto en el CRM como en BllTrack
let enModoEdicion = false;

document.getElementById('editarContactoBtn').addEventListener('click', function() {
    const boton = this;
    const imagen = boton.querySelector('img');
    const texto = boton.querySelector('span');
    const inputs = document.querySelectorAll('.ParteFormulario input');
    
    console.log("Estado actual de enModoEdicion:", enModoEdicion);
    
    if (!enModoEdicion) {
        // Primer clic: Habilitar edición
        console.log("Entrando en modo edición...");
        enModoEdicion = true;
        inputs.forEach(input => {
            input.readOnly = false;
            console.log(`Habilitado: ${input.name} = ${input.value}`);
        });
        imagen.src = "../../../Media/Iconos/guardar.png";
        texto.textContent = "Actualizar...";
    } else {
        // Segundo clic: Actualizar datos
        console.log("Guardando cambios...");
        enModoEdicion = false;
        inputs.forEach(input => {
            input.readOnly = true;
            console.log(`Deshabilitado: ${input.name} = ${input.value}`);
        });
    
        // Recoger los datos del formulario
        const formData = new FormData();
        inputs.forEach(input => {
            formData.append(input.name, input.value);
            console.log(`Datos a enviar: ${input.name} = ${input.value}`);
        });
    
        // Mostrar un indicador de carga
        boton.disabled = true;
        texto.textContent = "Actualizando...";
    
        // Enviar los datos al servidor usando AJAX
        $.ajax({
            url: '../../../Comercial/Funcionalidad/Backend-Contactos/Actualizar.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json', // Especificar que esperamos JSON
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response.success) {
                    alert("Contacto actualizado con éxito");
                    location.reload(); // Esto recargará la página actual
                } else {
                    alert("Error al actualizar el contacto: " + (response.message || "Error desconocido"));
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                alert("Error al actualizar el contacto: " + error);
            },
            complete: function() {
                // Restaurar el botón a su estado original
                boton.disabled = false;
                imagen.src = "../../../Media/Iconos/editar.png";
                texto.textContent = "Editar";
            }
        });
    }
});

// Funcionalidad para agregar un nuevo contacto tanto en CRM como en BullTrack
document.getElementById('agregarContactoBtn').addEventListener('click', function() {
    // const inputs = document.querySelectorAll('.ParteFormulario input:not([name="NIT"]):not([name="razon_social"])');
    const inputs = document.querySelectorAll('.ParteFormulario input');

    const boton = this;
    const imagen = boton.querySelector('img');
    const texto = boton.querySelector('span');

    // Verificar el estado del botón
    if (texto.textContent === "Agregar") {
        console.log("Preparando para agregar un nuevo contacto...");

        // Limpiar y deshabilitar los campos del formulario
        inputs.forEach(input => {
            input.value = ''; // Limpia el valor de cada input
            input.readOnly = true; // Deshabilita los inputs
            console.log(`Campo limpio: ${input.name}`);
        });

        // Cambiar a estado de guardar
        imagen.src = "../../../Media/Iconos/guardar.png"; // Cambia la imagen a "guardar"
        texto.textContent = "Guardar..."; // Cambia el texto a "Guardando..."
        
        // Habilitar los inputs para el segundo clic
        inputs.forEach(input => {
            input.readOnly = false; // Vuelve a habilitar los inputs para el segundo clic
        });
    } else {
        console.log("Guardando nuevo contacto...");

        // Recoger los datos del formulario
        const formData = new FormData();
        inputs.forEach(input => {
            formData.append(input.name, input.value);
            console.log(`Datos a enviar: ${input.name} = ${input.value}`);
        });

        // Enviar los datos al servidor usando AJAX para agregar
        $.ajax({
            url: '../../../Comercial/Funcionalidad/Backend-Contactos/Agregar.php', // Cambia a la ruta correcta para agregar
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response.success) {
                    alert("Contacto agregado con éxito");
                    location.reload(); // Refresca la página
                } else {
                    alert("Error al agregar el contacto: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                alert("Error al agregar el contacto");
            },
            complete: function() {
                // Restaurar el botón a su estado original después de intentar guardar
                imagen.src = "../../../Media/Iconos/Agregar.png"; // Cambia la imagen de nuevo
                texto.textContent = "Agregar"; // Cambia el texto de nuevo
            }
        });
    }
});

//Parte de Encargada de eliminar los Usuarios tanto en el CRM como en BullTrack
document.getElementById('eliminarContactoBtn').addEventListener('click', function() {
    const id_contacto = document.querySelector('input[name="id"]').value; // Obtener el campo `id` del contacto seleccionado

    if (!id_contacto) {
        alert("No se ha seleccionado un contacto para eliminar.");
        return;
    }

    // Confirmar la eliminación antes de proceder
    if (confirm("¿Estás seguro de que deseas eliminar este contacto?")) {
        console.log("Eliminando contacto con id:", id_contacto);

        // Recoger los datos necesarios para eliminar (en este caso solo el id del contacto)
        const formData = new FormData();
        formData.append('id', id_contacto);

        // Enviar los datos al servidor usando AJAX para eliminar
        $.ajax({
            url: '../../../Comercial/Funcionalidad/Backend-Contactos/Eliminar.php', // Cambia a la ruta correcta para eliminar
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response.success) {
                    alert("Contacto eliminado con éxito");
                    location.reload(); // Refresca la página para reflejar los cambios
                } else {
                    alert("Error al eliminar el contacto: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", error);
                alert("Error al eliminar el contacto");
            }
        });
    } else {
        console.log("Eliminación cancelada por el usuario.");
    }
});
