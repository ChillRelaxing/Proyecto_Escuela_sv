<?php
session_start();
ob_start();

// Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuarios']) || empty($_SESSION['usuarios'])) {
    header('Location: ../../index.php');
    exit;
}

// Verificamos el rol del usuario
if ($_SESSION['roles'] != 'Admin' && $_SESSION['roles'] != 'Profesor') {
    echo "Acceso denegado";  // Depura antes de la redirección
    header('Location: ../views/auth/accessDenied.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/EstudiantesResponsive.css"> <!-- Enlace al archivo responsive -->
    <!--URL Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body class="bg-light">

    <!-- Bienvenida y botón de salir -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-right mt-3">
                <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuarios']); ?></strong> (Rol: <?= htmlspecialchars($_SESSION['roles']); ?>)</p>
                <!-- Botón de salir -->
                <div class="ml-auto">
                    <a href="../routers/materiasCursosRouter.php" class="btn btn-secondary mr-2">Materias-Cursos</a>
                    <form action="../views/auth/exit.php" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5"> <!-- Añade márgenes superior e inferior -->
        <div class="card shadow-lg p-4"> <!-- Añade sombra y relleno -->
            <div class="card-header text-center">
                <h2>Lista de Estudiantes</h2>
            </div><br><br>

            <!--Para la busqueda--->
            <div class="container-sm">
                <form action="" method="get">
                    <!-- Campo de búsqueda -->
                    <div class="input-group mb-3">
                        <input type="text" id="buscarEstudiante" class="form-control mx-2" placeholder="Buscar estudiante por carnet o modalidad..." aria-label="Recipient's username" aria-describedby="button-addon2" >
    
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="../routers/estudiantesRouter.php?action=create" class="btn btn-success btn-block w-100 mb-3">Crear Estudiante</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive"> <!-- Hace la tabla desplazable en pantallas pequeñas -->
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Estudiante</th>
                            <th scope="col">Nombre Estudiante</th>
                            <th scope="col">Apellido Estudiante</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Telefono</th>
                            <th scope="col">Carnet</th>
                            <th scope="col">Modalidad</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="resultadoEstudiante">
                        <?php foreach ($estudiantes as $estudiante) : ?>
                            <tr>
                                <td><?= htmlspecialchars($estudiante['id_estudiante']); ?></td>
                                <td><?= htmlspecialchars($estudiante['nombre']); ?></td>
                                <td><?= htmlspecialchars($estudiante['apellido']); ?></td>
                                <td><?= htmlspecialchars($estudiante['correo']); ?></td>
                                <td><?= htmlspecialchars($estudiante['telefono']); ?></td>
                                <td><?= htmlspecialchars($estudiante['carnet']); ?></td>
                                <td><?= htmlspecialchars($estudiante['modalidad']); ?></td>
                                <td>
                                    <a href="../routers/estudiantesRouter.php?action=edit&id=<?= $estudiante['id_estudiante']; ?>" class="btn btn-warning btn-lg">Editar</a>
                                    <a href="../routers/estudiantesRouter.php?action=confirmDelete&id=<?= $estudiante['id_estudiante']; ?>" class="btn btn-danger btn-lg">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

                
        </div>
    </div>

</body>
</html>

<!--para el ajaz funcione--->
<script src="../js/buscadorEstudiante.js"></script>