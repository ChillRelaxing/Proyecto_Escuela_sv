<?php
session_start();
ob_start();

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuarios']) || empty($_SESSION['usuarios'])) {
    header('Location: ../../index.php');
    exit;
}

// Verificamos el rol del usuario
if ($_SESSION['roles'] != 'Admin') {
    echo "Acceso denegado";  // Mensaje de depuración antes de 
    header('Location: ../views/auth/accessDenied.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/usuarioResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2 class="text-primary">Editar Usuario</h2>
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
                    
                    <div class="form-group text-center mt-4">
                        <button type="submit" class=" btn-success btn-sm mx-2">Actualizar Usuario</button><br><br>
                        <a href="../routers/usuariosRouter.php" class=" btn-secondary btn-sm">Cancelar</a> 
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>
</html>
