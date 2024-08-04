<?php
ob_start();
session_start();
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

$nuevo_usuario = filter_input(INPUT_POST, 'nuevo_usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nueva_contrasena = $_POST['nueva_contraseña'] ?? '';
$nuevo_correo = filter_input(INPUT_POST, 'nuevo_correo', FILTER_SANITIZE_EMAIL);

$error_contrasena = '';
$error_usuario_existente = '';
$error_correo_existente = '';
$error_correo_vacio = '';

// Validar fortaleza de contraseña
$patron_contrasena = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/';
if (!preg_match($patron_contrasena, $nueva_contrasena)) {
    $error_contrasena = 'La contraseña no cumple con los requisitos.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$error_contrasena) {
$conn = new mysqli("sql309.ezyro.com", "ezyro_37022032", "46540f", "ezyro_37022032_mnd",3306);
    if ($conn->connect_error) {
        error_log("Error de conexión: " . $conn->connect_error);
        die("Error de conexión. Por favor, inténtelo más tarde.");
    }

    // Verificar si el nombre de usuario ya existe
    $sql_check_usuario = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt_check_usuario = $conn->prepare($sql_check_usuario);
    $stmt_check_usuario->bind_param("s", $nuevo_usuario);
    $stmt_check_usuario->execute();
    $resultado_check_usuario = $stmt_check_usuario->get_result();

    if ($resultado_check_usuario->num_rows > 0) {
        $error_usuario_existente = 'El nombre de usuario ya está registrado. Por favor, elige otro.';
    }

    // Verificar si el correo electrónico ya existe
    $sql_check_correo = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt_check_correo = $conn->prepare($sql_check_correo);
    $stmt_check_correo->bind_param("s", $nuevo_correo);
    $stmt_check_correo->execute();
    $resultado_check_correo = $stmt_check_correo->get_result();

    if ($resultado_check_correo->num_rows > 0) {
        $error_correo_existente = 'El correo electrónico ya está registrado. Por favor, elige otro.';
    }

    if (empty($nuevo_correo)) {
        $error_correo_vacio = 'El correo electrónico no puede estar vacío.';
    }

    if (!$error_usuario_existente && !$error_correo_existente && !$error_correo_vacio) {
        // Cifrar la contraseña
        $nueva_contrasena_cifrada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (usuario, contrasena, correo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nuevo_usuario, $nueva_contrasena_cifrada, $nuevo_correo);

        if ($stmt->execute()) {
            // Guardar usuario, correo y contraseña en el archivo usuarios.txt
            guardarUsuarioEnArchivo($nuevo_correo, $nuevo_usuario, $nueva_contrasena);

            header('Location: usuario_registrado.php');
            exit();
        } else {
            error_log("Error al registrar el usuario: " . $conn->error);
            echo "Error al registrar el usuario. Por favor, inténtelo más tarde.";
        }
        $stmt->close();
    }
    $stmt_check_usuario->close();
    $stmt_check_correo->close();
    $conn->close();
}

// Establecer cabeceras de seguridad
header('X-XSS-Protection: 1; mode=block');
header('X-Frame-Options: SAMEORIGIN');
header('Content-Security-Policy: default-src \'self\'');

// Función para guardar usuario, correo y contraseña en el archivo usuarios.txt
function guardarUsuarioEnArchivo($correo, $usuario, $contrasena) {
    $archivo = 'usuarios.txt';
    $datos = $correo . ' - ' . $usuario . ' - ' . $contrasena . PHP_EOL;
    $fileHandler = fopen($archivo, 'a') or die("No se puede abrir el archivo");
    fwrite($fileHandler, $datos);
    fclose($fileHandler);
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - DataSpectrum</title>
    <link rel="stylesheet" href="nuevoEstiloMulticolor.css">
</head>
<body>
    <div class="main-container">
        <div class="regresar-container">
    <a href="login.php" class="btn-secondary regresar">Regresar</a>
</div>


        <div class="title-container1">
        <h2>Crear Cuenta</h2>
        <form action="registrar_usuario.php" method="post">
            </div>
            
            <div class="login-container">
            <div class="input-container">
                <input type="text" name="nuevo_usuario" required>
                <label>Nuevo usuario</label>
            </div>
            <div class="input-container">
                <input type="email" name="nuevo_correo" required>
                <label>Correo electrónico</label>
            </div>
            <div class="input-container">
                <input type="password" name="nueva_contraseña" required>
                <label>Nueva contraseña</label>
            </div>
            <p class="requisitos-contrasena">La contraseña debe tener al menos 8 caracteres, aquí incluidos una mayúscula, una minúscula, un número y un carácter especial.</p>
            <button type="submit" class="btn">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Crear cuenta
            </button>
        </form>
    </div>
</body>
</html>
