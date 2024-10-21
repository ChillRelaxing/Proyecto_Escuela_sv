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
    echo "Acceso denegado";  // Mensaje de depuración antes de redireccionar
    header('Location: ../views/auth/accessDenied.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Asignaciones Estudiante-Materia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/estudianteMateriaResponsive.css"> <!-- Enlace al archivo responsive -->
    <!--URL Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body class="bg-light"><br>
    
    <!-- Mostramos el nombre del usuario y su rol -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-right ">
                <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuarios']); ?></strong> (Rol: <?= htmlspecialchars($_SESSION['roles']); ?>)</p>
                <!-- Botón de salir -->
                <div class="ml-auto">
                    <a href="../routers/reporteRouter.php" class="btn btn-secondary mr-2">Hacer Reporte</a>
                    <form action="../views/auth/exit.php" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5"> <!-- Ajuste de márgenes superior e inferior -->
        <div class="card shadow-lg p-4"> <!-- Sombra para dar más contraste a la tarjeta -->
            <div class="card-header text-center">
                <h2>Lista de Asignaciones Estudiante-Materia</h2>
            </div><br><br>

            <!--Para la busqueda--->
            <div class="container-sm">
                <form action="" method="get">
                    <!-- Campo de búsqueda -->
                    <div class="input-group mb-3">
                        <input type="text" id="buscarEstudianteMateria" class="form-control mx-2" placeholder="Buscar estudiante por nombre o materia..." aria-label="Recipient's username" aria-describedby="button-addon2" >
    
                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="../routers/estudianteMateriaRouter.php?action=create" class="btn btn-success btn-block w-100 mb-3">Asignar Estudiante a Materia</a>
                        </div>
                    </div>
                </form>
            </div>

            <!----->
            <div class="table-responsive"> <!-- Hace la tabla desplazable en pantallas pequeñas -->
                <table  class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Estudiante</th>
                            <th scope="col">Nombre Estudiante</th>
                            <th scope="col">Apellido Estudiante</th>
                            <th scope="col">Nombre Materia</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="resultadoEstudiante_materia">
                        <?php foreach ($asignaciones as $asignacion) : ?>
                            <tr>
                                <td><?= htmlspecialchars($asignacion['id_estudiante_materia']); ?></td>
                                <td><?= htmlspecialchars($asignacion['nombre_estudiante']); ?></td>
                                <td><?= htmlspecialchars($asignacion['apellido_estudiante']); ?></td>
                                <td><?= htmlspecialchars($asignacion['nombre_materia']); ?></td>
                                <td class="text-center"> <!-- Centra las opciones de editar y eliminar -->
                                    <a href="../routers/estudianteMateriaRouter.php?action=edit&id=<?= $asignacion['id_estudiante_materia']; ?>" class="btn btn-warning btn-sm mr-2">Editar</a>
                                    <a href="../routers/estudianteMateriaRouter.php?action=confirmDelete&id=<?= $asignacion['id_estudiante_materia'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
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
<script src="../js/buscadorEstudiante_materia.js"></script>