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
<body>
<br><br>
    <!-- Bienvenida y botón de salir -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-right">
                <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuarios']); ?></strong> (Rol: <?= htmlspecialchars($_SESSION['roles']); ?>)</p>
            </div>
        </div>
    </div>

    <!---->
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-auto d-flex align-items-center">
                <div class="form-group mb-0 mx-3">
                    <!--Para ver todad las tbls-->  
                    <select id="tableSelect_em" class="form-control form-control-lg" onchange="navigateToTable_em()">
                        <option value="">Selecciona una tabla...</option>
                        <option value="../routers/rolesRouter.php">Roles</option>
                        <option value="../routers/usuariosRouter.php">Usuarios</option>
                        <option value="../routers/estudiantesRouter.php">Estudiantes</option>
                        <option value="../routers/estudianteMateriaRouter.php">Estudiante Materia</option>
                        <option value="../routers/materiasCursosRouter.php">Materias Cursos</option>
                        <option value="../routers/reporteRouter.php">Reportes</option>
                    </select>
                </div>
                <form action="../views/auth/exit.php" method="POST" class="d-inline mb-0">
                    <button type="submit" class="btn btn-danger">Salir</button>
                </form>
            </div>
        </div>
    </div><br><br>

<!--Card-->
    <div class="container-fluid">
        <div class="card m-auto mt-5 p-4">
                <h2>Lista de Asignaciones Estudiante-Materia</h2><br>

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