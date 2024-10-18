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
    <title>Actualizar Rol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/rolResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Actualizar Rol</h2>
            <form action="../routers/rolesRouter.php?action=edit&id=<?= $this->rol->id_rol; ?>" method="POST">
                <!-- Muestrar el ID del rol que se esta editando(solo lectura) -->
                <div class="form-group">
                    <label for="id_rol">ID Rol</label>
                    <input type="text" class="form-control" id="id_rol" name="id_rol" value="<?= htmlspecialchars($this->rol->id_rol); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($this->rol->nombre); ?>" required>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class=" btn-success btn-sm mx-2">Actualizar Rol</button>
                    <a href="../routers/rolesRouter.php" class=" btn-secondary btn-sm">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>