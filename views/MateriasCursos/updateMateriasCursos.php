<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Materias-Cursos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Actualizar Materias-Cursos</h2>
            <form action="../routers/materiasCursosRouter.php?action=edit&id=<?= $this->materiacurso->id_materia_curso; ?>" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($this->materiacurso->nombre); ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= htmlspecialchars($this->materiacurso->descripcion); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Materias-Cursos</button>
                <a href="../routers/materiasCursosRouter.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>