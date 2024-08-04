<?php
// Forzar HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: " . $redirect_url);
    exit();
}

// Configuraciones de seguridad
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");

session_start();
$usuario_o_correo = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$contrasena = $_POST['contrasena'] ?? '';

$conn = new mysqli("sql309.ezyro.com", "ezyro_37022032", "46540f", "ezyro_37022032_mnd",3306);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM usuarios WHERE usuario = ? OR correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario_o_correo, $usuario_o_correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    
    if (password_verify($contrasena, $fila['contrasena'])) {
        $_SESSION['usuario'] = $fila['usuario'];
        // Regenerar ID de sesión para prevenir ataques de fijación de sesión
        session_regenerate_id(true);
        $stmt->close();
        $conn->close();
        header('Location: https://' . $_SERVER['HTTP_HOST'] . '/informacion_siembras.php');
        exit();
    } else {
        $error = "Error al iniciar sesión. Contraseña incorrecta.";
    }
} else {
    $error = "Error al iniciar sesión. Usuario no encontrado.";
}

$stmt->close();
$conn->close();

if (isset($error)) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . '/login.php?error=' . urlencode($error));
    exit();
}
?>