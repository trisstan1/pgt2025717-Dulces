<?php
session_start();
$conn = require("../conexion/conexion.php");

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "No hay productos en el carrito.";
    exit();
}

// Obtener productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[$row['id']] = $row;
}

// Generar recibo
$total = 0;
$detalle = '';

foreach ($_SESSION['carrito'] as $producto_id => $cantidad) {
    $producto = $productos[$producto_id];
    $subtotal = $producto['precio'] * $cantidad;
    $total += $subtotal;
    $detalle .= "<tr>
                    <td>{$producto['nombre']}</td>
                    <td>{$producto['precio']}</td>
                    <td>{$cantidad}</td>
                    <td>{$subtotal}</td>
                 </tr>";
}

// Limpiar carrito
unset($_SESSION['carrito']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

        .actions {
            margin-top: 20px;
            text-align: center;
        }

        .actions a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            margin: 5px;
        }

        .actions a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recibo de Compra</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $detalle; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total">Total</td>
                    <td class="total">$<?php echo number_format($total, 2); ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="actions">
            <a href="app.php">Volver al Inicio</a>
            <a href="javascript:window.print()">Imprimir Recibo</a>
        </div>
    </div>
</body>
</html>
