<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Roles </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Lista de Roles</h2>
            <div class="row">
                <div class="col-md-3">
                    <a href="../routers/rolesRouter.php?action=create" class="btn btn-success">Crear Rol</a>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table">
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
                                    <a href="../routers/rolesRouter.php?action=edit&id=<?= $rol['id_rol']; ?>" class="btn btn-warning btn-sm">Editar</a>
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