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
    <title>Lista de Materias-Cursos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/MateriasCursosResponsive.css"> <!-- Enlace al archivo responsive -->
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
                    <select id="tableSelect_mc" class="form-control form-control-lg" onchange="navigateToTable_mc()">
                        <option value="">Selecciona una tabla...</option>
                        <option value="../routers/rolesRouter.php">Roles</option>
                        <option value="../routers/usuariosRouter.php">Usuarios</option>
                        <option value="../routers/estudiantesRouter.php">Estudiantes</option>
                        <option value="../routers/estudianteMateriaRouter.php">Estudiante Materia</option>
                        <option value="../routers/materiasCursosRouter.php">Materias Cursos</option>
                        <option value="../routers/reporteRouter.php">Reportes</option>

                        <?php if ($_SESSION['roles'] === 'admin') : ?>
                            <option value="../routers/reporteRouter.php">Reportes</option>
                        <?php endif; ?>

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
            <h2>Lista de Materias-Cursos</h2><br>

            <!-- Formulario de Filtro y Botones de Exportación -->
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex">
                    <a href="../routers/materiasCursosRouter.php?action=exportPDF" class="btn btn-danger btn-sm mx-1">Exportar a PDF</>    
                    <a href="../routers/materiasCursosRouter.php?action=exportExcel" class="btn btn-warning btn-sm mx-1">Exportar a Excel</a>
                    <a href="../routers/materiasCursosRouter.php?action=exportCSV" class="btn btn-info btn-sm mx-1">Exportar a CSV</a>
                </div>

                <a href="../routers/materiasCursosRouter.php?action=create" class="btn btn-success btn-sm">Crear Materia-Curso</a>
            </div>

            <!--Para la busqueda--->
            <div class="container-sm">
                <form action="" method="get">
                    <!-- Campo de búsqueda -->
                    <div class="input-group mb-3">
                        <input type="text" id="buscarMateriasCrs" class="form-control mx-2" placeholder="Buscar Materia por nombre..." aria-label="Recipient's username" aria-describedby="button-addon2" >
                    </div>
                </form>
            </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID Materia</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="resultadoMateriasCrs">
                            <?php foreach ($materiacurso as $materiascursos) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($materiascursos['id_materia_curso']); ?></td>
                                    <td><?= htmlspecialchars($materiascursos['nombre']); ?></td>
                                    <td><?= htmlspecialchars($materiascursos['descripcion']); ?></td>
                                    <td>
                                        <a href="../routers/materiasCursosRouter.php?action=edit&id=<?= $materiascursos['id_materia_curso']; ?>" class="btn btn-warning btn-lg">Editar</a>
                                        <a href="../routers/materiasCursosRouter.php?action=confirmDelete&id=<?= $materiascursos['id_materia_curso']; ?>" class="btn btn-danger btn-lg">Eliminar</a>
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
<script src="../js/buscadorMaterias_Curso.js"></script>
