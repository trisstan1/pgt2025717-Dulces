<?php
// Iniciar la sesión
session_start();

// Destruir todas las variables de sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
header("Location: login.php");
exit(); // Asegura que el script se detenga después de la redirección