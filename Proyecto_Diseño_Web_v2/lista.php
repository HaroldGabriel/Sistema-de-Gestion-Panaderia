<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
        <title>Document</title>
    </head>
    <body>
        <?php
            require_once 'app/models/conexion.php';
            session_start(); //Inicia la sesión o la reanuda
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }
            // --- Paginación básica y filtro por precio ---
            $per_page = 12; // productos por página
            $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

            // Filtro por precio (GET)
            $min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? floatval($_GET['min_price']) : null;
            $max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? floatval($_GET['max_price']) : null;
            // Si ambos existen y min > max, los intercambiamos
            if (!is_null($min_price) && !is_null($max_price) && $min_price > $max_price) {
                $tmp = $min_price; $min_price = $max_price; $max_price = $tmp;
            }

            // Construir cláusula WHERE para precio
            $where_clauses = [];
            if (!is_null($min_price)) {
                $where_clauses[] = "precio_unitario >= " . floatval($min_price);
            }
            if (!is_null($max_price)) {
                $where_clauses[] = "precio_unitario <= " . floatval($max_price);
            }
            $where_sql = count($where_clauses) ? ('WHERE ' . implode(' AND ', $where_clauses)) : '';

            // Obtener total de productos con filtro
            $count_sql = "SELECT COUNT(*) as total FROM producto {$where_sql}";
            $count_res = mysqli_query($cn, $count_sql);
            $total = 0;
            if ($count_res) {
                $row_count = mysqli_fetch_assoc($count_res);
                $total = intval($row_count['total']);
            }
            $total_pages = max(1, (int) ceil($total / $per_page));
            if ($page > $total_pages) $page = $total_pages;
            $offset = ($page - 1) * $per_page;

            // Consulta paginada con filtro
            $query = "SELECT id_producto, nomb_producto, descripcion_producto, precio_unitario, img_route FROM producto {$where_sql} ORDER BY id_producto asc LIMIT {$offset}, {$per_page}";
            $resultado = mysqli_query($cn, $query);
            //unset($_SESSION['carrito']); // solo para pruebas borra todo el contenido de 'carrito'
            if (isset($_POST['agregar_carrito'])) {
                $mensaje = "Producto agregado con éxito";
                $id_producto = $_POST['id_producto'];
                $producto = $_POST['producto'];
                $precio = $_POST['precio'];
                $cantidad = 1;
                    $usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
                    if ($usuario === "") {
                        header("Location: pedidos.php");
                        exit();
                    }
                    if (isset($_SESSION['carrito'][$id_producto])) {
                        // Si existe, aumentamos la cantidad
                        $_SESSION['carrito'][$id_producto]['cantidad'] += $cantidad;
                    }else{
                        // Guardar en carrito (sesión)
                        $_SESSION['carrito'][$id_producto] = [                        
                            'producto' => $producto,
                            'precio' => $precio,
                            'cantidad' => $cantidad
                        ];
                    }
                
                //var_dump($_SESSION['carrito']);
            }
            //header("Location: " . $_SERVER['PHP_SELF']);
            //exit();
        ?>
        <!--========================================
            HEADER CON NAVEGACIÓN RESPONSIVE
        ======================================== -->       
        <header class="header-main">
            <div class="logo">
                <img src="img/logo_original.png" alt="">
            </div>
            <h1>Pastelería Buenaventura</h1>
            <!-- MENÚ MÓVIL -->
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="hamburger-icon">☰</label>
            <nav class="navbar">
                <ul class="nav-links">
                    <label for="menu-toggle" class="close-btn">✖</label>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="lista.php">Menú</a></li>
                    <!--<li><a href="#about">Acerca de</a></li>
                    <li><a href="#contact">Contacto</a></li>
                    <li><a href="#galeria">Galería</a></li>-->
                    <li><a href="pedidos.php">Pedidos</a></li>
                    <li><a href="../proyecto_tasayco/public/index.php">Backoffice</a></li>
                </ul>
            </nav>
        </header>
        <div class="separador-section"></div>
        <!--========================================
            CONTENIDO PRINCIPAL CON SIDEBAR
        ======================================== --> 
        <?php if (isset($mensaje)): ?>
                <div style="background:#d4edda;color:#155724;padding:10px;margin-bottom:15px;border-radius:5px;border:1px solid #c3e6cb;">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>
        <main>
            <!-- Botón hamburguesa (fuera del <aside>) -->
            <input type="checkbox" id="menu-sidebar">
            <div class="contenedor-hamburger">
                <p>Filtrar</p>
                <label for="menu-sidebar" class="hamburger-icon-sidebar">☰</label>
            </div>    
            <section class="sidebar-content">               
                <!-- Aside lateral -->
                <aside class="sidebar">
                    <label for="menu-sidebar" class="close-btn">✖</label>
                    <div class="filtro-contenido">
                        <div class="filtro-precio">
                            <p class="text-precio">Filtrar por precio</p>
                            <form method="get" action="lista.php" style="display:flex;flex-direction:column;gap:8px;">
                                <label>Precio mínimo
                                    <input type="number" name="min_price" step="0.01" placeholder="0.00" value="<?php echo isset($min_price) && $min_price !== null ? htmlspecialchars($min_price) : ''; ?>">
                                </label>
                                <label>Precio máximo
                                    <input type="number" name="max_price" step="0.01" placeholder="0.00" value="<?php echo isset($max_price) && $max_price !== null ? htmlspecialchars($max_price) : ''; ?>">
                                </label>
                                <div style="display:flex;gap:8px;">
                                    <button type="submit" style="background:var(--color-secondary);color:#fff;border:none;padding:8px;border-radius:6px;">Filtrar</button>
                                    <a href="lista.php" style="align-self:center;color:var(--color-secondary);">Limpiar</a>
                                </div>
                            </form>
                        </div>
                        <div class="filtro-categoria">
                            <p class="text-categoria">Categoria de productos</p>
                            <p><a href="">Cupcake</a></p>
                            <p><a href="">Pasteles</a></p>
                            <p><a href="">Complentos</a></p>
                        </div>
                        <div class="contenido-pastel">
                            <p class="text-pastel">¿Necesitas algo mas personal?</p>
                            <p>También hacemos pasteles personalizados, ideales para cualquier ocasión especial. Solo cuéntanos tu idea y la haremos realidad.</p>
                            <img src="img_perzonalizado.jpeg" alt="">
                            <button class="boton-pastel">Vamos</button>
                        </div>
                    </div>                   
                </aside>
            </section>
            <!-- CONTENIDO PRODUCTO -->
            <section class="content">
                <p>Pasteles y postres artesanales para cada ocasión.</p>
                <h2>Nuestros Productos</h2>                
                <section class="products">
                    <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                        <div class="product-card">
                            <img src="<?php echo "../img_productos/".($row['img_route'] ?$row['img_route']:''); ?>" alt="Producto 1">
                            <h3><?php echo $row['nomb_producto']; ?></h3>
                            <p><?php echo $row['descripcion_producto']; ?></p>
                            <p><strong>$<?php echo number_format($row['precio_unitario'], 2); ?></strong></p>
                            <!-- Formulario para agregar al carrito -->
                            <form method="post" action="">
                                <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                                <input type="hidden" name="producto" value="<?php echo $row['nomb_producto']; ?>">
                                <input type="hidden" name="precio" value="<?php echo $row['precio_unitario']; ?>">                          
                                <button type="submit" name="agregar_carrito" class="agregar_carrito">Agregar al carrito</button>
                            </form>
                        </div>
                    <?php endwhile; ?>                                   
                </section>

                <!-- PAGINACIÓN (insertada dentro del contenido para visibilidad) -->
                <?php
                $total_pages = max(1, (int) ceil($total / $per_page));
                if ($total_pages > 1):
                    echo '<nav class="paginacion" aria-label="Paginación">';
                    // Base path actual (sin query string)
                    $base = strtok($_SERVER['REQUEST_URI'], '?');
                    // Mantener parámetros GET existentes
                    $params = $_GET;

                    // Enlace Anterior (solo mostrar si no estamos en la página 1)
                    if ($page > 1) {
                        $params['page'] = $page - 1;
                        $prev_link = $base . '?' . http_build_query($params);
                        echo '<a href="' . htmlspecialchars($prev_link) . '">&laquo; Anterior</a>';
                    }

                    // Rango de páginas (mostrar +/- 3 alrededor de la actual)
                    $start = max(1, $page - 3);
                    $end = min($total_pages, $page + 3);
                    for ($p = $start; $p <= $end; $p++) {
                        $params['page'] = $p;
                        $link = $base . '?' . http_build_query($params);
                        if ($p == $page) {
                            echo '<span class="active">' . $p . '</span>';
                        } else {
                            echo '<a href="' . htmlspecialchars($link) . '">' . $p . '</a>';
                        }
                    }

                    // Enlace Siguiente (solo mostrar si no estamos en la última página)
                    if ($page < $total_pages) {
                        $params['page'] = $page + 1;
                        $next_link = $base . '?' . http_build_query($params);
                        echo '<a href="' . htmlspecialchars($next_link) . '">Siguiente &raquo;</a>';
                    }

                    echo '</nav>';
                endif;
                ?>

            </section>
        </main>
        <div class="separador-section"></div>
        <!-- ========================================
                         FOOTER
         ======================================== -->
        <footer>
            <div class="footer-container">
                <section class="footer-main">                   
                    <div class="footer-item">                       
                        <div class="footer-libro-reclamaciones">
                            <a href="#home"><img src="img/img_footer/libro_reclamaciones.png" alt="logo_libro_reclamaciones"></a>
                        </div>
                    </div>
                    <div class="footer-item">
                        <div class="footer-contact">
                            <h3>Contacto</h3>
                            <p>Teléfono: 123-456-7890</p>
                            <p>Email: contacto@pasteleriabuenaventura.com</p>
                        </div>
                    </div>
                    <div class="footer-social">
                        <h3>Redes Sociales</h3>
                        <div class="footer-social-media">                         
                            <a href="#"><img src="img/img_footer/facebook.png" alt="logo_Facebook"></a>
                            <a href="#"><img src="img/img_footer/instagram.jpeg" alt="logo_Instagram"></a>
                            <a href="#"><img src="img/img_footer/twiter.png" alt="logo_Twitter"></a>
                        </div>
                    </div>
                </section>
                <section class="footer-copyright">                  
                    <div class="footer-metodos-pago">
                        <ul>
                            <li><img src="img/img_footer/Visa-Logo.jpg" alt="logo_Visa"></li>
                            <li><img src="img/img_footer/mastercard-logo.jpg" alt="logo_MasterCard"></li>
                            <li><img src="img/img_footer/paypal.png" alt="logo_PayPal"></li>
                        </ul>
                    </div>
                    <div class="footer-copyright-text">
                        <p>&copy; 2025 Pastelería Buenaventura. Todos los derechos reservados.</p>
                    </div>              
                </section>
            </div>
        </footer>
    </body>
</html>