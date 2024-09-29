<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/EstudianteMateriaModel.php');

class EstudianteMateriaController
{
    private $db;
    private $estudianteMateria;

    // Constructor
    public function __construct()
    {
        // Capturamos la conexión a la base de datos
        $database = new Conexion();
        $this->db = $database->Conectar();

        // Instanciamos el modelo EstudianteMateria
        $this->estudianteMateria = new EstudianteMateria($this->db);
    }

    // Método para mostrar la lista de asignaciones estudiante-materia
    public function index()
    {
        $result = $this->estudianteMateria->get_estudiante_materia();
        $asignaciones = $result->fetchAll(PDO::FETCH_ASSOC);

        // Llamamos la vista que muestra la lista de asignaciones
        include(dirname(__FILE__) . '/../views/indexEstudianteMateria.php');
    }

    // Método para asignar un estudiante a una materia
    public function create()
    {
        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->estudianteMateria->id_estudiante = $_POST['id_estudiante'];
            $this->estudianteMateria->id_materia_curso = $_POST['id_materia_curso'];

            // Redirigimos a la lista de asignaciones después de crear la relación
            $this->estudianteMateria->create();
            header("Location: index.php");
            exit();
        }

        // Incluimos la vista del formulario de creación de asignación
        include(dirname(__FILE__) . '/../views/createEstudianteMateria.php');
    }

    // Método para editar una asignación
    public function edit($id)
    {
        // Cargamos la asignación que se desea editar
        $this->estudianteMateria->id = $id;
        $this->estudianteMateria->get_estudiante_materia_by_id();

        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->estudianteMateria->id_estudiante = $_POST['id_estudiante'];
            $this->estudianteMateria->id_materia_curso = $_POST['id_materia_curso'];

            // Redirigimos a la lista de asignaciones después de actualizar
            $this->estudianteMateria->update();
            header("Location: index.php");
            exit();
        }

        // Incluimos la vista del formulario de edición
        include(dirname(__FILE__) . '/../views/updateEstudianteMateria.php');
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id)
    {
        // Cargamos la asignación que se desea eliminar
        $this->estudianteMateria->id = $id;
        $this->estudianteMateria->get_estudiante_materia_by_id();

        // Incluimos la vista de confirmación de eliminación
        include(dirname(__FILE__) . '/../views/deleteEstudianteMateria.php');
    }

    // Método para confirmar y eliminar una asignación
    public function delete()
    {
        if ($_POST && isset($_POST['id'])) {
            $this->estudianteMateria->id = $_POST['id'];

            // Lógica de eliminación
            if ($this->estudianteMateria->delete()) {
                header("Location: indexEstudianteMateria.php");
                exit();
            } else {
                echo "Error al eliminar la asignación.";
            }
        } else {
            echo "ID no proporcionado.";
        }
    }

    
}
