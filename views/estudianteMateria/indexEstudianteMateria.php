<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Asignaciones Estudiante-Materia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Lista de Asignaciones Estudiante-Materia</h2>
            <div class="row">
                <div class="col-md-3">
                    <a href="../routers/estudianteMateriaRouter.php?action=create" class="btn btn-success">Asignar Estudiante a Materia</a>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Estudiante</th>
                            <th scope="col">Nombre Estudiante</th>
                            <th scope="col">Apellido Estudiante</th>
                            <th scope="col">Nombre Materia</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($asignaciones as $asignacion) : ?>
                            <tr>
                                <td><?= htmlspecialchars($asignacion['id_estudiante_materia']); ?></td>
                                <td><?= htmlspecialchars($asignacion['nombre_estudiante']); ?></td>
                                <td><?= htmlspecialchars($asignacion['apellido_estudiante']); ?></td>
                                <td><?= htmlspecialchars($asignacion['nombre_materia']); ?></td>
                                <td>
                                    <a href="../routers/estudianteMateriaRouter.php?action=edit&id=<?= $asignacion['id_estudiante_materia']; ?>" class="btn btn-warning btn-sm">Editar</a>

                                    <a href="../routers/estudianteMateriaRouter.php?action=confirmDelete&id=<?= $asignacion['id_estudiante_materia'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
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
