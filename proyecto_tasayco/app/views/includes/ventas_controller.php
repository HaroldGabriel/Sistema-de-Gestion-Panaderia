<?php
    $result_total = mysqli_query($cn, "SELECT COUNT(*) AS total FROM docventa");
    $por_pagina = 5;
    $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
    $inicio = ($pagina - 1) * $por_pagina;
    //$result_head = mysqli_query($cn,"SELECT * FROM docventa LIMIT $inicio, $por_pagina");
    // Filtros desde POST
    $buscar_id = $_POST['buscar_id'] ?? '';
    $buscar_usuario = $_POST['buscar_usuario'] ?? '';
    $filtro_stock = $_POST['filtro_stock'] ?? 'todos';
    $fecha = $_POST['fecha'] ?? '';
    $pago = isset($_POST['pago']) ? $_POST['pago'] : '';

    // Construcción de cláusula WHERE
    $where = "WHERE 1=1";

    if (!empty($buscar_id)) {
    $id = mysqli_real_escape_string($cn, $buscar_id);
    $where .= " AND id_doc_venta LIKE '%$id%'";
    }

    if (!empty($buscar_usuario)) {
        $usuario = mysqli_real_escape_string($cn, $buscar_usuario);
        $where .= " AND id_usuario LIKE '%$usuario%'";
    }

    
    if (!empty($pago)) {
        $where .= " AND p.tipo_pago = '" . mysqli_real_escape_string($cn, $pago) . "'";
    }

    if ($filtro_stock != 'todos') {
        if ($filtro_stock == 'disponibles') {
            $where .= " AND stock > 0";
        } elseif ($filtro_stock == 'agotados') {
            $where .= " AND stock <= 0";
        }
    }

    if (!empty($fecha)) {
        $fecha_f = mysqli_real_escape_string($cn, $fecha);
        $where .= " AND DATE(fecha) = '$fecha_f'";
    }

    // Consultas con filtros y paginación
    $result_total = mysqli_query($cn, "SELECT COUNT(*) AS total FROM docventa v inner JOIN forma_pago p ON v.id_pago = p.id_pago $where");
    $fila_total = mysqli_fetch_assoc($result_total);
    $total_registros = $fila_total['total'];
    $total_paginas = ceil($total_registros / $por_pagina);
    echo "<!-- WHERE generado: $where -->";
    $query_filtro = "SELECT v.id_doc_venta,v.id_cliente,v.tipo_doc_venta,v.id_usuario,v.fecha,p.tipo_pago,v.igv,v.subtotal,v.total FROM docventa v inner join forma_pago p on v.id_pago = p.id_pago $where ORDER BY v.id_doc_venta ASC LIMIT $inicio, $por_pagina ;";
    $result_head = mysqli_query($cn,$query_filtro);
    $result = mysqli_query($cn,$query_filtro);
  
    /*
    $result = mysqli_query($cn,"SELECT * FROM docventa LIMIT $inicio, $por_pagina");

    $fila_total = mysqli_fetch_assoc($result_total);
    $total_registros = $fila_total['total'];
    $total_paginas = ceil($total_registros / $por_pagina);
    $index = 0;*/
?>