<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/MateriasCursosModel.php');

class MateriasCursosController
{
    private $db;
    private $materiascursos;

    // Constructor
    public function __construct()
    {
        // Capturamos la conexión a la base de datos
        $database = new Conexion();
        $this->db = $database->Conectar();

        // Instanciamos el modelo MateriasCursos
        $this->materiascursos = new MateriasCursos($this->db);
    }

    // Método para mostrar la lista de MateriasCursos
    public function index()
    {
        $result = $this->materiascursos->get_MateriasCursos();
        $materiacurso = $result->fetchAll(PDO::FETCH_ASSOC);

        // Llamamos la vista que muestra la lista de MateriasCursos
        include(dirname(__FILE__) . '/../views/indexMateriasCursos.php');
    }

    // Método para crear un nueva MateriasCursos
    public function create()
    {
        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->materiascursos->nombre = $_POST['nombre'];
            $this->materiascursos->descripcion = $_POST['descripcion'];

            // Redirigimos a la lista de MateriasCursos después de crear la MateriaCurso
            if ($this->materiascursos->create()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error al crear la Materia.";
            }
        }

        // Incluimos la vista del formulario de creación de MateriasCursos
        include(dirname(__FILE__) . '/../views/createMateriasCursos.php');
    }

    // Método para editar un MateriaCurso
    public function edit($id_materia_curso)
    {
        // Cargamos el rol que se desea editar
        $this->materiascursos->id_materia_curso = $id_materia_curso;
        $this->materiascursos->get_MateriasCursos_by_id();

        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->materiascursos->nombre = $_POST['nombre'];
            $this->materiascursos->descripcion = $_POST['descripcion'];

            // Redirigimos a la lista de roles después de actualizar
            if ($this->materiascursos->update()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error al actualizar la materia.";
            }
        }

        // Incluimos la vista del formulario de edición
        include(dirname(__FILE__) . '/../views/updateMateriasCursos.php');
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id_materia_curso)
    {
        // Cargamos el rol que se desea eliminar
        $this->materiascursos->id_materia_curso = $id_materia_curso;
        $this->materiascursos->get_MateriasCursos_by_id();

        // Incluimos la vista de confirmación de eliminación
        include(dirname(__FILE__) . '/../views/deleteMateriasCursos.php');
    }

    // Método para confirmar y eliminar una materia
    public function delete()
    {
        if ($_POST && isset($_POST['id_materia_curso'])) {
            $this->materiascursos->id_materia_curso = $_POST['id_materia_curso'];

            // Lógica de eliminación
            if ($this->materiascursos->delete()) {
                header("Location: indexMateriasCursos.php");
                exit();
            } else {
                echo "Error al eliminar la materia.";
            }
        } else {
            echo "ID de rol no proporcionado.";
        }
    }
}
?>