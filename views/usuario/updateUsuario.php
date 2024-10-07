<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Editar Usuario</h2>
            </div>
            <div class="card-body">
                <!-- Formulario para editar usuario -->
                <form action="../routers/usuariosRouter.php?action=edit&id=<?= $this->usuario->id_usuario ?>" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($this->usuario->nombre) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" name="apellido" value="<?= htmlspecialchars($this->usuario->apellido) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo Electrónico:</label>
                        <input type="email" class="form-control" name="correo" value="<?= htmlspecialchars($this->usuario->correo) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña (dejar vacío si no deseas cambiarla):</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="form-group">
                        <label for="id_rol">Rol:</label>
                        <select class="form-control" name="id_rol" required>
                        <option value="">Seleccione un rol...</option> <!-- Opción por defecto -->
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?= $rol['id_rol'] ?>" <?= $rol['id_rol'] == $this->usuario->id_rol ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($rol['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                    </select>
                    </div>

                    <input type="hidden" name="id_usuario" value="<?= $this->usuario->id_usuario ?>">

                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    <a href="../routers/usuariosRouter.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
