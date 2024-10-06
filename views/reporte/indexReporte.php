<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reportes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Lista de Reportes</h2>
            <div class="row">
                <div class="col-md-3">
                    <a href="../routers/reporteRouter.php?action=create" class="btn btn-success">Crear Nuevo Reporte</a>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Reporte</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha del Reporte</th>
                            <th scope="col">Nombre Estudiante</th>
                            <th scope="col">Usuario Creador</th>
                            <th scope="col">Materia/Curso</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportes as $reporte) : ?>
                            <tr>
                                <td><?= htmlspecialchars($reporte['id_reporte']); ?></td>
                                <td><?= htmlspecialchars($reporte['descripcion']); ?></td>
                                <td><?= htmlspecialchars($reporte['fecha_reporte']); ?></td>
                                <td><?= htmlspecialchars($reporte['nombre_estudiante']); ?></td>
                                <td><?= htmlspecialchars($reporte['nombre_usuario']); ?></td>
                                <td><?= htmlspecialchars($reporte['nombre_materia']); ?></td>
                                <td>
                                    <a href="../routers/reporteRouter.php?action=edit&id=<?= $reporte['id_reporte']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="../routers/reporteRouter.php?action=confirmDelete&id=<?= $reporte['id_reporte']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
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
