<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Materias-Cursos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Confirmar Eliminación</h2>
            <p>¿Está seguro que desea eliminar a la Materias-Cursos <strong><?= htmlspecialchars($this->materiacurso->nombre . ' ' . $this->materiacurso->descripcion); ?></strong>?</p>
            <form action="../routers/materiasCursosRouter.php?action=delete&id=<?= $this->materiacurso->id_materia_curso ?>" method="POST">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a href="../routers/materiasCursosRouter.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>