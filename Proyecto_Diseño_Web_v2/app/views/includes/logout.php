<?php
require_once '../../models/rutas.php';
    session_start();
    session_unset(); 
    session_destroy(); 
    header("Location: ".$ruta_diseño_web."pedidos.php");
    exit;
?>