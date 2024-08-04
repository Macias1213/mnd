<!DOCTYPE html>
<html>
<head>
    <title>Contraseña cambiada - DataSpectrum</title>
    <link rel="stylesheet" href="nuevoEstiloMulticolor.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&display=swap" rel="stylesheet">
    <style>
        .password-changed-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 40px;
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            color: white;
            text-align: center;
        }

        .password-changed-container h1 {
            margin-top: 0;
        }

        .password-changed-container p {
            margin-bottom: 20px;
        }

        .password-changed-container .btn {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.5s;
            text-transform: uppercase;
            letter-spacing: 4px;
            text-decoration: none;
        }

        .password-changed-container .btn:hover {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="password-changed-container">
        <h1>Contraseña cambiada</h1>
        <p>Tu contraseña ha sido actualizada exitosamente. Ahora puedes iniciar sesión con tu nueva contraseña.</p>
        <a href="login.php" class="btn">Iniciar sesión</a>
    </div>
</body>
</html>