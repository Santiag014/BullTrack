<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="./Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="./EstilosFuncionalidad/styles.css">
    <style>
        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
            border-radius: 4px;
            display: none;
            font-weight: 200;
            font-size: 13px;
        }
        .custom-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            z-index: 1000;
            display: none;
        }
        .custom-alert h3 {
            margin-top: 0;
            color: #333;
            margin-bottom: 5px;
        }
        .custom-alert p {
            color: #666;
        }
        .custom-alert button {
                width: 25%;
                height: 35px;
                background-color: #ff7a22;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
                float: right;
                margin-top: 5px;
        }
        .custom-alert button:hover{
            background-color: #e86a12;
            box-shadow: 0 0 15px #bb672b;
        }
        .blur-background {
            filter: blur(5px);
            transition: filter 0.3s ease;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }
    </style>
</head>
<body>
    <div class="login-container" id="mainContent">
        <div class="background-section">
            <div class="logo-container">
                <img src="./Media/BullTrack.png" alt="BullMarketing Logo" class="logo">
            </div>
        </div>
        <div class="form-section">
            <div id="error-alert" class="alert"></div>
            <form id="login-form" method="post">
                <h2 class="inicio-seccion">Inicia Sesión</h2>
                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="emailUser" required>
                    <div id="email-error" class="error-message"></div>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="ContraseñaUser" required>
                    <div id="password-error" class="error-message"></div>
                </div>
                <div class="olvidar-contraseña">
                    <span id="forget-password" class="forget-contraseña" onclick="mostrarAlerta()">Olvidé Mi Contraseña</span>
                </div>
                <div class="button-group">
                    <button type="submit" class="signin-btn">Sign In</button>
                </div>
                <div id="reset-message" class="success-message"></div>
            </form>
        </div>
    </div>

    <div id="overlay" class="overlay"></div>

    <div id="customAlert" class="custom-alert">
        <h3>¿Olvidaste tu contraseña?</h3>
        <p>Por favor, Contactate con Data para Restablecer tu contraseña.</p>
        <button onclick="cerrarAlerta()">Cerrar</button>
    </div>

    <script>
    function mostrarAlerta() {
        document.getElementById('customAlert').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('mainContent').classList.add('blur-background');
    }

    function cerrarAlerta() {
        document.getElementById('customAlert').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('mainContent').classList.remove('blur-background');
    }

    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('login-form');
        var alertDiv = document.getElementById('error-alert');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(form);

            fetch('Login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alertDiv.style.display = 'block';
                    alertDiv.textContent = data.error;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alertDiv.style.display = 'block';
                alertDiv.textContent = 'Ocurrió un error. Por favor, intenta de nuevo.';
            });
        });
    });
    </script>
</body>
</html>