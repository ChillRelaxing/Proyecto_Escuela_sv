<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Lista de Estudiantes</h2>
            <div class="row">
                <div class="col-md-3">
                    <a href="../routers/estudiantesRouter.php?action=create" class="btn btn-success">Crear Estudiante</a>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Estudiante</th>
                            <th scope="col">Nombre Estudiante</th>
                            <th scope="col">Apellido Estudiante</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Carnet</th>
                            <th scope="col">Modalidad</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estudiantes as $estudiante) : ?>
                            <tr>
                                <td><?= htmlspecialchars($estudiante['id_estudiante']); ?></td>
                                <td><?= htmlspecialchars($estudiante['nombre']); ?></td>
                                <td><?= htmlspecialchars($estudiante['apellido']); ?></td>
                                <td><?= htmlspecialchars($estudiante['correo']); ?></td>
                                <td><?= htmlspecialchars($estudiante['telefono']); ?></td>
                                <td><?= htmlspecialchars($estudiante['carnet']); ?></td>
                                <td><?= htmlspecialchars($estudiante['modalidad']); ?></td>
                                <td>
                                    <a href="../routers/estudiantesRouter.php?action=edit&id=<?= $estudiante['id_estudiante']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="../routers/estudiantesRouter.php?action=confirmDelete&id=<?= $estudiante['id_estudiante']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
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
