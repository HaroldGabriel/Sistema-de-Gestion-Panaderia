<?php
    session_start();
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");
    if (!isset($_SESSION['username'])) {
        header("Location: /proyecto_final/proyecto_tasayco/public/");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../public/css/principal.css">
    <title>Document</title>
</head>
<body>
    
    <div style="text-align:right; margin: 12px 32px 0 0; font-weight:600; color:#6c63ff;">
        Usuario: <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Invitado'; ?>
    </div>
    <!----------------------------------------
                    HEADER
    ----------------------------------------->
    <header>
        <div class="main-header">
            <div class="logo">
                <div class="contain-logo">
                    <picture class="logo-img">
                        <source srcset="../../../public/img/img_login/logo.webp" type="image/webp">
                        <source srcset="../../../public/img/img_login/logo.jpg" type="image/jpg">
                        <img src="../../../public/img/img_login/logo.jpg" alt="logo de la empresa">
                    </picture>
                </div>
            </div>
            <div class="barra-busqueda">
                <input type="text" placeholder="Buscar...">
                <button type="submit" class="btn-search"><i class='bx bx-search'></i></button>
            </div>
        </div>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    <main>
        <section class="container">
            <aside class="menu-aside">
                <div class="main-menu-aside">
                    <form action="" method="get" class="menu-form">
                        <input type="submit" class="menu-item" value="dashboard" name="action">
                        <input type="submit" class="menu-item" value="productos" name="action">
                        <input type="submit" class="menu-item" value="ventas" name="action">
                        <input type="submit" class="menu-item" value="reportes" name="action">
                        <input type="submit" class="menu-item" value="usuarios" name="action">
                        <input type="submit" class="menu-item" value="clientes" name="action">
                    </form>

                    <div class="logout-aside" style="margin-top: 24px; text-align: center;">
                        <form action="../includes/logout.php" method="post">
                            <button type="submit" class="btn-logout">Cerrar sesión</button>
                        </form>
                    </div>

                </div>
            </aside>
            
            <div class="content-page">
                <div class="main-content-page">
                    <?php
                        if (isset($_GET['action'])) {
                            switch ($_GET['action']){
                                case 'dashboard':
                                    include_once '../pages/dashboard.php';
                                    break;

                                case 'productos':
                                    include_once '../pages/productos.php';
                                    break;

                                case 'ventas':
                                    include_once '../pages/ventas.php';
                                    break;

                                case 'reportes':
                                    include_once '../pages/reportes.php';
                                    break;
                                
                                case 'usuarios':
                                    include_once '../pages/usuarios.php';
                                    break;

                                case 'clientes':
                                    include_once '../pages/cliente.php';
                                    break;
                                //MANTENIMIENTO DETALLE VENTA
                                case 'Mostrar Detalle':
                                    include_once '../pages/mantenimiento_detalle_venta.php';
                                    break;
                                //MANTENIMIENTO PRODUCTO
                                case 'Crear Producto':
                                    include_once '../pages/mantenimiento_producto.php';
                                    break;
                                case 'Guardar Producto':
                                    include_once '../pages/mantenimiento_producto.php';
                                    break;
                                case 'Editar Producto':
                                    include_once '../pages/mantenimiento_producto.php';
                                    break;
                                //MANTENIMIENTO USUARIO
                                case 'Crear Usuario':
                                    include_once '../pages/mantenimiento_usuario.php';
                                    break;
                                case 'Guardar Usuario':
                                    include_once '../pages/mantenimiento_usuario.php';
                                    break;
                                case 'Editar Usuario':
                                    include_once '../pages/mantenimiento_usuario.php';
                                    break;
                                //MANTENIMIENTO CLIENTE
                                case 'Crear Cliente':
                                    include_once '../pages/mantenimiento_cliente.php';
                                    break;
                                case 'Guardar Cliente':
                                    include_once '../pages/mantenimiento_cliente.php';
                                    break;
                                case 'Editar Cliente':
                                    include_once '../pages/mantenimiento_cliente.php';
                                    break;

                                default:
                                    echo "<img src='../../../public/img/img_login/img_login.jpg' alt='' class='img-principal'>";
                                    break;
                            }
                        }elseif (isset($_GET['page']) && $_GET['page'] === 'reportes'){
                            include_once '../pages/reportes.php'; 
                        }
                        else {
                            echo "<img src='../../../public/img/img_login/img_login.jpg' alt='' class='img-principal'>";
                        }

                        if (isset($_GET['page'])) {
                            include_once '../pages/reportes.php';
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div>footer</div>
    </footer>
</body>
</html>