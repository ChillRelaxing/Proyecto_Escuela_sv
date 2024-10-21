<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/usuariosModel.php');

class UsuarioController
{
    private $db;
    private $usuario;

    // Constructor
    public function __construct()
    {
        // Capturamos la conexión a la base de datos
        $database = new Conexion();
        $this->db = $database->Conectar();

        // Instanciamos el modelo Usuario
        $this->usuario = new Usuario($this->db);
    }

    // Método para mostrar la lista de usuarios
    public function index()
    {
        $result = $this->usuario->get_usuarios();
        $usuarios = $result->fetchAll(PDO::FETCH_ASSOC);

        // Llamamos la vista que muestra la lista de usuarios
        include(dirname(__FILE__) . '/../views/usuario/indexUsuario.php');
    }

    // Método para crear un nuevo usuario
    public function create()
    {
        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->usuario->nombre = $_POST['nombre'];
            $this->usuario->apellido = $_POST['apellido'];
            $this->usuario->correo = $_POST['correo'];
            $this->usuario->password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptamos el password
            $this->usuario->id_rol = $_POST['id_rol'];

            // Redirigimos a la lista de usuarios después de crear el usuario
            if ($this->usuario->create()) {
                header("Location:../routers/usuariosRouter.php");
                exit();
            } else {
                echo "Error al crear el usuario.";
            }
        }

        
        // Obtener los datos de las tablas relacionadas para el formulario
        $roles = $this->usuario->get_roles();  // Obtener la lista de roles

        // Incluimos la vista del formulario de creación de usuario
        include(dirname(__FILE__) . '/../views/usuario/createUsuario.php');
    }

    // Método para editar un usuario
    public function edit($id_usuario)
    {
        // Cargamos el usuario que se desea editar
        $this->usuario->id_usuario = $id_usuario;
        $this->usuario->get_usuario_by_id();

        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->usuario->nombre = $_POST['nombre'];
            $this->usuario->apellido = $_POST['apellido'];
            $this->usuario->correo = $_POST['correo'];
            if (!empty($_POST['password'])) {
                $this->usuario->password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Actualizamos el password si se proporciona
            }
            $this->usuario->id_rol = $_POST['id_rol'];

            // Redirigimos a la lista de usuarios después de actualizar
            if ($this->usuario->update()) {
                header("Location: ../routers/usuariosRouter.php");
                exit();
            } else {
                echo "Error al actualizar el usuario.";
            }
        }

        // Obtener los roles para mostrarlos en el formulario
        $roles = $this->usuario->get_roles();

        // Incluimos la vista del formulario de edición
        include(dirname(__FILE__) . '/../views/usuario/updateUsuario.php');
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id_usuario)
    {
        // Cargamos el usuario que se desea eliminar
        $this->usuario->id_usuario = $id_usuario;
        $this->usuario->get_usuario_by_id();

        // Incluimos la vista de confirmación de eliminación
        include(dirname(__FILE__) . '/../views/usuario/deleteUsuario.php');
    }

    // Método para confirmar y eliminar un usuario
    public function delete()
    {
        if ($_POST && isset($_POST['id_usuario'])) {
            $this->usuario->id_usuario = $_POST['id_usuario'];

            // Lógica de eliminación
            if ($this->usuario->delete()) {
                header("Location: ../routers/usuariosRouter.php");
                exit();
            } else {
                echo "Error al eliminar el usuario.";
            }
        } else {
            echo "ID de usuario no proporcionado.";
        }
    }

    public function search($query)
    {
        // Llamamos al método del modelo que realiza la búsqueda
        $result = $this->usuario->search_usuarios($query);
        $usuarios = $result->fetchAll(PDO::FETCH_ASSOC);

        // Generamos el HTML para mostrar los resultados
        $output = '';
        if (count($usuarios) > 0) {
            foreach ($usuarios as $usuario) {
                $output .= '
                    <tr>
                        <td>' . $usuario['id_usuario'] . '</td>
                        <td>' . $usuario['nombre'] . '</td>
                        <td>' . $usuario['apellido'] . '</td>
                        <td>' . $usuario['correo'] . '</td>
                        <td>' . $usuario['password'] . '</td>
                        <td>' . $usuario['nombre_rol'] . '</td>
                        <td>
                            <a href="../routers/usuariosRouter.php?action=edit&id=' . $usuario['id_usuario'] . '" class="btn btn-warning btn-sm mb-1">Editar</a>
                            <a href="../routers/usuariosRouter.php?action=confirmDelete&id=' . $usuario['id_usuario'] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                ';
            }
        } else {
            $output = '<tr><td colspan="4">No se encontraron usuarios.</td></tr>';
        }
        
        echo $output;
    }



}
?>
