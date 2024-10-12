<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Asignación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/estudianteMateriaResponsive.css">
</head>

<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2>Editar Asignación Estudiante - Materia</h2>
            </div>
            <div class="card-body">
                <?php
                // Obtener el ID de la asignación desde la URL
                $id_asignacion = $_GET['id'] ?? null;

                // Validar el ID de la asignación
                if (!$id_asignacion || !is_numeric($id_asignacion)) {
                    echo "<div class='alert alert-danger'>ID de asignación inválido.</div>";
                    exit;
                }

                // Obtener el registro actual de la base de datos
                $asignacion = $this->estudianteMateria->get_estudiante_materia_by_id($id_asignacion);
                if ($asignacion) {
                    $estudiante_id = $asignacion['id_estudiante'];
                    $materia_id = $asignacion['id_materia_curso'];
                } else {
                    echo "<div class='alert alert-danger'>No se encontró la asignación.</div>";
                    exit;
                }
                ?>
                <form action="../routers/estudianteMateriaRouter.php?action=edit&id=<?= htmlspecialchars($id_asignacion); ?>" method="POST">
                    <div class="mb-3">
                        <label for="id_estudiante" class="form-label">Nombre Estudiante:</label>
                        <select name="id_estudiante" id="id_estudiante" class="form-control" required>
                            <?php
                            // Obtener la lista de estudiantes
                            $estudiantes = $this->estudianteMateria->get_estudiantes();
                            foreach ($estudiantes as $estudiante) {
                                // Seleccionar el estudiante actual
                                $selected = ($estudiante['id_estudiante'] == $asignacion['id_estudiante']) ? 'selected' : '';
                                echo "<option value='{$estudiante['id_estudiante']}' $selected>{$estudiante['nombre']} {$estudiante['apellido']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_materia_curso" class="form-label">Materia:</label>
                        <select name="id_materia_curso" id="id_materia_curso" class="form-control" required>
                            <?php
                            // Obtener la lista de materias
                            $materias = $this->estudianteMateria->get_materias_cursos(); 
                            foreach ($materias as $materia) {
                                // Seleccionar la materia actual
                                $selected = ($materia['id_materia_curso'] == $asignacion['id_materia_curso']) ? 'selected' : '';
                                echo "<option value='{$materia['id_materia_curso']}' $selected>{$materia['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="d-grid gap-2"> <!-- Ajustes para botones -->
                        <button type="submit" class="btn btn-primary btn-lg">Actualizar</button>
                        <a href="../routers/estudianteMateriaRouter.php" class="btn btn-secondary btn-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
