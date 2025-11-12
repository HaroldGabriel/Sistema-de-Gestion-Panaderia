<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/cliente.css">
</head>
    <body>
        <?php 
            //require_once '../includes/cn_producto.php';
            require_once '../../models/conexion.php';
            // Evitar que MySQL lance fatal error 
            mysqli_report(MYSQLI_REPORT_OFF);
            // Eliminar cliente
            if (isset($_POST['id'])) {
                $id_cliente = intval($_POST['id']);
                $query = "DELETE FROM cliente WHERE id_cliente = $id_cliente";
                if (mysqli_query($cn, $query)) {
                    echo '<script>alert("Cliente eliminado correctamente."); window.location.href=window.location.href;</script>';
                    exit();
                } else {
                    $error = mysqli_error($cn);
                    if (strpos($error, 'foreign key') !== false || strpos($error, 'a foreign key constraint fails') !== false) {
                        echo '<script>alert("No se puede eliminar el cliente porque está asociado a una venta u otro registro."); window.location.href=window.location.href;</script>';
                        exit();
                    } else {
                        echo '<script>alert("Error al eliminar cliente: ' . addslashes($error) . '"); window.location.href=window.location.href;</script>';
                        exit();
                    }
                }
            }
            if (isset($_POST['limpiar'])) {
                $_POST = []; // Vacía todo
                $buscar_id = $buscar_nombre = $filtro_stock = $fecha = '';
                $pagina = 1;
            }
            include_once '../includes/cliente/cliente_controller.php';
            /*include_once '../includes/editar_producto.php';*/
            include_once '../includes/cliente/eliminar_cliente.php';
            //var_dump($_POST);
         ?>
        <div class="clientes-page">
            <section class="head-cliente">
                <h1>Clientes</h1>
            </section>
            <section class="filtros-cliente">
                <form method="POST" action="" class="form-filtros-cliente">
                    <div class="buscadores1">
                        <div class="buscador-id">
                            <input type="text" name="buscar_id" placeholder="Buscar id..." value="<?= htmlspecialchars($buscar_id) ?>">
                            <button type="submit" class="btn-buscar-cliente">Buscar</button>
                        </div>
                        <div class="buscador-nombre">
                            <input type="text" name="buscar_nombre" placeholder="Buscar cliente..." value="<?= htmlspecialchars($buscar_nombre) ?>">
                            <button type="submit" class="btn-buscar-cliente">Buscar</button>
                        </div>
                    </div>
                    
                    <div class="limpiar-filtros">
                        <button type="submit" name="limpiar" value="1" class="btn-limpiar-filtros">Limpiar Filtros</button>
                    </div>
                </form>
            </section>
            <section class="mantenedor-cliente">
                <div class="btn-crear-cliente">
                    <form action="" method="get">
                        <input type="submit" class="btn-crear" value="Crear Cliente" name="action">
                    </form>
                </div>
            </section>
            <section class="table-clientes">
                <table class="clientes-table-main">
                    <thead>
                        <tr>
                            <?php while ($row = mysqli_fetch_field($result_head)): ?>
                                <th><?php echo $row->name; ?></th>
                            <?php endwhile; ?>
                            <th>Acciones</th> <!-- Nueva columna -->
                        </tr>
                    </thead>
                    <tbody>
                            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <?php foreach ($row as $value): ?>
                                            <td><?php echo htmlspecialchars($value); ?></td>
                                        <?php endforeach; ?> 
                                        <td>
                                            <!-- Botón Editar -->
                                            <form action="" method="get" style="display:inline;">
                                                <input type="hidden" name="action" value="Editar Cliente">
                                                <input type="hidden" name="edit_id" value="<?php echo $row['id_cliente']; ?>">
                                                <button type="submit" class="btn-editar">✏️ Editar</button>
                                            </form>

                                            <!-- Botón Eliminar -->
                                            <form action="" method="post" style="display:inline;" 
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                                <input type="hidden" name="id" value="<?php echo $row['id_cliente']; ?>">
                                                <button type="submit" class="btn-eliminar">🗑️ Eliminar</button>
                                            </form>
                                        </td>                           
                                    </tr>                            
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="100%">No se encontraron clientes o hubo un error en la consulta.</td>
                                </tr>
                            <?php endif; ?>
                    </tbody>
                </table>
            </section>
            <?php include_once '../includes/cliente/paginacion_cliente.php'; ?>
        </div>
        <?php mysqli_close($cn); ?>
    </body>
</html>