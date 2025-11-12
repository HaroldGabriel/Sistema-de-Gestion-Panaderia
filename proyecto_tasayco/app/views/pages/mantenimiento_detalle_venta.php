<link rel="stylesheet" href="../../../public/css/mantenimiento_detalle_venta.css">
<?php
    require_once '../../models/conexion.php';
    // Mostrar detalles de la venta si se recibe id_venta por GET
    if (isset($_GET['id_venta'])) {
        $id_venta = $_GET['id_venta'];
        $query_detalle = "SELECT * FROM detdocventa WHERE id_doc_venta = '$id_venta'";
        $result_detalle = mysqli_query($cn, $query_detalle);
    }
?>
<section class="head-page-mantenimiento-venta">
    <form method="get" class="form-volver-venta">
        <button type="submit" name="action" value="ventas" class="btn-volver">← Volver a Ventas</button>
    </form>
</section>
<div class="container-detalle-venta">
    <h2>Detalle de la venta: <?php echo htmlspecialchars($id_venta); ?></h2>
    <table class="detalle-venta-table">
        <tr>
            <th>ID Detalle</th>
            <th>ID Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
            <th>Total</th>
        </tr>
        <?php while ($row_det = mysqli_fetch_assoc($result_detalle)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row_det['id_det_doc_venta']); ?></td>
                <td><?php echo htmlspecialchars($row_det['id_producto']); ?></td>
                <td><?php echo htmlspecialchars($row_det['cantidad']); ?></td>
                <td><?php echo htmlspecialchars($row_det['precio_unitario']); ?></td>
                <td><?php echo htmlspecialchars($row_det['subtotal']); ?></td>
                <td><?php echo htmlspecialchars($row_det['total']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>