<?php
// recibir_datos_iot.php

// Configuraciones de seguridad
ini_set('display_errors', 0);
error_reporting(E_ALL);
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");

// Conexión a la base de datos
$conn = new mysqli("sql309.ezyro.com", "ezyro_37022032", "46540f", "ezyro_37022032_mnd",3306);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del dispositivo IoT
$temperatura = filter_input(INPUT_POST, 'temperatura', FILTER_VALIDATE_FLOAT);
$humedad = filter_input(INPUT_POST, 'humedad', FILTER_VALIDATE_FLOAT);
$humedad_suelo = filter_input(INPUT_POST, 'humedad_suelo', FILTER_VALIDATE_FLOAT);
$id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);

// Validar los datos
if ($temperatura === false || $humedad === false || $humedad_suelo === false || $id_usuario === false) {
    die("Datos inválidos");
}


// Insertar datos en la base de datos
$sql = "INSERT INTO datos_dispositivo (id_usuario, temperatura, humedad, humedad_suelo, fecha_hora) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iddd", $id_usuario, $temperatura, $humedad, $humedad_suelo);

if ($stmt->execute()) {
    echo "Datos insertados correctamente";
} else {
    echo "Error al insertar datos: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>