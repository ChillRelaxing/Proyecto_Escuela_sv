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
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/usuarioResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body>
    <br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Eliminar Usuario</h2><br>
            <p>¿Estás seguro que deseas eliminar al usuario: <br> <strong><?= htmlspecialchars($this->usuario->nombre . ' ' . $this->usuario->apellido); ?></strong>?</p>
            <form action="../routers/usuariosRouter.php?action=delete" method="POST">
                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($this->usuario->id_usuario); ?>">

                <div class="d-flex justify-content-center">
                    <button type="submit" class=" btn-danger btn-sm mx-2">Sí, eliminar</button>
                    <a href="../routers/usuariosRouter.php" class=" btn-secondary btn-sm ">No, volver</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
