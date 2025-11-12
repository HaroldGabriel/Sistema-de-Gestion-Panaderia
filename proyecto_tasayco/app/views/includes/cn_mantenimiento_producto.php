<?php        
    $result = mysqli_query($cn, "SELECT MAX(id_producto) AS ultimo FROM producto");
    $fila = mysqli_fetch_assoc($result);
    $ultimo = $fila['ultimo'];

    // Paso 2: Generar nuevo ID
    $numero = (int)substr($ultimo, 1); // extrae "012" => 12
    $nuevo_num = $numero + 1;
    $nuevo_id = "P" . str_pad($nuevo_num, 3, "0", STR_PAD_LEFT);

    $sql = "INSERT INTO producto (id_producto, nomb_producto,descripcion_producto,stock,stock_inicial,precio_unitario,img_route) VALUES ('$nuevo_id', '$nombre', '$descripcion', $stock, $stock, '$precio','$nombreArchivo')";

    mysqli_query($cn, $sql);
?>