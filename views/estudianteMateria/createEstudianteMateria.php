<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Asignación Estudiante-Materia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Crear Asignación Estudiante-Materia</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="id_estudiante" class="form-label">Selecciona el Estudiante</label>
                <select name="id_estudiante" id="id_estudiante" class="form-select" required>
                    <option value="">Seleccione un estudiante</option>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <option value="<?php echo $estudiante['id_estudiante']; ?>">
                            <?php echo htmlspecialchars($estudiante['nombre'] . ' ' . $estudiante['apellido']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="id_materia_curso" class="form-label">Selecciona la Materia</label>
                <select name="id_materia_curso" id="id_materia_curso" class="form-select" required>
                    <option value="">Seleccione una materia</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?php echo $materia['id_materia_curso']; ?>">
                            <?php echo htmlspecialchars($materia['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Guardar Asignación</button>
                <a href="../routers/estudianteMateriaRouter.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
