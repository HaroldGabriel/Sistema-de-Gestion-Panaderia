<?php
    session_start();
    require_once '../../models/conexion.php';
    require_once '../../models/rutas.php';
    $email = $_POST['EMAIL'];
    $clave = $_POST['CLAVE'];
    $sql = "SELECT * FROM cliente WHERE email='$email'";
    $resultado = $cn->query($sql);

    if ($resultado->num_rows == 1) {
        $cliente = $resultado->fetch_assoc();
        if ( $cliente['password_cliente'] === $clave) {
            // Redirigir o mantener sesión aquí
            $_SESSION['id_cliente'] = $cliente['id_cliente'];
            $_SESSION['nombre'] = $cliente['nomb_cliente'];
            $_SESSION['email'] = $cliente['email'];
            header("Location: ".$ruta_diseño_web."pedidos.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "❌ No existe una cuenta con ese correo.";
    }
    $cn->close();
?>