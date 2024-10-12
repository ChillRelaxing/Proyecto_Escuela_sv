<!-- deleteReporte.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Reporte</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-danger">Eliminar Reporte</h1>
        <p class="alert alert-warning">¿Estás seguro de que deseas eliminar el siguiente reporte?</p>
        <ul class="list-group">
            <li class="list-group-item"><strong>ID:</strong> <?php echo $reporte['id_reporte']; ?></li>
            <li class="list-group-item"><strong>Descripción:</strong> <?php echo $reporte['descripcion']; ?></li>
            <li class="list-group-item"><strong>Fecha del reporte:</strong> <?php echo $reporte['fecha_reporte']; ?></li>
            <li class="list-group-item"><strong>Nombre del estudiante:</strong> <?php echo $reporte['nombre_estudiante']; ?></li>
            <li class="list-group-item"><strong>Nombre profesor:</strong> <?php echo $reporte['nombre_usuario']; ?></li>
            <li class="list-group-item"><strong>Materia o curso:</strong> <?php echo $reporte['nombre_materia']; ?></li>
        </ul>

        <form action="../routers/reporteRouter.php?action=delete" method="POST" class="mt-4">
            <!-- Campo oculto para el ID del reporte -->
            <input type="hidden" name="id" value="<?php echo $reporte['id_reporte']; ?>">
            
            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
            <a href="../routers/reporteRouter.php" class="btn btn-secondary">No, volver</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
