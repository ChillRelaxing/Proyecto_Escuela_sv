<?php
session_start();
ob_start();

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuarios']) || empty($_SESSION['usuarios'])) {
    header('Location: ../../index.php');
    exit;
}

// Verificamos el rol del usuario
if ($_SESSION['roles'] != 'Admin' && $_SESSION['roles'] != 'Profesor') {
    echo "Acceso denegado";  // Mensaje de depuración antes de redireccionar
    header('Location: ../views/auth/accessDenied.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Asignación Estudiante-Materia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/estudianteMateriaResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2>Crear Asignación Estudiante-Materia</h2>
            </div>
            <div class="card-body">
                <!-- Formulario para la creación de la asignación Estudiante-Materia -->
                <form action="" method="POST">
                    <!-- Campo de selección de estudiante -->
                    <div class="form-group mb-3">
                        <label for="id_estudiante" class="form-label">Selecciona el Estudiante</label>
                        <select name="id_estudiante" id="id_estudiante" class="form-control" required>
                            <option value="" disabled selected>Seleccione un estudiante</option>
                            <?php foreach ($estudiantes as $estudiante): ?>
                                <option value="<?= htmlspecialchars($estudiante['id_estudiante']) ?>">
                                    <?= htmlspecialchars($estudiante['nombre'] . ' ' . $estudiante['apellido']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Campo de selección de materia -->
                    <div class="form-group mb-3">
                        <label for="id_materia_curso" class="form-label">Selecciona la Materia</label>
                        <select name="id_materia_curso" id="id_materia_curso" class="form-control" required>
                            <option value="" disabled selected>Seleccione una materia</option>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?= htmlspecialchars($materia['id_materia_curso']) ?>">
                                    <?= htmlspecialchars($materia['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Botones de acción -->
                    <div class="text-center"> <!-- Centrar los botones -->
                        <button type="submit" class="btn btn-primary btn-lg">Guardar Asignación</button>
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
