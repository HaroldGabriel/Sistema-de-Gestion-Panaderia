<?php
    // Mostrar detalles de la venta si se recibe id_venta por GET
    if (isset($_GET['id_venta'])) {
        $id_venta = $_GET['id_venta'];
        $query_detalle = "SELECT * FROM detdocventa WHERE id_doc_venta = '$id_venta'";
        $result_detalle = mysqli_query($cn, $query_detalle);
        echo '<div class="detalle-venta" style="background:#f7f7fa;border:1px solid #ccc;padding:16px;margin-bottom:20px;border-radius:8px;">';
        echo '<h2>Detalle de la venta: ' . htmlspecialchars($id_venta) . '</h2>';
        echo '<table style="width:100%;border-collapse:collapse;">';
        echo '<tr><th>ID Detalle</th><th>ID Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th><th>Total</th></tr>';
        while ($row_det = mysqli_fetch_assoc($result_detalle)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row_det['id_det_doc_venta']) . '</td>';
            echo '<td>' . htmlspecialchars($row_det['id_producto']) . '</td>';
            echo '<td>' . htmlspecialchars($row_det['cantidad']) . '</td>';
            echo '<td>' . htmlspecialchars($row_det['precio_unitario']) . '</td>';
            echo '<td>' . htmlspecialchars($row_det['subtotal']) . '</td>';
            echo '<td>' . htmlspecialchars($row_det['total']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<form method="get"><button type="submit" style="margin-top:10px;" class="btn-limpiar-filtros">Cerrar Detalle</button></form>';
        echo '</div>';
    }
?>