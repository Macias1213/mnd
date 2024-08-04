<!DOCTYPE html>
<html>
<head>
    <title>DataSpectrum</title>
    <link rel="stylesheet" href="nuevoEstiloMulticolor.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-container">
        <h1>Monitoreo en la nube de la data entregada por un dispositivo de IoT frente a los cultivos de pancoger</h1>
    </div>
</body>

<body>
    <div class="main-container1">
        <p>Aplicativo para visualizar las condiciones del cultivo en sitio</p></p>
        <a href="login.php"><button class="btn-primary">Iniciar sesión</button></a>
    </div>
</body>

</html>


<style>
 
body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background: linear-gradient(-45deg, #4B0082, #663399, #8E4585, #BA55D3);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    display: flex;
    flex-direction: column; /* Cambiar a dirección de columna */
    justify-content: center;
    align-items: center;
}

@keyframes gradientBG {
    0% {background-position: 0% 50%;}
    50% {background-position: 100% 50%;}
    100% {background-position: 0% 50%;}
}

.main-container {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    padding: 30px;
    box-shadow: 0 15px 25px rgba(0,0,0,0.2);
    max-width: 600px;
    text-align: center;
    width: 100%;
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px; /* Agregar margen inferior */
}

.main-container1 {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 30px;
    text-align: center;
    padding: 40px;
    box-shadow: 0 15px 25px rgba(0,0,0,0.2);
    max-width: 600px;
    width: 100%;
    color: #fff;
}

.btn-primary {
    background: rgba(255,255,255,0.1);
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.5s;
    text-transform: uppercase;
    letter-spacing: 4px;
    left: 50%;
    margin-top: 50px;
}

.btn-primary:hover {
    background: rgba(255,255,255,0.2);
    box-shadow: 0 0 10px rgba(255,255,255,0.2);
}