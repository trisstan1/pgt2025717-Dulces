<?php
session_start();
$conn = require("../conexion/conexion.php");

// Manejo de agregar productos al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_product'])) {
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id] += $cantidad;
        } else {
            $_SESSION['carrito'][$producto_id] = $cantidad;
        }
    }

    if (isset($_POST['delete_product'])) {
        $producto_id = $_POST['producto_id'];
        unset($_SESSION['carrito'][$producto_id]);
    }

    if (isset($_POST['finalize'])) {
        // Aquí puedes manejar el proceso de creación del recibo
        header("Location: recibo.php");
        exit();
    }
}

// Obtener productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[$row['id']] = $row;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
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

        h2 {
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

        input[type="number"] {
            width: 80px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .actions {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Carrito de Compras</h2>
        
        <form method="post" action="">
            <h3>Agregar Producto</h3>
            <label for="producto_id">Producto:</label>
            <select id="producto_id" name="producto_id" required>
                <?php foreach ($productos as $id => $producto): ?>
                    <option value="<?php echo $id; ?>"><?php echo $producto['nombre']; ?> - $<?php echo $producto['precio']; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" min="1" required>
            <input type="submit" name="add_product" value="Agregar al Carrito">
        </form>

        <h3>Productos en el Carrito</h3>
        <?php if (!empty($_SESSION['carrito'])): ?>
            <form method="post" action="">
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['carrito'] as $producto_id => $cantidad):
                        $producto = $productos[$producto_id];
                        $subtotal = $producto['precio'] * $cantidad;
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td>$<?php echo $producto['precio']; ?></td>
                            <td><?php echo $cantidad; ?></td>
                            <td>$<?php echo number_format($subtotal, 2); ?></td>
                            <td>
                                <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
                                <input type="submit" name="delete_product" value="Eliminar">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>
                <div class="actions">
                    <input type="submit" name="finalize" value="Generar Recibo">
                </div>
            </form>
        <?php else: ?>
            <p>No hay productos en el carrito.</p>
        <?php endif; ?>
    </div>
</body>
</html>
