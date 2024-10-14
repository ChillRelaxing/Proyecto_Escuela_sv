<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Materias-Cursos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/MateriasCursosResponsive.css"> <!-- Enlace al archivo responsive -->
</head>

<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2>Actualizar Materias-Cursos</h2>
            </div>
            <div class="card-body">
                <!-- Formulario para la actualización de un reporte -->
                <form action="../routers/materiasCursosRouter.php?action=edit&id=<?= $this->materiacurso->id_materia_curso; ?>" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($this->materiacurso->nombre); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Descripcion</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= htmlspecialchars($this->materiacurso->descripcion); ?>" required>
                    </div>

                    <!-- Botones de acción -->
                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Actualizar Materias-Cursos</button>
                        <br>
                        <br>
                        <a href="../routers/materiasCursosRouter.php" class="btn btn-secondary btn-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>