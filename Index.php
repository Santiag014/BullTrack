<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BullTrack</title>
    <link rel="icon" href="./Media/Iconos/logo512.png" type="image/x-icon">
    <link rel="stylesheet" href="./EstilosFuncionalidad/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="background-section">
            <div class="logo-container">
                <img src="./Media/BullTrack.png" alt="BullMarketing Logo" class="logo">
            </div>
        </div>
        <div class="form-section">
            <form id="login-form">
                <h2 class="inicio-seccion">Inicia Sesión</h2>
                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" required>
                    <div id="email-error" class="error-message"></div>
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" required>
                    <div id="password-error" class="error-message"></div>
                </div>
                <div class="olvidar-contraseña">
                    <span id="forget-password" class="forget-contraseña">Olvidé Mi Contraseña</span>
                </div>
                <div class="button-group">
                    <button type="submit" class="signin-btn">Sign In</button>
                </div>
                <div id="reset-message" class="success-message"></div>
            </form>
        </div>
    </div>
    <script src="./EstilosFuncionalidad/scripts.js"></script>
</body>
</html>
