<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido a la Tienda</h1>
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <p>Hola,<?php echo $_SESSION['tipo_usuario'] == 'admin' ? 'Admin' : 'Cliente'; ?>!</p>
            <a href="./Session/logout.php">Cerrar Sesión</a>
            <?php if ($_SESSION['tipo_usuario'] == 'admin'): ?>
                <a href="../cruds/CrearProductos.php">Administrar Productos</a>
            <?php else: ?>
            <a href="./Carrito.php">Agregar Productos al Carrito</a>
            <?php endif; ?>
            <a href="./crud/recibo.php">Ver Recibos</a>
        <?php else: ?>
            <a href="./Session/login.php">Iniciar Sesión</a>
            <a href="./Session/register.php">Registrarse</a>
        <?php endif; ?>
    </div>
</body>
</html>
