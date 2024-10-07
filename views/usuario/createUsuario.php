<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Crear Usuario</h2>
            <form action="../routers/usuariosRouter.php?action=store" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Password</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>

                <div class="form-group">
                    <label for="id_rol">Rol:</label>
                    <select name="id_rol" id="id_rol" class="form-control" required>
                        <option value="">Seleccione el rol...</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?= $rol['id_rol'] ?>"><?= $rol['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-success">Guardar Usuario</button>
                <a href="../routers/usuariosRouter.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>
