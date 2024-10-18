<?php
session_start(); // Iniciamos la sesión

// Aquí va tu lógica para manejar el inicio de sesión

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    echo "<p>Has cerrado sesión exitosamente.</p>";
}

include_once 'config/conf.php';

$conexion = new Conexion();
$con = $conexion->Conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreUsuario = isset($_POST['nombre']) ? trim($_POST['nombre']) : ""; // Usamos el campo de correo
    $passwordUsuario = isset($_POST['password']) ? trim($_POST['password']) : ""; // Cambiamos a password

    $consulta = "SELECT u.nombre, u.password, r.nombre AS rol_nombre 
             FROM usuarios u 
             JOIN roles r ON u.id_rol = r.id_rol 
             WHERE u.nombre = :nombre";

    $stmt = $con->prepare($consulta);
    $stmt->bindParam(':nombre', $nombreUsuario);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos la contraseña utilizando password_verify
        if (password_verify($passwordUsuario, $usuario['password'])) {
            $_SESSION['usuarios'] = $usuario['nombre']; // Nombre del usuario
            $_SESSION['roles'] = $usuario['rol_nombre']; // Rol del usuario

            // Redirigimos según el rol
            if ($_SESSION['roles'] == 'Admin') {
                header('Location: routers/usuariosRouter.php');
            } elseif ($_SESSION['roles'] == 'Profesor') {
                header('Location: routers/estudianteMateriaRouter.php');
            } else {
                header('Location: views/auth/accessDenied.php');
            }
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    <title>Iniciar Sesión</title>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="mb-4 text-center">Iniciar Sesión</h2>
        <form action="index.php" method="POST">
            <div class="form-group mb-3">
                <label for="nombre">Usuario</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>
        <?php
        // Mostramos un mensaje de error si las credenciales son incorrectas
        if (isset($error)) {
            echo '<div class="alert alert-danger mt-3">' . htmlspecialchars($error) . '</div>';
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9K2rMyI9ibW3VVNQ5g5j2Q6w0AfK7zE3OfIuM2w4iA26efSHwUq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl0J5Fs7Z1W5n5B6O0x6V6w5rY7I+LBk+xLTM8fbJMT" crossorigin="anonymous"></script>
</body>

</html>