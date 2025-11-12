<?php
session_start();

// Ejemplo: guardar el username después de login
if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
}
    require_once '../app/models/conexion.php';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if(isset($_POST['Login'])){  
        $sql = "SELECT * FROM usuario WHERE username='$username' AND password='$password'";
        $resultado = mysqli_query($cn, $sql);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Sistema de gestion de pasteleria</h1>
    </header>
    <section class="container-login">
        <div class="login">
            <div class="login-main">
                <h2>Login</h2>
                <form action="" method="post" class="form-login">
                    <div class="items-login">
                        <label for="username" class="label-login">Username</label>
                        <i class='bx  bx-user'  ></i>
                    </div>                   
                    <input type="text" id="username" name="username" class="input-login" value="<?php echo $username; ?>" required>
                    <div class="items-login">
                        <label for="password" class="label-login">Password</label>
                        <i class='bx bx-lock'></i> 
                    </div>
                    <input type="password" id="password" name="password" class="input-login" value="<?php echo $password; ?>" required>
                    <?php if(isset($_POST['Login'])): ?>
                        <div class="resultado">
                            <?php if(mysqli_num_rows($resultado) > 0): ?>
                                <p id="login-success">Login successful!</p>
                                <?php
                                    header("Location: ../app/views/pages/principal.php");
                                ?>
                            <?php else: ?>
                                <p id="login-error">Invalid username or password.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <button type="submit" name="Login" class="btn-login">Login</button>
                </form>
            </div>            
        </div>
    </section>
    <footer>
        <p>&copy; 2023 Pasteleria. All rights reserved.</p>
    </footer>    
</body>
</html>