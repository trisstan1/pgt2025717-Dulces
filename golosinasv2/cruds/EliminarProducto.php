<?php
$conn = require("../conexion/conexion.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM productos WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Producto eliminado exitosamente";
        header("Location: eliminarproducto.php"); // Redirige después de eliminar
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
} else {
    echo "Eliminado exitosamente";
}

