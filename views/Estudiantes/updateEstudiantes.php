<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Estudiante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/EstudiantesResponsive.css"> <!-- Enlace al archivo responsive -->
</head>

<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2 class="text-primary">Actualizar Estudiante</h2>
            </div>
            <div class="card-body">
                <!-- Formulario para la actualización de un reporte -->
                <form action="../routers/estudiantesRouter.php?action=edit&id=<?= $this->estudiante->id_estudiante; ?>" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($this->estudiante->nombre); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($this->estudiante->apellido); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($this->estudiante->correo); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($this->estudiante->telefono); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="carnet">Carnet</label>
                        <input type="text" class="form-control" id="carnet" name="carnet" value="<?= htmlspecialchars($this->estudiante->carnet); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="modalidad">Modalidad</label>
                        <select class="form-control" id="modalidad" name="modalidad" required>
                            <option value="presencial" <?= $this->estudiante->modalidad == "presencial" ? 'selected' : ''; ?>>Presencial</option>
                            <option value="virtual" <?= $this->estudiante->modalidad == "virtual" ? 'selected' : ''; ?>>Virtual</option>
                        </select>
                    </div>

                    <!-- Botones de acción -->
                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Actualizar Estudiante</button>
                        <br>
                        <br>
                        <a href="../routers/estudiantesRouter.php" class="btn btn-secondary btn-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>