<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/mantenimiento_usuario.css">
</head>
<body>
    <?php
        require_once '../../models/conexion.php'; 
        require_once '../../models/rutas.php'; // Importamos las rutas
        $usuario = null;
         if (isset($_GET['action']) && $_GET['action'] === 'Editar Usuario' && isset($_GET['edit_id'])) {
            $id = $_GET['edit_id'];
            $query = "SELECT * FROM usuario WHERE id_usuario = '$id'";
            $result = mysqli_query($cn, $query);

            // ✅ Guardamos el usuario en un array asociativo
            if ($result && mysqli_num_rows($result) > 0) {
                $usuario = mysqli_fetch_assoc($result);
            }
            //var_dump($usuario);
        }
        
        
        if (isset($_POST['action'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $dni = $_POST['dni'];
            $direccion = $_POST['direccion'];
            
            if ($_POST['action'] === 'Guardar Usuario') {
                //include_once '../includes/subir.php';
                require_once '../includes/cn_mantenimiento_usuario.php'; 
                header("Location: " . $ruta_proyecto_tasayco . "/app/views/pages/principal.php?action=Crear+Usuario");
                exit;                
            }

            if ($_POST['action'] === 'Actualizar Usuario') {
                $id = $_POST['id_usuario'];
                $update = "UPDATE usuario 
                           SET nombre='$nombre', apellido='$apellido', username='$username', password='$password', email='$email', dni='$dni', direccion='$direccion'
                           WHERE id_usuario='$id'";
                if (mysqli_query($cn, $update)) {
                    header("Location: " . $ruta_proyecto_tasayco . "/app/views/pages/principal.php?action=Crear+Usuario");
                    exit;
                } else {
                    echo "Error al actualizar: " . mysqli_error($cn);
                }
            }
        }
    ?>
    <div class="mantenimiento-usuario-page">
        <section class="head-page-mantenimiento-usuario">
            <form method="get" class="form-volver-usuarios">
                <button type="submit" name="action" value="usuarios" class="btn-volver">← Volver a Usuarios</button>
            </form>
        </section>
        <section class="main-page-mantenimiento-usuario">
            <form action="" method="post" enctype="multipart/form-data" class="form-mantenimiento-usuario">

             <!-- Si estamos editando, guardamos el ID -->
                <?php if ($usuario): ?>
                    <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                <?php endif; ?>

                <label for="nombre">Nombre de usuario:</label>
                <input type="text" id="nombre" name="nombre" 
                       value="<?php echo $usuario ? htmlspecialchars($usuario['nombre']) : ''; ?>">
                <label for="apellido">Apellido de usuario:</label>
                <input type="text" id="apellido" name="apellido" 
                       value="<?php echo $usuario ? htmlspecialchars($usuario['apellido']) : ''; ?>">       

                <label for="descripcion">username del usuario:</label>
                <input type="text" id="username" name="username"
                       value="<?php echo $usuario ? htmlspecialchars($usuario['username']) : ''; ?>">

                <label for="stock">Contraseña del usuario:</label>
                <input type="text" id="password" name="password"
                       value="<?php echo $usuario ? htmlspecialchars($usuario['password']) : ''; ?>">

                <label for="precio">Email del usuario:</label>
                <input type="text" id="email" name="email"
                       value="<?php echo $usuario ? htmlspecialchars($usuario['email']) : ''; ?>">

              <label for="dni">DNI del usuario:</label>
              <input type="text" id="dni" name="dni"
                  value="<?php echo $usuario ? htmlspecialchars($usuario['dni']) : ''; ?>">

              <label for="direccion">Dirección del usuario:</label>
              <input type="text" id="direccion" name="direccion"
                  value="<?php echo $usuario ? htmlspecialchars($usuario['direccion']) : ''; ?>">

                <!--<div class="contain-image">                
                    <label for="imagen">Selecciona una imagen:</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*" <?php echo $usuario ? '' : 'required'; ?>>
                </div> -->

                <?php if ($usuario): ?>
                    <button type="submit" name="action" value="Actualizar Usuario" class="btn-guardar">Actualizar Usuario</button>
                <?php else: ?>
                    <button type="submit" name="action" value="Guardar Usuario" class="btn-guardar">Guardar Usuario</button>
                <?php endif; ?>  
            </form>        
        </section>
    </div>
    <?php mysqli_close($cn); ?>
</body>
</html>