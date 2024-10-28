<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/MateriasCursosModel.php');
require_once(dirname(__FILE__) . '/../fpdf/fpdf.php');

class MateriasCursosController
{
    private $db;
    private $materiacurso;

    // Constructor
    public function __construct()
    {
        // Capturamos la conexión a la base de datos
        $database = new Conexion();
        $this->db = $database->Conectar();

        // Instanciamos el modelo MateriasCursos
        $this->materiacurso = new MateriasCursos($this->db);
    }

    // Método para mostrar la lista de MateriasCursos
    public function index()
    {
        $result = $this->materiacurso->get_MateriasCursos();
        $materiacurso = $result->fetchAll(PDO::FETCH_ASSOC);

        // Llamamos la vista que muestra la lista de MateriasCursos
        include(dirname(__FILE__) . '/../views/MateriasCursos/indexMateriasCursos.php');
    }

    // Método para crear un nueva MateriasCursos
    public function create()
    {
        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->materiacurso->nombre = $_POST['nombre'];
            $this->materiacurso->descripcion = $_POST['descripcion'];

            // Redirigimos a la lista de MateriasCursos después de crear la MateriaCurso
            if ($this->materiacurso->create()) {
                header("Location: ../routers/materiasCursosRouter.php");
                exit();
            } else {
                echo "Error al crear la Materia.";
            }
        }

        // Incluimos la vista del formulario de creación de MateriasCursos
        include(dirname(__FILE__) . '/../views/MateriasCursos/createMateriasCursos.php');
    }

    // Método para editar un MateriaCurso
    public function edit($id_materia_curso)
    {
        // Cargamos el rol que se desea editar
        $this->materiacurso->id_materia_curso = $id_materia_curso;
        $this->materiacurso->get_MateriasCursos_by_id();

        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->materiacurso->nombre = $_POST['nombre'];
            $this->materiacurso->descripcion = $_POST['descripcion'];

            // Redirigimos a la lista de roles después de actualizar
            if ($this->materiacurso->update()) {
                header("Location: ../routers/materiasCursosRouter.php");
                exit();
            } else {
                echo "Error al actualizar la materia.";
            }
        }

        // Incluimos la vista del formulario de edición
        include(dirname(__FILE__) . '/../views/MateriasCursos/updateMateriasCursos.php');
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id_materia_curso)
    {
        // Cargamos el rol que se desea eliminar
        $this->materiacurso->id_materia_curso = $id_materia_curso;
        $this->materiacurso->get_MateriasCursos_by_id();

        // Incluimos la vista de confirmación de eliminación
        include(dirname(__FILE__) . '/../views/MateriasCursos/deleteMateriasCursos.php');
    }

    // Método para confirmar y eliminar una materia
    public function delete()
    {
        if ($_POST && isset($_POST['id_materia_curso'])) {
            $this->materiacurso->id_materia_curso = $_POST['id_materia_curso'];

            // Lógica de eliminación
            if ($this->materiacurso->delete()) {
                header("Location: indexMateriasCursos.php");
                exit();
            } else {
                echo "Error al eliminar la materia.";
            }
        } else {
            echo "ID de rol no proporcionado.";
        }
    }

    /**BUSCADOR */
    public function materiacurso_buscar($query_mt_curso)
    {
        // Llamamos al método del modelo que realiza la búsqueda
        $result = $this->materiacurso->search_materiacurso($query_mt_curso);
        $materiacurso = $result->fetchAll(PDO::FETCH_ASSOC);

        // Generamos el HTML para mostrar los resultados
        $output_mt_curso= '';
        if (count($materiacurso) > 0) {
            foreach ($materiacurso as $materiacursos) {
                $output_mt_curso .= '
                    <tr>
                        <td>' . $materiacursos['id_materia_curso'] . '</td>
                        <td>' . $materiacursos['nombre'] . '</td>
                        <td>' . $materiacursos['descripcion'] . '</td>
                        <td>
                            <a href="../routers/materiasCursosRouter.php?action=edit&id=' . $materiacursos['id_materia_curso'] . '" class="btn btn-warning btn-sm mb-1">Editar</a>
                            <a href="../routers/materiasCursosRouter.php?action=confirmDelete&id=' . $materiacursos['id_materia_curso'] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                ';
            }
        } else {
            $output_mt_curso= '<tr><td colspan="4">No se encontraron considencias.</td></tr>';
        }
        
        echo $output_mt_curso;
    }

    // Función para exportar materiascursos a CSV
    public function exportToCSV()
    {

    }

    // Función para exportar materiascursos a Excel
    public function exportToExcel()
    {

    }

    // Función para exportar materiascursos a PDF
    public function exportToPDF()
    {
        
    }
}
?>