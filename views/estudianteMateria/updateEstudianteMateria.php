<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Asignación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<br><br>
    <div class="container mt-5">
        <h1 class="text-center">Editar Asignación Estudiante - Materia</h1>

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
        //correcion de update a edit (../routers/estudianteMateriaRouter.php?action=edit&id=)
        ?>
        <form action="../routers/estudianteMateriaRouter.php?action=edit&id=<?= htmlspecialchars($id_asignacion); ?>" method="POST">
            <div class="form-group">
                <label for="id_estudiante">Nombre Estudiante:</label>
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

            <div class="form-group">
                <label for="id_materia_curso">Materia:</label>
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

            <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
        </form>

        <a href="../routers/estudianteMateriaRouter.php" class="btn btn-danger btn-block mt-2">Salir</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
