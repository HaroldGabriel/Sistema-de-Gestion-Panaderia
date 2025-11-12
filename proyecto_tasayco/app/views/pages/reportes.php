<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/reportes.css">
</head>
<body>
    <?php 
        require_once '../../models/conexion.php';
        require_once '../includes/consultas_reporte.php';
        $ruta = 'reportes';
        $reporte = $_GET['reporte'] ?? '';
        $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
        $por_pagina = 5;
        $inicio = ($pagina - 1) * $por_pagina;
        switch ($reporte) {
            case '✔️ Ventas':
                $max = 150;
                $tabla = 'docventa';
                $query = "SELECT fecha, subtotal, total FROM docventa LIMIT $inicio, $por_pagina";                
                $query2 = "SELECT p.nomb_producto AS nombre_producto,SUM(d.total) AS cantidad_vendida
                FROM detdocventa d
                JOIN producto p ON d.id_producto = p.id_producto
                GROUP BY p.id_producto, p.nomb_producto
                ORDER BY cantidad_vendida DESC
                LIMIT 5;";
                $query3 = $query_abajo;
                break;
            case '🛒 Compras':
                $max = 10;
                $tabla = 'doccompra';
                $query3 = "SELECT 
                                u.nombre,
                                u.apellido,
                                SUM(dc.total) AS total_gastado
                            FROM doccompra dc
                            JOIN usuario u ON dc.id_usuario = u.id_usuario
                            GROUP BY u.nombre, u.apellido
                            ORDER BY total_gastado DESC;";
                $query2 = "SELECT 
                                u.nombre,
                                u.apellido,
                                COUNT(*) AS total_compras
                            FROM doccompra dc
                            JOIN usuario u ON dc.id_usuario = u.id_usuario
                            GROUP BY u.nombre, u.apellido
                            ORDER BY total_compras DESC;";
                $query = "SELECT id_doc_compra,id_usuario,fecha,subtotal,total FROM doccompra LIMIT $inicio, $por_pagina";
                break;
            case '📦 Mov. Inventario':
                $max = 10;
                $tabla = 'producto';
                $query2 = "SELECT 
                            id_producto,
                            nomb_producto,
                            stock_inicial,
                            stock
                        FROM producto
                        WHERE stock <= 5
                        ORDER BY stock ASC
                        LIMIT 10;";
                $query3="SELECT 
                        id_producto, 
                        nomb_producto, 
                        stock_inicial, 
                        stock,
                        (stock_inicial - stock) AS stock_vendido
                    FROM producto
                    ORDER BY stock_vendido DESC
                    LIMIT 10;
                    ";
                $query = "SELECT id_producto,stock_inicial,stock FROM producto LIMIT $inicio, $por_pagina";
                break;
            default:
                $max = 150;
                $tabla = 'docventa';
                $query2 = "SELECT p.nomb_producto AS nombre_producto,SUM(d.total) AS cantidad_vendida
                FROM detdocventa d
                JOIN producto p ON d.id_producto = p.id_producto
                GROUP BY p.id_producto, p.nomb_producto
                ORDER BY cantidad_vendida DESC
                LIMIT 5;";
                $query3 = $query_abajo;
                $query = "SELECT fecha, subtotal, total FROM docventa LIMIT $inicio, $por_pagina";
                break;
        }
        
        
        if($tabla == 'docventa'){
            $result2 = mysqli_query($cn,$query2);
            $labels = [];
            $valores = [];
            
            while ($fila = $result2->fetch_assoc()) {
                $labels[] = $fila['nombre_producto'];
                $valores[] = $fila['cantidad_vendida'];
            }

            $result1 = mysqli_query($cn, $query3);

            $labels1 = [];
            $valores1 = [];

            while ($fila1 = mysqli_fetch_assoc($result1)) {
                $labels1[] = $fila1['dia'];
                $valores1[] = $fila1['dinero_total'];
            }
        }if($tabla == 'doccompra'){
            $result2 = mysqli_query($cn,$query2);
            $labels = [];
            $valores = [];
            
            while ($fila = $result2->fetch_assoc()) {
                $labels[] = $fila['nombre'];
                $valores[] = $fila['total_compras'];
            }

            $result1 = mysqli_query($cn, $query3);

            $labels1 = [];
            $valores1 = [];

            while ($fila1 = mysqli_fetch_assoc($result1)) {
                $labels1[] = $fila1['nombre'];
                $valores1[] = $fila1['total_gastado'];
            }
        }if($tabla == 'producto'){
            $result2 = mysqli_query($cn,$query2);
            $labels = [];
            $valores = [];
            
            while ($fila = $result2->fetch_assoc()) {
                $labels[] = $fila['nomb_producto'];
                $valores[] = $fila['stock'];
            }

            $result1 = mysqli_query($cn, $query3);

            $labels1 = [];
            $valores1 = [];

            while ($fila1 = mysqli_fetch_assoc($result1)) {
                $labels1[] = $fila1['nomb_producto'];
                $valores1[] = $fila1['stock_vendido'];
            }
        }

        $result_total = mysqli_query($cn, "SELECT COUNT(*) AS total FROM $tabla");       
        $result = $query ? mysqli_query($cn, $query) : null;
        $fila_total = mysqli_fetch_assoc($result_total);
        $total_registros = $fila_total['total'];
        $total_paginas = ceil($total_registros / $por_pagina);
        $index = 0;
        //var_dump($result1);
    ?>
    <div class="reportes-pages">
        <section class="head-reporte">
            <nav>
                <form action="" method="get">
                    <input type="hidden" name="page" value="reportes"> 
                    <input type="submit" class="menu-item" name="reporte" value="✔️ Ventas">               
                    <input type="submit" class="menu-item" name="reporte" value="🛒 Compras">
                    <input type="submit" class="menu-item" name="reporte" value="📦 Mov. Inventario">
                </form>
            </nav>
        </section>
        <section class="main-page-ventas">
            <div class="main-table-ventas">
                <table class="table-ventas">
                    <thead>
                        <tr>
                            <?php while ($row = mysqli_fetch_field($result)): ?>
                            <th><?php echo $row->name; ?></th>
                            <?php endwhile; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>                            
                        </tr>
                        <?php endwhile; ?>
                        </tr>
                    </tbody>
                </table>
                <?php include_once '../includes/paginacion.php' ?>
            </div>
            <div class="grafico1">
                <?php include_once '../../../public/chartjs/char3.php'; ?>
            </div>
            <!--
            <div class="grafico2">
                <?php //include_once '../../../public/chartjs/char4.php'; ?>
            </div> -->
           
        </section>
        
    </div>
    <?php mysqli_close($cn); ?>
</body>
</html>