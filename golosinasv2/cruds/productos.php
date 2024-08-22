<?php
// Conectar a la base de datos
$conn = require("../php/conexion.php");

// Manejo de agregar un nuevo producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los campos están definidos en el array $_POST
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $precio = isset($_POST['precio']) ? $_POST['precio'] : '';
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';

    // Verificar si los campos no están vacíos
    if (!empty($nombre) && !empty($descripcion) && !empty($precio) && !empty($cantidad)) {
        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)";

        // Preparar la declaración
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $cantidad);

        if ($stmt->execute()) {
            echo "Producto agregado exitosamente";
        } else {
            echo "Error al agregar el producto: " . $conn->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Por favor, completa todos los campos.";
    }
}

// Mostrar productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

echo "<h1>Lista de Productos</h1>";

if ($result->num_rows > 0) {
    echo "<table border='1'>
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
                <td>
                    <a href='editarproducto.php?id={$row['id']}'>Editar</a> | 
                    <a href='eliminarproducto.php?id={$row['id']}' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este producto?\");'>Eliminar</a>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron productos.";
}

// Cerrar la conexión
$conn->close();
