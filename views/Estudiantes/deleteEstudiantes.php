<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Estudiante</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/EstudiantesResponsive.css"> <!-- Enlace al archivo responsive -->
</head>

<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2 class="text-danger">Eliminar Estudiante</h2>
            </div>

            <div class="card-body">
                <h5>¿Está seguro que desea eliminar al estudiante?</h5>

                <div class="alert alert-warning">
                    <p>Estudiante: <strong><?= htmlspecialchars($this->estudiante->nombre . ' ' . $this->estudiante->apellido); ?></strong></p>
                </div>


                <form action="../routers/estudiantesRouter.php?action=delete&id=<?= $this->estudiante->id_estudiante; ?>" method="POST" class="text-center">
                    <button type="submit" class="btn btn-danger btn-lg">Eliminar</button>
                    <br>
                    <br>
                    <a href="../routers/estudiantesRouter.php" class="btn btn-secondary btn-lg">Cancelar</a>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>