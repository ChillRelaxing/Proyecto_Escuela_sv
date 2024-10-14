<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Rol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/rolResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Crear Rol </h2>
            <form action="../routers/rolesRouter.php?action=store" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn-primary btn-sm mx-2">Guardar Rol</button>
                    <a href="../routers/rolesRouter.php" class=" btn-secondary btn-sm">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>