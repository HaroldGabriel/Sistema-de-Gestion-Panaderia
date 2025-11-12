<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/manteniemiento_cliente.css">
</head>
<body>
    <?php
        require_once '../../models/conexion.php'; 
        require_once '../../models/rutas.php'; // Importamos las rutas
        $cliente = null;
         if (isset($_GET['action']) && $_GET['action'] === 'Editar Cliente' && isset($_GET['edit_id'])) {
            $id = $_GET['edit_id'];
            $query = "SELECT * FROM cliente WHERE id_cliente = '$id'";
            $result = mysqli_query($cn, $query);

            // ✅ Guardamos el producto en un array asociativo
            if ($result && mysqli_num_rows($result) > 0) {
                $cliente = mysqli_fetch_assoc($result);
            }
            var_dump($cliente);
        }
        
        
        if (isset($_POST['action'])) {
            $tipo_cliente = $_POST['tipo_cliente'];
            $nombre = $_POST['nomb_cliente'];
            $ape_paterno = $_POST['ape_paterno'];
            $ape_materno = $_POST['ape_materno'];
            $dni_cliente = $_POST['dni_cliente'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $dirección = $_POST['dirección'];
            $id_ciudad = $_POST['id_ciudad'];
            $password_cliente = $_POST['password_cliente'];

            if ($_POST['action'] === 'Guardar Cliente') {
                //include_once '../includes/subir.php';
                require_once '../includes/cn_mantenimiento_cliente.php'; 
                header("Location: " . $ruta_proyecto_tasayco . "/app/views/pages/principal.php?action=Crear+Cliente");
                exit;                
            }

            if ($_POST['action'] === 'Actualizar Cliente') {
                //include '../includes/subir.php';
                $id = $_POST['id_cliente'];
                $update = "UPDATE cliente 
                           SET tipo_cliente='$tipo_cliente', 
                           nomb_cliente='$nombre',
                           ape_paterno='$ape_paterno', 
                           ape_materno='$ape_materno', 
                           dni_cliente='$dni_cliente',
                           email='$email',
                           telefono='$telefono',
                           dirección='$dirección',
                           id_ciudad='$id_ciudad',
                           password_cliente='$password_cliente'
                           WHERE id_cliente='$id'";
                if (mysqli_query($cn, $update)) {
                    header("Location: " . $ruta_proyecto_tasayco . "/app/views/pages/principal.php?action=Crear+Cliente");
                    exit;
                } else {
                    echo "Error al actualizar: " . mysqli_error($cn);
                }
            }
        }
    ?>
    <div class="mantenimiento-cliente-page">
        <section class="head-page-mantenimiento-cliente">
            <form method="get" class="form-volver-cliente">
                <button type="submit" name="action" value="clientes" class="btn-volver">← Volver a Cliente</button>
            </form>
        </section>
        <section class="main-page-mantenimiento-cliente">
            <form action="" method="post" enctype="multipart/form-data" class="form-mantenimiento-cliente">

             <!-- Si estamos editando, guardamos el ID -->
                <?php if ($cliente): ?>
                    <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
                <?php endif; ?>

                <label for="tipo_cliente">Tipo cliente:</label>
                <input type="text" id="tipo_cliente" name="tipo_cliente" 
                       value="<?php echo $cliente ? htmlspecialchars($cliente['tipo_cliente']) : ''; ?>">

                <label for="nomb_cliente">Nombre Cliente:</label>
                <input type="text" id="nomb_cliente" name="nomb_cliente"
                       value="<?php echo $cliente ? htmlspecialchars($cliente['nomb_cliente']) : ''; ?>">

                <label for="ape_paterno">Apellido Paterno:</label>
                <input type="text" id="ape_paterno" name="ape_paterno"
                       value="<?php echo $cliente ? htmlspecialchars($cliente['ape_paterno']) : ''; ?>">

                <label for="ape_materno">Apellido Materno:</label>
                <input type="text" id="ape_materno" name="ape_materno"
                       value="<?php echo $cliente ? htmlspecialchars($cliente['ape_materno']) : ''; ?>">

                <label for="dni_cliente">DNI:</label>
                <input type="text" id="dni_cliente" name="dni_cliente"
                       value="<?php echo $cliente ? htmlspecialchars($cliente['dni_cliente']) : ''; ?>">

                <label for="email">email:</label>
                <input type="text" id="email" name="email"
                       value="<?php echo $cliente ? htmlspecialchars($cliente['email']) : ''; ?>">
                
                <label for="telefono">telefono:</label>
                <input type="text" id="telefono" name="telefono"
                       value="<?php echo $cliente ? htmlspecialchars($cliente['telefono']) : ''; ?>">
                
                <label for="dirección">dirección:</label>
                <input type="text" id="dirección" name="dirección"
                       value="<?php echo $cliente ? htmlspecialchars($cliente['dirección']) : ''; ?>">

                <label for="id_ciudad">id_ciudad:</label>
                <input type="text" id="id_ciudad" name="id_ciudad"
                       value="<?php echo $cliente ? htmlspecialchars($cliente['id_ciudad']) : ''; ?>">

                <label for="password_cliente">password_cliente:</label>
                <input type="text" id="password_cliente" name="password_cliente"
                       value="<?php echo $cliente ? htmlspecialchars($cliente['password_cliente']) : ''; ?>">

                <?php if ($cliente): ?>
                    <button type="submit" name="action" value="Actualizar Cliente">Actualizar Cliente</button>
                <?php else: ?>
                    <button type="submit" name="action" value="Guardar Cliente">Guardar Cliente</button>
                <?php endif; ?>  
            </form>        
        </section>
    </div>
    <?php mysqli_close($cn); ?>
</body>
</html>