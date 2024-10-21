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
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../views/css/usuarioResponsive.css"> <!-- Enlace al archivo responsive -->
    <!--URL Ajax-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<br><br>

    <!-- Mostramos el nombre del usuario y su rol -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-right">
                <p>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuarios']); ?></strong> (Rol: <?= htmlspecialchars($_SESSION['roles']); ?>)</p>
                <!-- Botón de salir -->
                <div class="ml-auto">
                    <a href="../routers/rolesRouter.php" class="btn btn-light mr-2">Ver Roles</a>
                    <form action="../views/auth/exit.php" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">Salir</button>
                    </form>
                </div>
            </div>
            
        </div>
    </div><br>


    <div class="container-fluid">
        <div class="card m-auto mt-5 p-4">
            <h2 class="text-center">Lista de Usuarios</h2><br>
            
            <!--Para la busqueda--->
            <div class="container-sm">
                <form action="" method="get">
                    <!-- Campo de búsqueda -->
                    <div class="input-group mb-3">
                        <input type="text" id="buscarUsuario" class="form-control mx-2" placeholder="Buscar usuario por nombre o rol..." aria-label="Recipient's username" aria-describedby="button-addon2" >
                        <!--<a href="../routers/usuariosRouter.php?action=create" class="btn btn-success" style="margin-left:10px">Agregar Usuario</a> -->
    

                        <div class="col-12 col-md-6 col-lg-3">
                            <a href="../routers/usuariosRouter.php?action=create" class="btn btn-success btn-block w-100 mb-3">Crear Usuario</a>
                        </div>
                    </div>
                </form>
            </div>


            <!----->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="dato" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Rol</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody id="resultadoUsuarios">
                                <?php foreach ($usuarios as $usuario) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($usuario['id_usuario']); ?></td>
                                        <td><?= htmlspecialchars($usuario['nombre']); ?></td>
                                        <td><?= htmlspecialchars($usuario['apellido']); ?></td>
                                        <td><?= htmlspecialchars($usuario['correo']); ?></td>
                                        <td><?= htmlspecialchars($usuario['password']); ?></td>
                                        <td><?= htmlspecialchars($usuario['nombre_rol']); ?></td>
                                        <td>
                                            <a href="../routers/usuariosRouter.php?action=edit&id=<?= $usuario['id_usuario']; ?>" class="btn btn-warning btn-sm mb-1">Editar</a>
                                            <a href="../routers/usuariosRouter.php?action=confirmDelete&id=<?= $usuario['id_usuario']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>


        </div>
    </div>
</body>
</html>

<!--para el ajaz funcione--->
<script src="../js/buscadorUsuario.js"></script>


