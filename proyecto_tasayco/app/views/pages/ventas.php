<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/ventas.css">
</head>
<body>
    <?php        
        require_once '../../models/conexion.php';
        if (isset($_POST['limpiar'])) {
            $_POST = []; // Vacía todo
            $buscar_id = $buscar_usuario = $filtro_stock = $fecha = $pago = '';
            $pagina = 1;
        }
        // Eliminar venta y sus detalles
        if (isset($_POST['eliminar_venta']) && isset($_POST['id_venta'])) {
            $id_venta = $_POST['id_venta'];
            // Eliminar detalles primero
            $query_detalle = "DELETE FROM detdocventa WHERE id_doc_venta = '$id_venta'";
            mysqli_query($cn, $query_detalle);
            // Eliminar venta principal
            $query_venta = "DELETE FROM docventa WHERE id_doc_venta = '$id_venta'";
            mysqli_query($cn, $query_venta);
            // Opcional: mensaje de éxito
            echo '<script>alert("Venta eliminada correctamente.");</script>';
        }
        include_once '../includes/ventas_controller.php';
        //var_dump($pago);
    ?>
    <div class="ventas-page">
        <section class="head-venta">
            <h1>Ventas</h1>
        </section>
        <section class="filtros-venta">
            <form method="POST" action="" class="form-filtros-ventas">
                <div class="buscadores1">
                    <div class="buscador-id">
                        <input type="text" placeholder="Buscar id..." name="buscar_id" value="<?= htmlspecialchars($buscar_id) ?>">
                        <button type="submit" class="btn-buscar-venta">Buscar</button>
                    </div>
                    <div class="buscador-nombre">
                        <input type="text" placeholder="Buscar usuario..." name="buscar_usuario" value="<?= htmlspecialchars($buscar_usuario) ?>">
                        <button type="submit" class="btn-buscar-venta">Buscar</button>
                    </div>
                </div>
                <div class="buscadores2">
                    <!--<div class="generico">
                        <label for="pendiente" class="label-pendiente">Estado:</label>
                        <select name="pendiente">
                            <option value="null">Seleccionar</option>
                            <option value="pendiente">pendiente</option>
                            <option value="finalizado">finalizado</option>
                            <option value="en_proceso">en proceso</option>
                        </select>
                    </div>-->
                    <div class="generico">
                        <?php 
                            $query_pago = "SELECT tipo_pago, MIN(id_pago) as id_pago
                            FROM forma_pago
                            GROUP BY tipo_pago;";
                            $result_pago = mysqli_query($cn, $query_pago);
                        ?>
                        <label for="pendiente" class="label-pendiente">Pago:</label>
                        <select name="pago" onchange="this.form.submit()">
                            <option value="">Seleccionar</option>
                            <?php while ($row_pago = mysqli_fetch_assoc($result_pago)): ?>
                                <option value="<?= $row_pago['tipo_pago'] ?>" 
                                    <?= (isset($pago) && $pago == $row_pago['tipo_pago']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row_pago['tipo_pago']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="buscadores2">
                    <!--<div class="generico">
                        <label for="pendiente" class="label-pendiente">Pendiente:</label>
                        <select name="pendiente">
                            <option value="null">Seleccionar</option>
                            <option value="pendiente">pendiente</option>
                            <option value="finalizado">finalizado</option>
                            <option value="en_proceso">en proceso</option>
                        </select>
                    </div>-->
                    <div class="fecha">
                        <label for="fecha" class="label-fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" onchange="this.form.submit()" value="<?= htmlspecialchars($fecha) ?>">
                    </div>
                </div>
                <div class="limpiar-filtros">
                    <button type="submit" class="btn-limpiar-filtros" name="limpiar">Limpiar Filtros</button>
                </div>
            </form>
        </section>
        <section class="table-productos">
            <table class="productos-table-main">
                <thead>
                    <tr>
                        <?php while ($row = mysqli_fetch_field($result_head)): ?>
                            <th><?php echo $row->name; ?></th>
                        <?php endwhile; ?>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>
                            <td>
                                <form action="" method="get" style="display:inline;">
                                    <input type="hidden" name="action" value="Mostrar Detalle">
                                    <input type="hidden" name="id_venta" value="<?php echo $row['id_doc_venta']; ?>">
                                    <button type="submit" class="btn-mostrar">✏️ Mostrar</button>
                                </form>
                                <form action="" method="post" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar esta venta? Se eliminarán todos los detalles asociados.');">
                                    <input type="hidden" name="id_venta" value="<?php echo $row['id_doc_venta']; ?>">
                                    <button type="submit" name="eliminar_venta" class="btn-eliminar">🗑️ Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
        <div class="paginacion">
            <?php include_once '../includes/paginacion_ventas.php'; ?>
        </div>
    </div>
    <?php mysqli_close($cn); ?>
</body>
</html>