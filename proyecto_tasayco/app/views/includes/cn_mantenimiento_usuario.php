<?php        
    $result = mysqli_query($cn, "SELECT MAX(id_usuario) AS ultimo FROM usuario");
    $fila = mysqli_fetch_assoc($result);
    if ($fila['ultimo']) {
        $ultimo = $fila['ultimo']; // ej: U012
        $numero = (int)substr($ultimo, 1); 
        $nuevo_num = $numero + 1;
    } else {
        // Si no hay registros, empieza en 1
        echo "Error: " . mysqli_error($cn);
        $nuevo_num = 1;
    }

    $nuevo_id = "U" . str_pad($nuevo_num, 3, "0", STR_PAD_LEFT);

    $sql = "INSERT INTO usuario (id_usuario, nombre, apellido, username, password, email, dni, direccion) VALUES ('$nuevo_id', '$nombre', '$apellido', '$username', '$password', '$email', '$dni', '$direccion')";

    mysqli_query($cn, $sql);
?>