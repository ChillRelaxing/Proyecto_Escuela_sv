<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Reporte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/estudianteMateriaResponsive.css"> <!-- Enlace al archivo responsive -->
    <link rel="stylesheet" href="../views/css/reporteResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2>Crear Nuevo Reporte</h2>
            </div>
            <div class="card-body">
                <!-- Formulario para la creación de un reporte -->
                <form action="../routers/reporteRouter.php?action=create" method="POST">
                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fecha_reporte">Fecha del reporte:</label>
                        <input type="date" name="fecha_reporte" id="fecha_reporte" class="form-control" required>
                    </div>

                    <!-- Campo para seleccionar estudiante -->
                    <div class="form-group mb-3">
                        <label for="id_estudiante">Estudiante:</label>
                        <select name="id_estudiante" id="id_estudiante" class="form-control" required>
                            <option value="">Seleccione un estudiante</option>
                            <?php foreach ($estudiantes as $estudiante): ?>
                                <option value="<?= $estudiante['id_estudiante'] ?>"><?= $estudiante['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Campo para seleccionar usuario (profesor o administrador) -->
                    <div class="form-group mb-3">
                        <label for="id_usuario">Usuario (Profesor o Administrador):</label>
                        <select name="id_usuario" id="id_usuario" class="form-control" required>
                            <option value="">Seleccione un usuario</option>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario['id_usuario'] ?>"><?= $usuario['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Campo para seleccionar materia o curso -->
                    <div class="form-group mb-4">
                        <label for="id_materia_curso">Materia o Curso:</label>
                        <select name="id_materia_curso" id="id_materia_curso" class="form-control" required>
                            <option value="">Seleccione una materia o curso</option>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?= $materia['id_materia_curso'] ?>"><?= $materia['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Botones de acción -->
                    <div class="text-center"> <!-- Centrar los botones -->
                        <button type="submit" class="btn btn-primary btn-lg">Crear reporte</button>
                        <br>
                        <br>
                        <a href="../routers/reporteRouter.php" class="btn btn-secondary btn-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
