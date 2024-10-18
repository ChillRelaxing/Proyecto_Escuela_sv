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
    <title>Eliminar Rol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/rolResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Confirmar Eliminación</h2><br>
            <p>¿Está seguro que desea eliminar este rol: <strong><?= htmlspecialchars($this->rol->nombre . ' ' ); ?></strong>?</p>

            <form action="../routers/rolesRouter.php?action=delete" method="POST">
                <input type="hidden" name="id_rol" value="<?= $this->rol->id_rol ?>">

                <div class="d-flex justify-content-center">
                    <button type="submit" class=" btn-danger btn-sm mx-2">Sí, eliminar</button>
                    <a href="../routers/rolesRouter.php" class=" btn-secondary btn-sm">No, volver</a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>