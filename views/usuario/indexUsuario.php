<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container-fluid">
        <div class="card m-auto mt-5 p-4">
            <h2>Lista de Usuarios</h2>
            <div class="row">
                <div class="col-md-3">
                    <a href="../routers/usuariosRouter.php?action=create" class="btn btn-success">Crear Usuario</a>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID </th>
                            <th scope="col">Nombre </th>
                            <th scope="col">Apellido </th>
                            <th scope="col">Correo</th>
                            <th scope="col">Password</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario) : ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['id_usuario']); ?></td>
                                <td><?= htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?= htmlspecialchars($usuario['apellido']); ?></td>
                                <td><?= htmlspecialchars($usuario['correo']); ?></td>
                                <td><?= htmlspecialchars($usuario['password']); ?></td>
                                <td><?= htmlspecialchars($usuario['nombre_rol']); ?></td> <!--As de la consulta-->
                                <td>
                                    <a href="../routers/usuariosRouter.php?action=edit&id=<?= $usuario['id_usuario']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="../routers/usuariosRouter.php?action=confirmDelete&id=<?= $usuario['id_usuario']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
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
