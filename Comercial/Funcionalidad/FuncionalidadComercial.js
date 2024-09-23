    // Redireccion Informacion Usuario
    function RedirigirLogin() { window.location.href = '../../logout.php'; }
    function RedirigirHome() { window.location.href = '../../Comercial/DashboardComercial.php'; }
    function ContactosCRM() { window.location.href = '../../Comercial/ContactosCRMComercial.php'; }
    function RedirigirPropuestas() { window.location.href = '../../Comercial/PropuestasComercial.php'; }
    function RedirigirAvancesOT() { window.location.href = '../../Comercial/AvancesOT.php'; }


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
            imagen.src = "../Media/Iconos/guardar.png";
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
                url: '../../Comercial/Funcionalidad/Actualizar.php',
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
                    imagen.src = "../Media/Iconos/editar.png";
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
            imagen.src = "../Media/Iconos/guardar.png"; // Cambia la imagen a "guardar"
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
                url: '../../Comercial/Funcionalidad/Agregar.php', // Cambia a la ruta correcta para agregar
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
                    imagen.src = "../Media/Iconos/Agregar.png"; // Cambia la imagen de nuevo
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
                url: '../../Comercial/Funcionalidad/Eliminar.php', // Cambia a la ruta correcta para eliminar
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
    
/*----------------FUncionalidad Propuestas Comercial----------------*/

    // Cambio de Clase Usuarios del Propuestas
    document.querySelectorAll('.propuesta-item').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.propuesta-item').forEach(el => el.classList.remove('selected'));
            item.classList.add('selected');
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

    // Asignar Si Necesita OT
    document.getElementById('editarBtn').addEventListener('click', () => alternarEstado('editarBtn'));
    document.getElementById('agregarBtn').addEventListener('click', () => alternarEstado('agregar'));
    document.getElementById('eliminarBtn').addEventListener('click', () => alternarEstado('eliminar'));
    document.getElementById('SelectUser').addEventListener('click', () => selectUser());

    const editarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(1)');
    const agregarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(2)');
    const eliminarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(3)');

    const formPropuestas = document.querySelectorAll('.ParteFormulario input, .ParteFormulario select');
    const formInicial = document.getElementsByClassName('ParteFormulario')[0]; 
    const formSelectUsers = document.getElementsByClassName('SelectUserPropuesta')[0]; 
    const formOT = document.querySelectorAll('.ParteFormularioOT-Agregar input, .ParteFormularioOT-Agregar select');

    const necesidadOTSelect = document.getElementById('NecesidadOT');
    const parteFormularioOT = document.querySelector('.ParteFormularioOT-Agregar');
    const parteFormularioOTFields = parteFormularioOT.querySelectorAll('input, select, textarea');

    // Variable para rastrear el estado de los campos
    let fieldsEnabled = false;
    let isAddMode = false;
    let SelectUser = true;

    function toggleAddMode() {
        isAddMode = !isAddMode;
        formInicial.style.display = isAddMode ? 'none' : 'block';
        formSelectUsers.style.display = isAddMode ? 'block' : 'none';
    }

    function selectUser() {
        SelectUser = !SelectUser;
        formInicial.style.display = SelectUser ? 'block' : 'none';
        formSelectUsers.style.display = SelectUser ? 'none' : 'block';
    }

    function toggleFormFields() {
        fieldsEnabled = !fieldsEnabled;

        formPropuestas.forEach(field => {
            field[fieldsEnabled ? 'removeAttribute' : 'setAttribute']('readonly', 'readonly');
            field[fieldsEnabled ? 'removeAttribute' : 'setAttribute']('disabled', 'disabled');
        });

        formOT.forEach(field => {
            field[fieldsEnabled ? 'removeAttribute' : 'setAttribute']('readonly', 'readonly');
            field[fieldsEnabled ? 'removeAttribute' : 'setAttribute']('disabled', 'disabled');
        });

        toggleParteFormularioOT(); // Llamar a la función para actualizar el estado de OT
    }

    function toggleParteFormularioOT() {
        if (necesidadOTSelect && parteFormularioOT) {
            const value = necesidadOTSelect.value.toLowerCase();

            if (value === 'si') {
                parteFormularioOT.style.display = 'block';
                parteFormularioOTFields.forEach(field => {
                    field.removeAttribute('readonly');
                    field.removeAttribute('disabled');
                });
            } else {
                parteFormularioOT.style.display = 'none';
                parteFormularioOTFields.forEach(field => {
                    field.setAttribute('readonly', 'readonly');
                    field.setAttribute('disabled', 'disabled');
                });
            }
        }
    }

    // Llamar a la función cuando cambie el valor del select
    necesidadOTSelect.addEventListener('change', toggleParteFormularioOT);

    editarButton.addEventListener('click', toggleFormFields);
    
    const selectUserButton = document.getElementById('SelectUser'); // Asegúrate de que este ID exista en el HTML
    selectUserButton.addEventListener('click', selectUser);

    agregarButton.addEventListener('click', () => {
        // toggleFormFields();
        toggleAddMode();
    });

    eliminarButton.addEventListener('click', () => {
        // Add logic for the "Delete" button if needed
    });

    // Initial setup: disable fields on page load
    disableFormFields();














    // const estados = {
    //     editar: {
    //         iconoOriginal: '../Media/Iconos/editar.png',
    //         textoOriginal: 'Editar',
    //         iconoModificado: '../Media/Iconos/guardar.png', // Nuevo icono para guardar
    //         textoModificado: 'Guardar'
    //     },
    //     agregar: {
    //         iconoOriginal: '../Media/Iconos/Agregar.png',
    //         textoOriginal: 'Agregar',
    //         iconoModificado: '../Media/Iconos/guardar.png', // Nuevo icono para guardar
    //         textoModificado: 'Guardar'
    //     },
    // };

    // // Initialize the button states
    // document.getElementById('editarBtn').dataset.estado = 'original';
    // document.getElementById('agregarBtn').dataset.estado = 'original';
    // document.getElementById('eliminarBtn').dataset.estado = 'original';

    // // Función para alternar el estado del botón
    // function alternarEstado(btnId) {
    //     const boton = document.getElementById(btnId);
    //     const img = boton.querySelector('img');
    //     const span = boton.querySelector('span');

    //     // Configurar el estado basado en el id del botón
    //     if (btnId === 'editarBtn' || btnId === 'agregarBtn') {
    //         const estadoActual = boton.dataset.estado;

    //         if (estadoActual === 'original') {
    //             // Cambiar a estado de guardar
    //             img.src = estados[btnId].iconoModificado;
    //             span.textContent = 'Guardar';
    //             boton.dataset.estado = 'guardar';
    //         } else {
    //             // Volver al estado original
    //             img.src = estados[btnId].iconoOriginal;
    //             span.textContent = estados[btnId].textoOriginal;
    //             boton.dataset.estado = 'original';
    //         }
    //     } else {
    //         // Manejar el botón eliminar
    //         const estadoActual = boton.dataset.estado;

    //         if (estadoActual === 'modificado') {
    //             // Restablecer al estado original
    //             img.src = estados[btnId].iconoOriginal;
    //             span.textContent = estados[btnId].textoOriginal;
    //             boton.dataset.estado = 'original';
    //         } else {
    //             // Cambiar al estado modificado
    //             img.src = estados[btnId].iconoModificado;
    //             span.textContent = estados[btnId].textoModificado;
    //             boton.dataset.estado = 'modificado';
    //         }
    //     }
    // }

    // // Asignar Si Necesita OT
    // document.getElementById('editarBtn').addEventListener('click', () => alternarEstado('editarBtn'));
    // document.getElementById('agregarBtn').addEventListener('click', () => alternarEstado('agregar'));
    // document.getElementById('eliminarBtn').addEventListener('click', () => alternarEstado('eliminar'));

    // const editarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(1)');
    // const agregarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(2)');
    // const eliminarButton = document.querySelector('.BotonesInteraccion .BotonesFormulario:nth-child(3)');

    // const formPropuestas = document.querySelectorAll('.ParteFormulario input, .ParteFormulario select');
    // const formOT = document.querySelectorAll('.ParteFormularioOT-Agregar input, .ParteFormularioOT-Agregar select');

    // // Variable para rastrear el estado de los campos
    // let fieldsEnabled = false;

    // function toggleAddMode() {
    //     isAddMode = !isAddMode;
    //     if (isAddMode) {
    //         parteFormulario.style.display = 'none';
    //         selectUserPropuestas.style.display = 'block';
    //     } else {
    //         parteFormulario.style.display = 'block';
    //         selectUserPropuestas.style.display = 'none';
    //     }
    // }

    // function toggleFormFields() {
    //     fieldsEnabled = !fieldsEnabled; // Alternar el estado
        
    //     if (fieldsEnabled) {
    //         formPropuestas.forEach(field => {
    //             field.removeAttribute('readonly');
    //             field.removeAttribute('disabled');
    //         });
    //         formOT.forEach(field => {
    //             field.removeAttribute('readonly');
    //             field.removeAttribute('disabled');
    //         });
    //     } else {
    //         formPropuestas.forEach(field => {
    //             field.setAttribute('readonly', 'readonly');
    //             field.setAttribute('disabled', 'disabled');
    //         });
    //         formOT.forEach(field => {
    //             field.setAttribute('readonly', 'readonly');
    //             field.setAttribute('disabled', 'disabled');
    //         });
    //     }
    // }

    // editarButton.addEventListener('click', () => {
    //     toggleFormFields();
    //     // Optional: Add additional logic if needed when clicking "Edit"
    // });

    // agregarButton.addEventListener('click', () => {
    //     toggleFormFields();
    //     toggleAddMode();
    //     // Optional: Add additional logic if needed when clicking "Add"
    // });

    // eliminarButton.addEventListener('click', () => {
    //     // Add logic for the "Delete" button if needed
    // });

    // // Initial setup: disable fields on page load
    // disableFormFields();