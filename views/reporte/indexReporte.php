<?php
session_start();
ob_start();

// Verificación de autenticación y rol de usuario
if (!isset($_SESSION['usuarios']) || empty($_SESSION['usuarios'])) {
    header('Location: ../../index.php');
    exit;
}

if ($_SESSION['roles'] != 'Admin' && $_SESSION['roles'] != 'Profesor') {
    echo "Acceso denegado";
    header('Location: ../views/auth/accessDenied.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reportes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/reporteResponsive.css"> <!-- Estilos Responsivos -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
<br><br>
    <!-- Cabecera y botón de salida -->
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
                    <select id="tableSelect_Rp" class="form-control form-control-lg" onchange="navigateToTable_Rp()">
                        <option value="">Selecciona una tabla...</option>
                        <option value="../routers/rolesRouter.php">Roles</option>
                        <option value="../routers/usuariosRouter.php">Usuarios</option>
                        <option value="../routers/estudiantesRouter.php">Estudiantes</option>
                        <option value="../routers/estudianteMateriaRouter.php">Estudiante Materia</option>
                        <option value="../routers/materiasCursosRouter.php">Materias Cursos</option>
                    </select>
                </div>
                <form action="../views/auth/exit.php" method="POST" class="d-inline mb-0">
                    <button type="submit" class="btn btn-danger">Salir</button>
                </form>
            </div>
        </div>
    </div><br><br>

    <div class="container-fluid">
        <div class="card m-auto mt-5 p-4">
                <h2>Lista de Reportes</h2><br>

            <!-- Formulario de Filtro y Botones de Exportación -->
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex">
                    <a id="exportPDFButton" href="reporteRouter.php?action=exportPDF" class="btn btn-danger btn-sm mx-1">Exportar a PDF</a>
                    <a id="exportExcelButton" href="reporteRouter.php?action=exportExcel" class="btn btn-warning btn-sm mx-1">Exportar a Excel</a>
                    <a id="exportCSVButton" href="reporteRouter.php?action=exportCSV" class="btn btn-info btn-sm mx-1">Exportar a CSV</a>
                </div>

                <a href="../routers/reporteRouter.php?action=create" class="btn btn-success btn-sm">Crear Nuevo Reporte</a>
            </div>

            <!-- Formulario de Filtro -->
            <form action="../routers/reporteRouter.php?action=generarReporte" method="POST" class="mb-4">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="id_estudiante">Estudiante:</label>
                        <select name="id_estudiante" id="id_estudiante" class="form-control">
                            <option value="">Todos</option>
                            <?php foreach ($estudiantes as $estudiante): ?>
                                <option value="<?= $estudiante['id_estudiante'] ?>"><?= htmlspecialchars($estudiante['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="id_materia_curso">Materia/Curso:</label>
                        <select name="id_materia_curso" id="id_materia_curso" class="form-control">
                            <option value="">Todos</option>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?= $materia['id_materia_curso'] ?>"><?= htmlspecialchars($materia['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="fecha_inicio">Fecha Inicio:</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="fecha_fin">Fecha Fin:</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>

            <!-- Campo de Búsqueda -->
            <div class="container-sm mb-4">
                <form action="" method="get" >
                    <input type="text" id="buscarReporte" class="form-control mx-4" placeholder="Buscar reporte por estudiante, docente o materia." aria-label="Recipient's username" aria-describedby="button-addon2">
                </form>
            </div>

            <!-- Tabla de Reportes -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Reporte</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha del Reporte</th>
                            <th scope="col">Nombre Estudiante</th>
                            <th scope="col">Usuario Creador</th>
                            <th scope="col">Materia/Curso</th>
                            <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="resultadoReporte">
                        <?php foreach ($reportes as $reporte) : ?>
                            <tr>
                                <td><?= htmlspecialchars($reporte['id_reporte']); ?></td>
                                <td><?= htmlspecialchars($reporte['descripcion']); ?></td>
                                <td><?= htmlspecialchars($reporte['fecha_reporte']); ?></td>
                                <td><?= htmlspecialchars($reporte['nombre_estudiante']); ?></td>
                                <td><?= htmlspecialchars($reporte['nombre_usuario']); ?></td>
                                <td><?= htmlspecialchars($reporte['nombre_materia']); ?></td>
                                <td class="text-center">
                                    <a href="../routers/reporteRouter.php?action=edit&id=<?= $reporte['id_reporte']; ?>" class="btn btn-warning btn-sm mr-2">Editar</a>
                                    <a href="../routers/reporteRouter.php?action=confirmDelete&id=<?= $reporte['id_reporte']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../js/buscadorReporte.js"></script>
</body>

</html>
