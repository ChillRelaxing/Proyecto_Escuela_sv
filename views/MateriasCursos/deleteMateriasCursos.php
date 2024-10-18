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
    <title>Eliminar Materias-Cursos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/MateriasCursosResponsive.css"> <!-- Enlace al archivo responsive -->
</head>

<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="card shadow-lg p-4"> <!-- Tarjeta con sombra y relleno -->
            <div class="card-header text-center">
                <h2 class="text-danger">Eliminar MateriasCursos</h2>
            </div>

            <div class="card-body">
                <h5>¿Está seguro que desea eliminar a esta Materias-Cursos?</h5>

                <div class="alert alert-warning">
                    <p>Materia: <strong><?= htmlspecialchars($this->materiacurso->nombre); ?></strong></p>
                    <p>Descripcion: <strong><?= htmlspecialchars($this->materiacurso->descripcion); ?></strong></p>
                </div>

                <form action="../routers/materiasCursosRouter.php?action=delete&id=<?= $this->materiacurso->id_materia_curso ?>" method="POST" class="text-center">
                    <button type="submit" class="btn btn-danger btn-lg">Eliminar</button>
                    <br>
                    <br>
                    <a href="../routers/materiasCursosRouter.php" class="btn btn-secondary btn-lg">Cancelar</a>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>