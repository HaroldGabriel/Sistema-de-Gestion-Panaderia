<?php
    require_once '../../models/conexion.php';
    $result = mysqli_query($cn, "SELECT MAX(id_cliente) AS ultimo FROM cliente");
    $fila = mysqli_fetch_assoc($result);
    $ultimo = $fila['ultimo'];
    // Verifica si todos los datos llegaron del formulario
    if (isset($_POST['NOMB_CLI']) && isset($_POST['APE_PAT']) && isset($_POST['CLAVE']) && isset($_POST['CELULAR']) && isset($_POST['EMAIL'])) {       
        $nomb_cli = $_POST['NOMB_CLI'];
        $ape_pat = $_POST['APE_PAT'];
        $ape_mat = $_POST['APE_MAT'];
        $dni = $_POST['DNI'];
        $clave = $_POST['CLAVE'];
        $celular = $_POST['CELULAR'];
        $email = $_POST['EMAIL'];
        // Paso 2: Generar nuevo ID
        if ($ultimo) {
            // Paso 2: Extraer el número después de "DV"
            $numero = $ultimo + 1 ;
        } else {
            // Si no hay registros, empieza en 1
            $numero = 1;
        }
        $sql = "INSERT INTO cliente(id_cliente,nomb_cliente,ape_paterno,ape_materno,dni_cliente,email,telefono,password_cliente)
                VALUES ($numero,'$nomb_cli','$ape_pat','$ape_mat','$dni','$email','$celular','$clave')";

        if ($cn->query($sql) === TRUE) {
            require_once '../../models/rutas.php';
            header("Location: ".$ruta_diseño_web."pedidos.php");
        } else {
            echo "Error al registrar: " . $cn->error;
        }
    } else {
        echo "Faltan datos del formulario.";
    }

    $cn->close();
?>