<?php
    require_once '../../models/conexion.php';
    $query = "SELECT * FROM docventa";
    $result = mysqli_query($cn, $query);
?>