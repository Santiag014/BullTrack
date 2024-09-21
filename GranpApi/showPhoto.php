<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foto de Perfil</title>
</head>
<body>
    <h1>Foto de Perfil del Usuario</h1>
    
    <!-- Mostrar la foto si existe en la sesión -->
    <?php if (isset($_SESSION['user_photo']) && $_SESSION['user_photo']): ?>
        <img src="data:image/jpeg;base64,<?= $_SESSION['user_photo'] ?>" alt="Foto de Perfil" />
    <?php else: ?>
        <p>No se pudo obtener la foto de perfil. Asegúrate de que el usuario tenga una foto configurada en su perfil.</p>
        <img src="default_avatar.jpg" alt="Foto de Perfil por Defecto" />
    <?php endif; ?>

</body>
</html>
