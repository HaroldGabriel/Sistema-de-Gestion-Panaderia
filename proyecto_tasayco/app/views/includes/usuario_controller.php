<?php
    $result_total = mysqli_query($cn, "SELECT COUNT(*) AS total FROM usuario");
    $por_pagina = 5;
    $pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
    $inicio = ($pagina - 1) * $por_pagina;
    
    /*
    $result_head = mysqli_query($cn,"SELECT id_producto,nomb_producto,descripcion_producto,stock,stock_inicial,precio_unitario FROM producto LIMIT $inicio, $por_pagina");

    $result = mysqli_query($cn,"SELECT id_producto,nomb_producto,descripcion_producto,stock,stock_inicial,precio_unitario FROM producto LIMIT $inicio, $por_pagina");
    */
    // Filtros desde POST
    $buscar_id = $_POST['buscar_id'] ?? '';
    $buscar_nombre = $_POST['buscar_nombre'] ?? '';
    $filtro_stock = $_POST['filtro_stock'] ?? 'todos';
    $fecha = $_POST['fecha'] ?? '';
    // Construcción de cláusula WHERE
    $where = "WHERE 1=1";

    if (!empty($buscar_id)) {
    $id = mysqli_real_escape_string($cn, $buscar_id);
    $where .= " AND id_usuario LIKE '%$id%'";
    }

    if (!empty($buscar_nombre)) {
        $nombre = mysqli_real_escape_string($cn, $buscar_nombre);
        $where .= " AND username LIKE '%$nombre%'";
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
        $where .= " AND DATE(fecha_creacion) = '$fecha_f'";
    }


    
    // Consultas con filtros y paginación
    $result_total = mysqli_query($cn, "SELECT COUNT(*) AS total FROM usuario $where");
    $fila_total = mysqli_fetch_assoc($result_total);
    $total_registros = $fila_total['total'];
    
    $total_paginas = ceil($total_registros / $por_pagina);
    echo "<!-- WHERE generado: $where -->";
    $result_head = mysqli_query($cn, "SELECT id_usuario,id_rol,username ,password,nombre,dni,email,direccion FROM usuario $where LIMIT $inicio, $por_pagina");
    $result = mysqli_query($cn, "SELECT id_usuario,id_rol,username,password,nombre,dni,email,direccion FROM usuario $where LIMIT $inicio, $por_pagina");
?>