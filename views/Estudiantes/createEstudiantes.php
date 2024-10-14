<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Estudiante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/EstudiantesResponsive.css"> <!-- Enlace al archivo responsive -->
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2>Crear Estudiante</h2>
            </div>
                <div class="card-body">
                    <!-- Formulario para la creación de un reporte -->
                    <form action="../routers/estudiantesRouter.php?action=store"method="POST">
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
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="carnet">Carnet</label>
                            <input type="text" class="form-control" id="carnet" name="carnet" required>
                        </div>
                        <div class="form-group">
                            <label for="modalidad">Modalidad</label>
                            <select class="form-control" id="modalidad" name="modalidad" required>
                                <option value="">Seleccionar modalidad</option>
                                <option value="presencial">Presencial</option>
                                <option value="virtual">Virtual</option>
                            </select>
                        </div>
                        <!-- Botones de acción -->
                        <div class="text-center"> <!-- Centrar los botones -->
                            <button type="submit" class="btn btn-primary btn-lg">Guardar Estudiante</button>
                            <br>
                            <br>
                            <a href="../routers/estudiantesRouter.php" class="btn btn-secondary btn-lg">Cancelar</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>