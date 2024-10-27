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
    <title>Lista de Roles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/rolResponsive.css"> <!-- Enlace al archivo responsive -->
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

    <!--ver todas las tablas -->
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-auto d-flex align-items-center">
                <div class="form-group mb-0 mx-3">
                    <!--Para ver todad las tbls-->  
                    <select id="tableSelect_Rol" class="form-control form-control-lg" onchange="navigateToTable_Rol()"> <!--llamando a la funcion en js-->
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
            <h2>Lista de Roles</h2><br>
            
            <!--Para la busqueda--->
            <div class="container-lg">
                <form action="" method="get">
                    <div class="d-flex justify-content-center mb-3 col-12">
                        <a href="../routers/rolesRouter.php?action=exportPDF" class="btn btn-danger btn-sm mx-4">Exportar a PDF</>    
                        <a href="../routers/rolesRouter.php?action=exportExcel" class="btn btn-warning btn-sm mx-4">Exportar a Excel</a>
                        <a href="../routers/rolesRouter.php?action=exportCSV" class="btn btn-info btn-sm mx-4">Exportar a CSV</a>
                    </div>
                    <br>
                    
                    <!-- Para la búsqueda -->
                    <div class="input-group mb-2 ">

                        <div class="col-12 col-md-6 col-lg-3">
                        <a href="../routers/rolesRouter.php?action=create" class="btn btn-success btn-block w-100 mb-3">Crear Rol</a>
                        </div>
                        <input type="text" id="buscarRol" class="form-control mx-2" placeholder="Buscar rol." aria-label="Recipient's username" aria-describedby="button-addon2" >
                    </div>
                </form>
            </div>
            
            <div class="row mt-3">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Rol</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody  id="resultadoRoles">
                        <?php foreach ($roles as $rol) : ?>
                            <tr>
                                <td><?= htmlspecialchars($rol['id_rol']); ?></td>
                                <td><?= htmlspecialchars($rol['nombre']); ?></td>
                                <td>
                                    <a href="../routers/rolesRouter.php?action=edit&id=<?= $rol['id_rol']; ?>" class="btn btn-warning btn-sm mb-1">Editar</a>
                                    <a href="../routers/rolesRouter.php?action=confirmDelete&id=<?= $rol['id_rol']; ?>" class="btn btn-danger btn-sm mb-1">Eliminar</a>
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
<script src="../js/buscadorRoles.js"></script>
