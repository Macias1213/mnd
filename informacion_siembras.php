<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
$usuario = $_SESSION['usuario'];
$conn = new mysqli("sql309.ezyro.com", "ezyro_37022032", "46540f", "ezyro_37022032_mnd",3306);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Obtener el id del usuario
$sql_usuario = "SELECT id FROM usuarios WHERE usuario = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $usuario);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();
if ($resultado_usuario->num_rows > 0) {
    $fila_usuario = $resultado_usuario->fetch_assoc();
    $id_usuario = $fila_usuario['id'];
    // Obtener estadísticas
    $sql_stats = "SELECT
        AVG(temperatura) as temp_actual,
        AVG(humedad) as humedad_actual,
        AVG(humedad_suelo) as humedad_suelo_actual
        FROM datos_dispositivo
        WHERE id_usuario = ?";
    $stmt_stats = $conn->prepare($sql_stats);
    $stmt_stats->bind_param("i", $id_usuario);
    $stmt_stats->execute();
    $result_stats = $stmt_stats->get_result();
    $stats = $result_stats->fetch_assoc();
    
    // Recupera los datos de la base de datos
    $sql_datos = "SELECT fecha_hora, temperatura, humedad, humedad_suelo
        FROM datos_dispositivo
        WHERE id_usuario = ?
        ORDER BY fecha_hora DESC LIMIT 10";
    $stmt_datos = $conn->prepare($sql_datos);
    $stmt_datos->bind_param("i", $id_usuario);
    $stmt_datos->execute();
    $result_datos = $stmt_datos->get_result();
    $etiquetas_tiempo = [];
    $datos_temperatura = [];
    $datos_humedad = [];
    $datos_humedad_suelo = [];
    if ($result_datos->num_rows > 0) {
        while ($row = $result_datos->fetch_assoc()) {
            $etiquetas_tiempo[] = $row["fecha_hora"];
            $datos_temperatura[] = $row["temperatura"];
            $datos_humedad[] = $row["humedad"];
            $datos_humedad_suelo[] = $row["humedad_suelo"];
        }
    }
    
    $tiene_datos = !empty($etiquetas_tiempo);
} else {
    session_destroy();
    header('Location: login.php?error=' . urlencode('Error al recuperar la información del usuario.'));
    exit();
}
$stmt_usuario->close();
$stmt_stats->close();
$stmt_datos->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de tus siembras</title>
    <link rel="stylesheet" href="nuevoEstiloMulticolor.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body, html {
            height: auto;
            min-height: 100%;
            overflow-y: auto;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 40px;
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
            max-width: 800px;
            width: 90%;
            margin: 20px auto;
            color: white;
        }
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stat-box {
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 5px;
            width: calc(33.33% - 20px);
            margin-bottom: 20px;
        }
        .color-controls {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .color-control {
            display: flex;
            align-items: center;
        }
        .color-control label {
            margin-right: 10px;
        }
        #grafico-container {
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }
        .btn {
            background: rgba(255,255,255,0.1);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.5s;
            text-transform: uppercase;
            letter-spacing: 4px;
            display: inline-block;
            text-decoration: none;
        }
        .btn:hover {
            background: rgba(255,255,255,0.2);
            box-shadow: 0 0 10px rgba(255,255,255,0.2);
        }
        .no-data {
            text-align: center;
            margin-top: 20px;
            font-style: italic;
        }
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }
            .stat-box {
                width: 100%;
            }
            h1 {
                font-size: 24px;
            }
            h2 {
                font-size: 20px;
            }
            .color-controls {
                flex-direction: column;
                align-items: flex-start;
            }
            .color-control {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Información de sus siembras</h1>
        <p>Bienvenido <?php echo htmlspecialchars($usuario); ?>.</p>
        
        <?php if ($tiene_datos): ?>
            <h2>Estadísticas</h2>
            <div class="stats-container">
                <div class="stat-box">
                    <h3>Temperatura</h3>
                    <p>Actual: <?php echo number_format($stats['temp_actual'], 1); ?>°C</p>
                </div>
                <div class="stat-box">
                    <h3>Humedad</h3>
                    <p>Actual: <?php echo number_format($stats['humedad_actual'], 1); ?>%</p>
                </div>
                <div class="stat-box">
                    <h3>Humedad del Suelo</h3>
                    <p>Actual: <?php echo number_format($stats['humedad_suelo_actual'], 1); ?>%</p>
                </div>
            </div>

            <div class="color-controls">
                <div class="color-control">
                    <label for="tempColor">Color Temperatura:</label>
                    <input type="color" id="tempColor" value="#10ff1c">
                </div>
                <div class="color-control">
                    <label for="humedadColor">Color Humedad:</label>
                    <input type="color" id="humedadColor" value="#10ff1c">
                </div>
                <div class="color-control">
                    <label for="humedadSueloColor">Color Humedad del Suelo:</label>
                    <input type="color" id="humedadSueloColor" value="#10ff1c">
                </div>
            </div>

            <div id="grafico-container">
                <canvas id="grafico"></canvas>
            </div>
        <?php else: ?>
            <p class="no-data">No hay datos disponibles para mostrar.</p>
        <?php endif; ?>

        <a href="logout.php" class="btn">Cerrar sesión</a>
    </div>

    <?php if ($tiene_datos): ?>
    <script>
    var ctx = document.getElementById('grafico').getContext('2d');
    var tempColorInput = document.getElementById('tempColor');
    var humedadColorInput = document.getElementById('humedadColor');
    var humedadSueloColorInput = document.getElementById('humedadSueloColor');

    function updateChart() {
        if (window.myChart) {
            window.myChart.destroy();
        }
        var canvas = document.getElementById('grafico');
        canvas.style.width = '100%';
        canvas.style.height = '400px';
        window.myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_reverse($etiquetas_tiempo)); ?>,
                datasets: [{
                    label: 'Temperatura',
                    data: <?php echo json_encode(array_reverse($datos_temperatura)); ?>,
                    backgroundColor: tempColorInput.value,
                    borderColor: tempColorInput.value,
                    borderWidth: 1
                }, {
                    label: 'Humedad',
                    data: <?php echo json_encode(array_reverse($datos_humedad)); ?>,
                    backgroundColor: humedadColorInput.value,
                    borderColor: humedadColorInput.value,
                    borderWidth: 1
                }, {
                    label: 'Humedad del Suelo',
                    data: <?php echo json_encode(array_reverse($datos_humedad_suelo)); ?>,
                    backgroundColor: humedadSueloColorInput.value,
                    borderColor: humedadSueloColorInput.value,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'category',
                        title: {
                            display: true,
                            text: 'Fecha y Hora'
                        },
                        stacked: false
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Valor'
                        },
                        stacked: false
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Datos del Dispositivo'
                    }
                },
                barPercentage: 0.8,
                categoryPercentage: 0.9
            }
        });
    }

    tempColorInput.addEventListener('change', updateChart);
    humedadColorInput.addEventListener('change', updateChart);
    humedadSueloColorInput.addEventListener('change', updateChart);

    updateChart();
    </script>
    <?php endif; ?>
</body>
</html>