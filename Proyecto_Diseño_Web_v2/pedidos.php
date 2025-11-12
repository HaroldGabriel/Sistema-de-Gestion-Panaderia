<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pastelería Buenaventura ofrece tortas personalizadas, postres artesanales y cupcakes únicos en Lima. Realiza tu pedido online y disfruta del sabor de la tradición.">
    <meta name="keywords" content="pastelería, tortas, postres, cupcakes, dulces, repostería artesanal, tortas personalizadas, Pastelería Buenaventura">
    <meta name="author" content="Harold Barrientos - Diego Buenaventura" />
    <meta name="robots" content="index, follow" />
    <!-- Open Graph (Facebook, WhatsApp, etc.) -->
    <meta property="og:title" content="Pastelería Buenaventura | Repostería artesanal con amor" />
    <meta property="og:description" content="Tortas, pasteles y postres artesanales para cada ocasión. Descubre nuestros sabores únicos en Pastelería Buenaventura." />
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://haroldgabriel.github.io/web-design" />
    <meta property="og:image" content="https://haroldgabriel.github.io/web-design/img/logo_pasteleria.jpeg" />
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Pastelería Buenaventura | Repostería artesanal con amor" />
    <meta name="twitter:description" content="Tortas, pasteles y postres artesanales para cada ocasión. Descubre nuestros sabores únicos en Pastelería Buenaventura." />
    <meta name="twitter:image" content="https://haroldgabriel.github.io/web-design/img/logo_pasteleria.jpeg" />
    <!-- Favicon e icono -->
    <link rel="icon" href="img/logo_original.png" type="image/x-icon">
    <link rel="canonical" href="https://haroldgabriel.github.io/web-design" />
    <link rel="stylesheet" href="pedidos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <title>pasteleria buenaventura</title>
</head>
    <body>
        <!-- ========================================
                CODIGO PHP
        ======================================== -->
        <?php
            session_start(); //Inicia la sesión o la reanuda
            require_once 'app/models/conexion.php';
            $usuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
            $registrar = isset($_GET['registrar']); 

            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }
            $query_pago = "SELECT DISTINCT id_pago, tipo_pago FROM forma_pago";
            $result_pago = mysqli_query($cn, $query_pago);
            //var_dump($_SESSION['carrito']);
        ?>
        <!-- ========================================
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
        <!-- ========================================
                 CONTENIDO PRINCIPAL
        ======================================== -->
        <main>
            <?php if ($usuario === ""): ?>
                <?php if($registrar): ?>
                    <section class="register-content">
                        <div class="container">
                            <h2>Registrar Usuario</h2>
                            <form action="app/views/includes/procesar_registro.php" method="post">
                                <input type="text" name="NOMB_CLI" placeholder="Nombre" required>
                                <input type="text" name="APE_PAT" placeholder="Apellido Paterno" required>
                                <input type="text" name="APE_MAT" placeholder="Apellido Materno" required>
                                <input type="text" name="DNI" placeholder="DNI" required>
                                <input type="password" name="CLAVE" placeholder="Contraseña" required>
                                <input type="tel" name="CELULAR" placeholder="Celular" required>
                                <input type="email" name="EMAIL" placeholder="Correo electrónico" required>
                                <button type="submit">Registrar</button>                         
                            </form>
                            <a href="pedidos.php">Ya tengo cuenta</a>
                        </div>
                    </section>
                <?php else: ?>
                    <section class="register-content">
                        <div class="container">
                            <div class="logo">
                                <img src="img/logo_original.png" alt="Logo">
                            </div>
                            <h2>Iniciar Sesión</h2>
                            <form action="app/views/includes/procesar_login.php" method="post">
                                <input type="email" name="EMAIL" placeholder="Correo electrónico" required>
                                <input type="password" name="CLAVE" placeholder="Contraseña" required>
                                <button type="submit">Ingresar</button>                         
                            </form>
                            <a href="?registrar=1">Registrar</a>                   
                        </div>
                    </section>
                <?php endif;?>
            <?php else: ?>
                <section class="productos-main">
                    <h3>Carrito de <?php echo $usuario?></h3>
                    <?php if (!empty($_SESSION['carrito'])): ?>
                        <table>
                            <tr>
                                <th>Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                            <?php $total = 0; ?>
                            <?php foreach ($_SESSION['carrito'] as $id_producto => $item): ?>
                                <?php 
                                    $subtotal = $item['precio'] * $item['cantidad'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td><?= $item['producto'] ?></td>
                                    <td>S/. <?= number_format($item['precio'], 2) ?></td>
                                    <td><?= $item['cantidad'] ?></td>
                                    <td>S/. <?= number_format($subtotal, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" style="text-align:right; font-weight:bold;">Total:</td>
                                <td>S/. <?= number_format($total, 2) ?></td>
                            </tr>
                        </table>
                        <form action="" method="post">
                            <label for="tipo_doc_venta">Tipo de documento de venta:</label>
                            <select name="tipo_doc_venta" id="tipo_doc_venta" required>
                                <option value="boleta">Boleta</option>
                                <option value="factura">Factura</option>
                            </select>
                            <br>
                            <input type="hidden" name="id_usuario" id="id_usuario" value="U001">
                            <input type="hidden" name="sujeto_igv" id="sujeto_igv" value="Gravado">
                            <br>
                            <label for="tipo_pago">Tipo de pago:</label>
                            <select name="id_pago" id="id_pago" required>
                                <?php while ($row_pago = mysqli_fetch_assoc($result_pago)): ?>
                                    <option value="<?= $row_pago['id_pago'] ?>"><?= htmlspecialchars($row_pago['tipo_pago']) ?></option>
                                <?php endwhile; ?>
                            </select>
                            <br>
                            <button class="btn" type="submit" name="btn_pagar">Pagar</button>
                        </form>                      
                    <?php else: ?>
                        <p>Tu carrito está vacío 🛒</p>
                    <?php endif; ?>
                    <br>
                    <form action="app/views/includes/logout.php" method="post">
                        <button type="submit" class="btn_logout">Cerrar sesión</button>
                    </form>                  
                </section>
                <!-- ========================================
                        LOGICA DE PAGO
                ======================================== -->
                <?php
                    if(isset($_POST['btn_pagar'])){
                        $id_cliente = $_SESSION['id_cliente'];
                        $tipo_doc_venta = $_POST['tipo_doc_venta'];
                        $id_usuario = $_POST['id_usuario'];
                        $id_pago = $_POST['id_pago'];
                        $sujeto_igv = isset($_POST['sujeto_igv']) ? $_POST['sujeto_igv'] : 'Gravado';
                        $result = mysqli_query($cn, "SELECT MAX(id_doc_venta) AS ultimo FROM docventa");
                        $fila = mysqli_fetch_assoc($result);
                        $ultimo = $fila['ultimo'];
                        // Paso 2: Generar nuevo ID
                        if ($ultimo) {
                            // Paso 2: Extraer el número después de "DV"
                            $numero = (int)substr($ultimo, 2); // extrae "0000013" => 13
                            $nuevo_num = $numero + 1;
                        } else {
                            // Si no hay registros, empieza en 1
                            $nuevo_num = 1;
                        }
                        $igv = $total * 0.18;
                        $subtotal1 = $total - $igv;

                        $nuevo_id = "DV" . str_pad($nuevo_num, 7, "0", STR_PAD_LEFT);
                        $sql = "INSERT INTO docventa (id_doc_venta, id_cliente, tipo_doc_venta, id_usuario, id_pago, sujeto_igv, igv, subtotal, total) VALUES ('$nuevo_id', '$id_cliente', '$tipo_doc_venta', '$id_usuario', '$id_pago', '$sujeto_igv', '$igv', '$subtotal1', '$total')";
                        mysqli_query($cn, $sql);

                        foreach ($_SESSION['carrito'] as $id_producto => $item) {
                            $result_detalle = mysqli_query($cn, "SELECT MAX(id_det_doc_venta) AS ultimo FROM detdocventa");
                            $fila_detalle = mysqli_fetch_assoc($result_detalle);
                            $ultimo_detalle = $fila_detalle['ultimo'];
                            // Paso 2: Generar nuevo ID
                            if ($ultimo_detalle) {
                                // Paso 2: Extraer el número después de "DV"
                                $numero_detalle = (int)substr($ultimo_detalle, 2); // extrae "0000013" => 13
                                $nuevo_num_detalle = $numero_detalle + 1;
                            } else {
                                // Si no hay registros, empieza en 1
                                $nuevo_num_detalle = 1;
                            }
                            $nuevo_id_detalle = "DT" . str_pad($nuevo_num_detalle, 7, "0", STR_PAD_LEFT);
                            $producto = mysqli_real_escape_string($cn, $item['producto']);
                            $precio = $item['precio'];
                            $cantidad = $item['cantidad'];
                            $total = $precio * $cantidad;
                            $igv_detalle = $total * 0.18;
                            $subtotal_detalle = $total - $igv_detalle;
                            
                            $sin_igv_detalle = $total - $igv_detalle;
                            $con_igv_detalle = $total;

                            $sql_detalle = "INSERT INTO detdocventa(id_det_doc_venta,id_doc_venta,id_producto, afecto_igv,cantidad,precio_unitario,subtotal,total) 
                                            VALUES ('$nuevo_id_detalle', '$nuevo_id','$id_producto','S',$cantidad,$precio,$subtotal_detalle,$total)";
                            mysqli_query($cn, $sql_detalle);
                        }
                        unset($_SESSION['carrito']);
                        header("Location: pedidos.php");
                        echo "<script>alert('Compra realizada con éxito ✅'); window.location='pedidos.php';</script>";
                    }
                ?>
            <?php endif;?>
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