<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/rolModel.php');

class RolController
{
    private $db;
    private $rol;

    // Constructor
    public function __construct()
    {
        // Capturamos la conexión a la base de datos
        $database = new Conexion();
        $this->db = $database->Conectar();

        // Instanciamos el modelo Rol
        $this->rol = new Rol($this->db);
    }

    // Método para mostrar la lista de roles
    public function index()
    {
        $result = $this->rol->get_roles();
        $roles = $result->fetchAll(PDO::FETCH_ASSOC);

        // Llamamos la vista que muestra la lista de roles
        include(dirname(__FILE__) . '/../views/rol/indexRol.php');
    }

    // Método para crear un nuevo rol
    public function create()
    {
        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->rol->nombre = $_POST['nombre'];

            // Redirigimos a la lista de roles después de crear el rol
            if ($this->rol->create()) {
                header("Location: ../routers/rolesRouter.php");
                exit();
            } else {
                echo "Error al crear el rol.";
            }
        }

        // Incluimos la vista del formulario de creación de rol
        include(dirname(__FILE__) . '/../views/rol/createRol.php');
    }

    // Método para editar un rol
    public function edit($id_rol)
    {
        // Cargamos el rol que se desea editar
        $this->rol->id_rol = $id_rol;
        $this->rol->get_rol_by_id();

        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->rol->nombre = $_POST['nombre'];

            // Redirigimos a la lista de roles después de actualizar
            if ($this->rol->update()) {
                header("Location: ../routers/rolesRouter.php");
                exit();
            } else {
                echo "Error al actualizar el rol.";
            }
        }

        // Incluimos la vista del formulario de edición
        include(dirname(__FILE__) . '/../views/rol/updateRol.php');
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id_rol)
    {
        // Cargamos el rol que se desea eliminar
        $this->rol->id_rol = $id_rol;
        $this->rol->get_rol_by_id();

        // Incluimos la vista de confirmación de eliminación
        include(dirname(__FILE__) . '/../views/rol/deleteRol.php');
    }

    // Método para confirmar y eliminar un rol
    public function delete()
    {
        if ($_POST && isset($_POST['id_rol'])) {
            $this->rol->id_rol = $_POST['id_rol'];

            // Lógica de eliminación
            if ($this->rol->delete()) {
                header("Location: ../routers/rolesRouter.php");
                exit();
            } else {
                echo "Error al eliminar el rol.";
            }
        } else {
            echo "ID de rol no proporcionado.";
        }
    }
}
?>
