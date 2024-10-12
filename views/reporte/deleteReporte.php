<!-- deleteReporte.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Reporte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/reporteResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2 class="text-danger">Eliminar Reporte</h2>
            </div>
            <div class="card-body">
                <p class="alert alert-warning text-center">¿Estás seguro de que deseas eliminar el siguiente reporte?</p>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>ID:</strong> <?php echo $reporte['id_reporte']; ?></li>
                    <li class="list-group-item"><strong>Descripción:</strong> <?php echo $reporte['descripcion']; ?></li>
                    <li class="list-group-item"><strong>Fecha del reporte:</strong> <?php echo $reporte['fecha_reporte']; ?></li>
                    <li class="list-group-item"><strong>Nombre del estudiante:</strong> <?php echo $reporte['nombre_estudiante']; ?></li>
                    <li class="list-group-item"><strong>Nombre profesor:</strong> <?php echo $reporte['nombre_usuario']; ?></li>
                    <li class="list-group-item"><strong>Materia o curso:</strong> <?php echo $reporte['nombre_materia']; ?></li>
                </ul>

                <form action="../routers/reporteRouter.php?action=delete" method="POST" class="text-center">
                    <!-- Campo oculto para el ID del reporte -->
                    <input type="hidden" name="id" value="<?php echo $reporte['id_reporte']; ?>">
                    
                    <button type="submit" class="btn btn-danger btn-lg">Sí, eliminar</button>
                    <br>
                    <br>
                    <a href="../routers/reporteRouter.php" class="btn btn-secondary btn-lg">No, volver</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
