<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/EstudiantesModel.php');

class MateriasCursosController
{
    private $db;
    private $estudiantes;

    // Constructor
    public function __construct()
    {
        // Capturamos la conexión a la base de datos
        $database = new Conexion();
        $this->db = $database->Conectar();

        // Instanciamos el modelo MateriasCursos
        $this->estudiantes = new Estudiantes($this->db);
    }

    // Método para mostrar la lista de Estudiantes
    public function index()
    {
        $result = $this->estudiantes->get_Estudiantes();
        $estudiantes = $result->fetchAll(PDO::FETCH_ASSOC);

        // Llamamos la vista que muestra la lista de Estudiantes
        include(dirname(__FILE__) . '/../views/indexEstudiantes.php');
    }

    // Método para crear un nuevo Estudiante
    public function create()
    {
        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->estudiantes->nombre = $_POST['nombre'];
            $this->estudiantes->apellido = $_POST['apellido'];
            $this->estudiantes->correo = $_POST['correo'];
            $this->estudiantes->telefono = $_POST['telefono'];
            $this->estudiantes->carnet = $_POST['carnet'];
            $this->estudiantes->modalidad = $_POST['modalidad'];

            // Redirigimos a la lista de estudiantes después de crear el Estudiante
            if ($this->estudiantes->create()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error al crear el estudiante.";
            }
        }

        // Incluimos la vista del formulario de creación de Estudiante
        include(dirname(__FILE__) . '/../views/createEstudiantes.php');
    }

    // Método para editar un Estudiante
    public function edit($id_estudiante)
    {
        // Cargamos el rol que se desea editar
        $this->estudiantes->id_estudiante = $id_estudiante;
        $this->estudiantes->get_Estudiantes_by_id();

        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->estudiantes->nombre = $_POST['nombre'];
            $this->estudiantes->apellido = $_POST['apellido'];
            $this->estudiantes->correo = $_POST['correo'];
            $this->estudiantes->telefono = $_POST['telefono'];
            $this->estudiantes->carnet = $_POST['carnet'];
            $this->estudiantes->modalidad = $_POST['modalidad'];

            // Redirigimos a la lista de roles después de actualizar
            if ($this->estudiantes->update()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error al actualizar el estudiante.";
            }
        }

        // Incluimos la vista del formulario de edición
        include(dirname(__FILE__) . '/../views/updateEstudiantes.php');
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id_estudiante)
    {
        // Cargamos el rol que se desea eliminar
        $this->estudiantes->id_estudiante = $id_estudiante;
        $this->estudiantes->get_Estudiantes_by_id();

        // Incluimos la vista de confirmación de eliminación
        include(dirname(__FILE__) . '/../views/deleteEstudiantes.php');
    }

    // Método para confirmar y eliminar un Estudiante
    public function delete()
    {
        if ($_POST && isset($_POST['id_estudiante'])) {
            $this->estudiantes->id_estudiante = $_POST['id_estudiante'];

            // Lógica de eliminación
            if ($this->rol->delete()) {
                header("Location: indexEstudiantes.php");
                exit();
            } else {
                echo "Error al eliminar el estudiante.";
            }
        } else {
            echo "ID de estudiante no proporcionado.";
        }
    }
}
?>