<?php
    $carpeta = "../../../../img_productos/";

    $nombreArchivo = $_FILES['imagen']['name'] ?? '';

    $rutaDestino = $carpeta . basename($nombreArchivo);

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        echo "✅ Imagen subida con éxito.<br>";
        /*echo "📂 Nombre del archivo: " . $nombreArchivo . "<br>";
        echo "🖼️ Vista de la imagen subida:<br> <img src='$rutaDestino' width='200'>";*/
    } else {
        echo "❌ Error al subir la imagen.";
    }
?>