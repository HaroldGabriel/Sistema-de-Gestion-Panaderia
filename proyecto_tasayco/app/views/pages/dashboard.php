<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
</head>
<body>
    <?php 
        require_once '../../models/conexion.php';
        $query ="SELECT 
                p.id_producto,
                p.nomb_producto,
                SUM(dv.cantidad) AS total_vendido
                FROM detdocventa dv
                JOIN producto p ON dv.id_producto = p.id_producto
                GROUP BY p.id_producto, p.nomb_producto
                ORDER BY total_vendido DESC
                LIMIT 5;" ;

        $query2 = "SELECT 
                        p.nomb_producto AS nombre_producto,
                        SUM(dv.cantidad) AS cantidad_vendida
                    FROM detdocventa dv
                    JOIN producto p ON dv.id_producto = p.id_producto
                    GROUP BY p.id_producto, p.nomb_producto
                    ORDER BY cantidad_vendida DESC
                    LIMIT 5;";
        $result = mysqli_query($cn,$query);
        $result2 = mysqli_query($cn,$query2);
        $labels = [];
        $valores = [];
        
        while ($fila = $result2->fetch_assoc()) {
            $labels[] = $fila['nombre_producto'];
            $valores[] = $fila['cantidad_vendida'];
        }

    ?>
    <div class="dashboard-page">
        <div class="area-chart">
            <?php include_once '../../../public/chartjs/char1.html'; ?>
        </div>
        <div class="bar-chart">
            <?php include_once '../../../public/chartjs/char2.php'; ?>
        </div>
        <div class="area-table">
            <table class="table-dashboard">
                <thead>
                    <tr>
                        <?php while ($row = mysqli_fetch_field($result)): ?>
                                <th><?php echo $row->name; ?></th>
                        <?php endwhile; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <?php foreach ($row as $value): ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>                            
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php mysqli_close($cn); ?>
</body>
</html>

<!-- Carga Chart.js (solo una vez) -->

