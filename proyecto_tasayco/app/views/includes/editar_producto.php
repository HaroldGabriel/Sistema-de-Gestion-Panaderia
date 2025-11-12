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

// --- 1. Traer datos actuales del producto ---
$producto = null;
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($cn, $_GET['id']);
    $sql = "SELECT * FROM producto WHERE id_producto = '$id' LIMIT 1";
    $res = mysqli_query($cn, $sql);
    $producto = mysqli_fetch_assoc($res);
}

// --- 2. Guardar cambios ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Actualizar Producto') {
    $id = mysqli_real_escape_string($cn, $_POST['id']);
    $nombre = mysqli_real_escape_string($cn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($cn, $_POST['descripcion']);
    $stock = (int) $_POST['stock'];
    $precio = (float) $_POST['precio'];

    // Manejo de imagen
    $nombreArchivo = $_FILES['imagen']['name'] ?? '';
    if (!empty($nombreArchivo)) {
        $carpeta = "../../../../img_productos/";
        $rutaDestino = $carpeta . basename($nombreArchivo);
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $sql = "UPDATE producto 
                    SET nombre = '$nombre', descripcion = '$descripcion', stock = $stock, precio = $precio, imagen = '$nombreArchivo' 
                    WHERE id_producto = '$id'";
        }
    } else {
        // Si no cambia la imagen
        $sql = "UPDATE producto 
                SET nombre = '$nombre', descripcion = '$descripcion', stock = $stock, precio = $precio
                WHERE id_producto = '$id'";
    }

    if (mysqli_query($cn, $sql)) {
        header("Location: productos.php?status=updated");
        exit;
    } else {
        echo "❌ Error al actualizar: " . mysqli_error($cn);
    }
}
?>

<div class="mantenimiento-producto-page">
    <section class="head-page-mantenimiento-producto">
        <form method="get" action="productos.php" class="form-volver-productos">
            <button type="submit" class="btn-volver">← Volver a Productos</button>
        </form>
    </section>

    <section class="main-page-mantenimiento-producto">
        <?php if ($producto): ?>
        <form action="" method="post" class="form-mantenimiento-producto" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">

            <label for="nombre">Nombre de producto:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">

            <label for="descripcion">Descripcion del producto:</label>
            <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($producto['descripcion']); ?>">

            <label for="stock">Stock del producto:</label>
            <input type="text" id="stock" name="stock" value="<?php echo $producto['stock']; ?>">

            <label for="precio">Precio del producto:</label>
            <input type="text" id="precio" name="precio" value="<?php echo $producto['precio']; ?>">

            <div class="contain-image">                
                <label for="imagen">Imagen del producto:</label><br>
                <?php if (!empty($producto['imagen'])): ?>
                    <img src="../../../../img_productos/<?php echo $producto['imagen']; ?>" width="120"><br>
                <?php endif; ?>
                <input type="file" name="imagen" id="imagen" accept="image/*">
            </div>

            <button type="submit" value="Actualizar Producto" name="action">Actualizar Producto</button>
        </form>    
        <?php else: ?>
            <p>⚠️ Producto no encontrado.</p>
        <?php endif; ?>
    </section>
</div>

<?php mysqli_close($cn); ?>
</body>
</html>
