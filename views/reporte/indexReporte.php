<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reportes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/reporteResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body class="bg-light">

    <div class="container mt-5 mb-5"> <!-- Añade márgenes superior e inferior -->
        <div class="card shadow-lg p-4"> <!-- Añade sombra y relleno -->
            <div class="card-header text-center">
                <h2>Lista de Reportes</h2>
            </div>
            <div class="card-body">
                <div class="row mb-3"> <!-- Espacio inferior al botón -->
                    <div class="col-12 text-center"> <!-- Centrar el botón -->
                        <a href="../routers/reporteRouter.php?action=create" class="btn btn-success btn-lg">Crear Nuevo Reporte</a>
                    </div>
                </div>
                <div class="table-responsive"> <!-- Hace la tabla desplazable en pantallas pequeñas -->
                    <table class="table table-bordered table-striped">
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
                                    <td class="text-center"> <!-- Centrando las opciones -->
                                        <a href="../routers/reporteRouter.php?action=edit&id=<?= $reporte['id_reporte']; ?>" class="btn btn-warning btn-sm mr-2">Editar</a>
                                        <a href="../routers/reporteRouter.php?action=confirmDelete&id=<?= $reporte['id_reporte']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
