<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Rol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Confirmar Eliminación</h2>
            <p>¿Está seguro que desea eliminar este rol? <strong><?= htmlspecialchars($this->rol->nombre . ' ' ); ?></strong>?</p>

            <form action="../routers/rolesRouter.php?action=delete" method="POST">
                <input type="hidden" name="id_rol" value="<?= $this->rol->id_rol ?>">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a href="../routers/rolesRouter.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>