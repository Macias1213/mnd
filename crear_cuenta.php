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

        <style>
            .container {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 10px;
                padding: 40px;
                backdrop-filter: blur(10px);
                box-shadow: 0 15px 25px rgba(0,0,0,0.2);
                max-width: 800px;
                width: 100%;
            }

            .btn {
                background: rgba(255,255,255,0.1);
                border: none;
                padding: 12px 20px;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.5s;
                text-transform: uppercase;
                letter-spacing: 4px;
                left: 50%;
                transform: translateX(-50%);
                margin-top: 10px;
            }

            .btn:hover {
                background: rgba(255,255,255,0.2);
                box-shadow: 0 0 10px rgba(255,255,255,0.2);
            }

            body {
                color: black;
            }
        </style>