<?php
session_start();
ob_start();

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuarios']) || empty($_SESSION['usuarios'])) {
    header('Location: ../../index.php');
    exit;
}

// Verificamos el rol del usuario
if ($_SESSION['roles'] != 'Admin') {
    echo "Acceso denegado";  // Mensaje de depuración antes de redireccionar
    header('Location: ../views/auth/accessDenied.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/usuarioResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body class="bg-light">
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Crear Usuario</h2>
            <form action="../routers/usuariosRouter.php?action=store" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="id_rol">Rol:</label>
                    <select name="id_rol" id="id_rol" class="form-control" required>
                        <option value="">Seleccione el rol...</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?= $rol['id_rol'] ?>"><?= $rol['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div><br><br>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn-primary btn-sm mx-2">Guardar Usuario</button>
                    <a href="../routers/usuariosRouter.php" class=" btn-secondary btn-sm">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
