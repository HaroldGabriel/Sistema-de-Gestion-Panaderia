<?php
    require_once '../../models/rutas.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];

            // Preparar la consulta segura (previene inyección SQL)
            $sql = "DELETE FROM producto WHERE id_producto = '$id'";
            $result = mysqli_query($cn, $sql);

            if ($result) {
                if (mysqli_affected_rows($cn) > 0) {
                    // ✅ Eliminado correctamente
                    header("Location: " . $ruta_proyecto_tasayco . "/app/views/pages/principal.php?action=productos");
                    exit;
                } else {
                    echo "⚠️ No se encontró el producto con id $id.";
                }
            }
        }
    }
?>