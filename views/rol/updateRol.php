<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Rol</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Actualizar Rol</h2>
            <form action="../routers/rolesRouter.php?action=edit&id=<?= $this->rol->id_rol; ?>" method="POST">
                <!-- Muestrar el ID del rol que se esta editando(solo lectura) -->
                <div class="form-group">
                    <label for="id_rol">ID Rol</label>
                    <input type="text" class="form-control" id="id_rol" name="id_rol" value="<?= htmlspecialchars($this->rol->id_rol); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($this->rol->nombre); ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Rol</button>
                <a href="../routers/rolesRouter.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>