<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin-top: 20px;
        }

        .container a{
            text-decoration: none;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top:20px;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .actions a {
            text-decoration: none;
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .actions a:hover {
            background-color: #0056b3;
        }

        .add-product-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 500px;
        }

        .add-product-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .add-product-form input[type="text"],
        .add-product-form input[type="number"],
        .add-product-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .add-product-form input[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 14px 20px;
            margin-top: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }

        .add-product-form input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="../src/app.php">Regresar a la pagina principal</a>
        <?php
        // Mostrar productos
        $conn = require("../conexion/conexion.php");
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>{$row['precio']}</td>
                        <td>{$row['cantidad']}</td>
                        <td class='actions'>
                            <a href='../src/ActualizaProd.php?id={$row['id']}'>Editar</a> | 
                            <a href='Eliminarproducto.php?id={$row['id']}' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este producto?\");'>Eliminar</a>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No se encontraron productos.</p>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>
