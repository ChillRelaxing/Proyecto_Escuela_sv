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
    <title>Lista de Roles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/rolResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body>
<br><br>

    <!-- Mostramos el nombre del usuario y su rol -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-right">
                <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuarios']); ?></strong> (Rol: <?= htmlspecialchars($_SESSION['roles']); ?>)</p>
                <!-- Botón de salir -->
                <form action="../views/auth/exit.php" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-danger">Salir</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Lista de Roles</h2><br>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="../routers/rolesRouter.php?action=create" class="btn btn-success btn-block mb-3">Crear Rol</a>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Rol</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $rol) : ?>
                            <tr>
                                <td><?= htmlspecialchars($rol['id_rol']); ?></td>
                                <td><?= htmlspecialchars($rol['nombre']); ?></td>
                                <td>
                                    <a href="../routers/rolesRouter.php?action=edit&id=<?= $rol['id_rol']; ?>" class="btn btn-warning btn-sm mb-1">Editar</a>
                                    <a href="../routers/rolesRouter.php?action=confirmDelete&id=<?= $rol['id_rol']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
