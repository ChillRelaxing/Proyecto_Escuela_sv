<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Estudiante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Confirmar Eliminación</h2>
            <p>¿Está seguro que desea eliminar al estudiante <strong><?= htmlspecialchars($this->estudiante->nombre . ' ' . $this->estudiante->apellido); ?></strong>?</p>
            <form action="../routers/estudiantesRouter.php?action=delete&id=<?= $this->estudiante->id_estudiante; ?>" method="POST">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a href="../routers/estudiantesRouter.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>