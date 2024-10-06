<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Materias-Cursos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<br><br>
    <div class="container">
        <div class="card m-auto mt-5 p-4">
            <h2>Lista de Materias-Cursos</h2>
            <div class="row">
                <div class="col-md-3">
                    <a href="../routers/materiasCursosRouter.php?action=create" class="btn btn-success">Crear MateriasCursos</a>
                </div>
            </div>
            <div class="row mt-3">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Materia</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripcion</th>
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
                                    <a href="../routers/materiasCursosRouter.php?action=edit&id=<?= $materiascursos['id_materia_curso']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="../routers/materiasCursosRouter.php?action=confirmDelete&id=<?= $materiascursos['id_materia_curso']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
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