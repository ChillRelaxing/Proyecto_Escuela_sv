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
    <title>Lista de Materias-Cursos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/MateriasCursosResponsive.css"> <!-- Enlace al archivo responsive -->
</head>

<body class="bg-light">

    <!-- Bienvenida y botón de salir -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-right mt-3">
                <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuarios']); ?></strong> (Rol: <?= htmlspecialchars($_SESSION['roles']); ?>)</p>
                <!-- Botón de salir -->
                <form action="../views/auth/exit.php" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-danger">Salir</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5"> <!-- Añade márgenes superior e inferior -->
        <div class="card shadow-lg p-4"> <!-- Añade sombra y relleno -->
            <div class="card-header text-center">
                <h2>Lista de Materias-Cursos</h2>
            </div>
            <div class="card-body">
                <div class="row mb-3"> <!-- Espacio inferior al botón -->
                    <div class="col-12 text-center"> <!-- Centrar el botón -->
                        <a href="../routers/materiasCursosRouter.php?action=create" class="btn btn-success btn-lg">Crear Materia-Curso</a>
                    </div>
                </div>
                <div class="row mt-3">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID Materia</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
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
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
