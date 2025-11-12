<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/mantenimiento_producto.css">
</head>
<body>
    <?php
        require_once '../../models/conexion.php'; 
        require_once '../../models/rutas.php'; // Importamos las rutas
        $producto = null;
         if (isset($_GET['action']) && $_GET['action'] === 'Editar Producto' && isset($_GET['edit_id'])) {
            $id = $_GET['edit_id'];
            $query = "SELECT * FROM producto WHERE id_producto = '$id'";
            $result = mysqli_query($cn, $query);

            // ✅ Guardamos el producto en un array asociativo
            if ($result && mysqli_num_rows($result) > 0) {
                $producto = mysqli_fetch_assoc($result);
            }
            //var_dump($producto);
        }
        
        
        if (isset($_POST['action'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $stock = $_POST['stock']?? 0;
            $precio = $_POST['precio'];

            if ($_POST['action'] === 'Guardar Producto') {
                include_once '../includes/subir.php';
                require_once '../includes/cn_mantenimiento_producto.php'; 
                header("Location: " . $ruta_proyecto_tasayco . "/app/views/pages/principal.php?action=Crear+Producto");
                exit;                
            }

            if ($_POST['action'] === 'Actualizar Producto') {
                include '../includes/subir.php';
                $id = $_POST['id_producto'];
                $update = "UPDATE producto 
                           SET nomb_producto='$nombre', descripcion_producto='$descripcion', stock=$stock, precio_unitario=$precio, img_route='$nombreArchivo'
                           WHERE id_producto='$id'";
                if (mysqli_query($cn, $update)) {
                    header("Location: " . $ruta_proyecto_tasayco . "/app/views/pages/principal.php?action=Crear+Producto");
                    exit;
                } else {
                    echo "Error al actualizar: " . mysqli_error($cn);
                }
            }
        }
    ?>
    <div class="mantenimiento-producto-page">
        <section class="head-page-mantenimiento-producto">
            <form method="get" class="form-volver-productos">
                <button type="submit" name="action" value="productos" class="btn-volver">← Volver a Productos</button>
            </form>
        </section>
        <section class="main-page-mantenimiento-producto">
            <form action="" method="post" enctype="multipart/form-data" class="form-mantenimiento-producto">

             <!-- Si estamos editando, guardamos el ID -->
                <?php if ($producto): ?>
                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                <?php endif; ?>

                <label for="nombre">Nombre de producto:</label>
                <input type="text" id="nombre" name="nombre" 
                       value="<?php echo $producto ? htmlspecialchars($producto['nomb_producto']) : ''; ?>">

                <label for="descripcion">Descripcion del producto:</label>
                <input type="text" id="descripcion" name="descripcion"
                       value="<?php echo $producto ? htmlspecialchars($producto['descripcion_producto']) : ''; ?>">

                <label for="stock">Stock del producto:</label>
                <input type="text" id="stock" name="stock"
                       value="<?php echo $producto ? htmlspecialchars($producto['stock']) : ''; ?>">

                <label for="precio">Precio del producto:</label>
                <input type="text" id="precio" name="precio"
                       value="<?php echo $producto ? htmlspecialchars($producto['precio_unitario']) : ''; ?>">

                <div class="contain-image">                
                    <label for="imagen">Selecciona una imagen:</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*" <?php echo $producto ? '' : 'required'; ?>>
                </div>

                <?php if ($producto): ?>
                    <button type="submit" name="action" value="Actualizar Producto">Actualizar Producto</button>
                <?php else: ?>
                    <button type="submit" name="action" value="Guardar Producto">Guardar Producto</button>
                <?php endif; ?>  
            </form>        
        </section>
    </div>
    <?php mysqli_close($cn); ?>
</body>
</html>