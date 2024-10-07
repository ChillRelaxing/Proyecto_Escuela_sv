<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Eliminar Usuario</h2>
            <p>¿Estás seguro que deseas eliminar al usuario <strong><?= htmlspecialchars($this->usuario->nombre . ' ' . $this->usuario->apellido); ?></strong>?</p>
            <form action="../routers/usuariosRouter.php?action=delete" method="POST">
                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($this->usuario->id_usuario); ?>">
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <a href="../routers/usuariosRouter.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>0
</body>
</html>
