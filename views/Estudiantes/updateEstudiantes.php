<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Estudiante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Actualizar Estudiante</h2>
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
                <button type="submit" class="btn btn-primary">Actualizar Estudiante</button>
                <a href="../routers/estudiantesRouter.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>