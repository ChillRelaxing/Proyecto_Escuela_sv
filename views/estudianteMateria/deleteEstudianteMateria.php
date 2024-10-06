<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar eliminación de Asignación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container mt-5">
        <h2>¿Estás seguro que deseas eliminar esta asignación?</h2>

        <div class="alert alert-warning">
            <!-- Usamos la variable $asignacion que se pasó desde el controlador -->
            <p><strong>Estudiante:</strong> <?= htmlspecialchars($asignacion['nombre_estudiante']) . " " . htmlspecialchars($asignacion['apellido_estudiante']) ?></p>
            <p><strong>Materia:</strong> <?= htmlspecialchars($asignacion['nombre_materia']) ?></p>
        </div>

        <form action="../routers/estudianteMateriaRouter.php?action=delete" method="POST">
            <!-- Campo oculto para enviar el ID -->
            <input type="hidden" name="id" value="<?= isset($asignacion['id_estudiante_materia']) ? htmlspecialchars($asignacion['id_estudiante_materia']) : '' ?>">
            
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <a href="../routers/estudianteMateriaRouter.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>




