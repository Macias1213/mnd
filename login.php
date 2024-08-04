<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: informacion_siembras.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión - DataSpectrum</title>
    <link rel="stylesheet" href="nuevoEstiloMulticolor.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <div class="regresar-container">
            <a href="index.php" class="btn-secondary regresar">Regresar</a>
        </div>
        <div class="title-container">
            <h2>Iniciar Sesión</h2>
        </div>
        <div class="login-form-container">
            <?php
            if (isset($_GET['error'])) {
                echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
            }
            ?>
            <form action="procesar_login.php" method="post">
                <div class="input-container1">
                    <input type="text" name="usuario" required>
                    <label>Usuario o Correo</label>
                </div>
                <div class="input-container1">
                    <input type="password" name="contrasena" required>
                    <label>Contraseña</label>
                </div>
                <button type="submit" class="btn">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Ingresar
                </button>
                <div class="login-actions">
                    <button type="button" class="crear-cuenta-btn" onclick="location.href='crear_cuenta.php';">Crear cuenta</button>
                    <button type="button" class="olvide-contrasena-btn" onclick="location.href='recuperar_contrasena.php';">Olvidé mi contraseña</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>