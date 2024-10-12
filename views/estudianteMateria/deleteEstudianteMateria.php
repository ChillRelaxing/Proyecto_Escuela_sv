<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar eliminación de Asignación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/estudianteMateriaResponsive.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2>Confirmar Eliminación de Asignación</h2>
            </div>
            <div class="card-body">
                <h5>¿Estás seguro que deseas eliminar esta asignación?</h5>

                <div class="alert alert-warning">
                    <p><strong>Estudiante:</strong> <?= htmlspecialchars($asignacion['nombre_estudiante']) . " " . htmlspecialchars($asignacion['apellido_estudiante']) ?></p>
                    <p><strong>Materia:</strong> <?= htmlspecialchars($asignacion['nombre_materia']) ?></p>
                </div>

                <form action="../routers/estudianteMateriaRouter.php?action=delete" method="POST">
                    <!-- Campo oculto para enviar el ID -->
                    <input type="hidden" name="id" value="<?= isset($asignacion['id_estudiante_materia']) ? htmlspecialchars($asignacion['id_estudiante_materia']) : '' ?>">

                    <!-- Botones de acción -->
                    <div class="text-center"> <!-- Centrar los botones -->
                        <button type="submit" class="btn btn-danger btn-lg">Eliminar</button>
                        <br><br>
                        <a href="../routers/estudianteMateriaRouter.php" class="btn btn-secondary btn-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
