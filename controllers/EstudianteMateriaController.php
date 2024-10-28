<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/EstudianteMateriaModel.php');
require_once(dirname(__FILE__) . '/../fpdf/fpdf.php');

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
        // Obtén las asignaciones directamente como un array
        $asignaciones = $this->estudianteMateria->get_estudiante_materia(); // Llama al método que devuelve un array de datos

        // Llamamos la vista que muestra la lista de asignaciones
        include(dirname(__FILE__) . '/../views/estudianteMateria/indexEstudianteMateria.php');
    }

    // Método para asignar un estudiante a una materia
    public function create()
    {
        // Obtener estudiantes y materias
        $estudiantes = $this->estudianteMateria->get_estudiantes(); // Cambiar aquí
        $materias = $this->estudianteMateria->get_materias_cursos(); // Cambiar aquí

        if ($_POST) {
            $this->estudianteMateria->id_estudiante = $_POST['id_estudiante'];
            $this->estudianteMateria->id_materia_curso = $_POST['id_materia_curso'];

            $this->estudianteMateria->create();
            header("Location: ../routers/estudianteMateriaRouter.php");
            exit();
        }

        include(dirname(__FILE__) . '/../views/estudianteMateria/createEstudianteMateria.php');
    }

    // Método para editar una asignación
    public function edit($id)
    {
        // Cargamos la asignación que se desea editar
        $this->estudianteMateria->id = $id;
        $asignacion = $this->estudianteMateria->get_estudiante_materia_by_id($id); // Almacena el resultado

        // Verifica si la asignación fue encontrada
        if (!$asignacion) {
            echo "<div class='alert alert-danger'>No se encontró la asignación.</div>";
            exit();
        }

        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del objeto
            $this->estudianteMateria->id_estudiante = $_POST['id_estudiante'];
            $this->estudianteMateria->id_materia_curso = $_POST['id_materia_curso'];

            // Redirigimos a la lista de asignaciones después de actualizar
            $this->estudianteMateria->update();
            header("Location: ../routers/estudianteMateriaRouter.php");
            exit();
        }

        // Incluimos la vista del formulario de edición
        include(dirname(__FILE__) . '/../views/estudianteMateria/updateEstudianteMateria.php');
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id)
    {
        // Cargamos la asignación que se desea eliminar
        $this->estudianteMateria->id = $id;
        $asignacion = $this->estudianteMateria->get_estudiante_materia_by_id($id);

        // Verificamos si la asignación fue encontrada
        if (!$asignacion) {
            echo "<div class='alert alert-danger'>No se encontró la asignación.</div>";
            exit();
        }

        // Incluimos la vista de confirmación de eliminación
        include(dirname(__FILE__) . '/../views/estudianteMateria/deleteEstudianteMateria.php');
    }


    // Método para confirmar y eliminar una asignación
    public function delete()
    {
        if ($_POST && isset($_POST['id'])) {
            $this->estudianteMateria->id = $_POST['id'];

            // Lógica de eliminación
            if ($this->estudianteMateria->delete()) {
                header("Location: ../routers/estudianteMateriaRouter.php");
                exit();
            } else {
                echo "Error al eliminar la asignación.";
            }
        } else {
            echo "ID no proporcionado.";
        }
    }
    
    /**BUSCADOR */
    public function buscan($query_em)
    {
        // Llamamos al método del modelo que realiza la búsqueda
        $result = $this->estudianteMateria->search_estudianteMateria($query_em);
        $asignaciones = $result->fetchAll(PDO::FETCH_ASSOC);

        // Generamos el HTML para mostrar los resultados
        $output_em = '';
        if (count($asignaciones) > 0) {
            foreach ($asignaciones as $asignacion) {
                $output_em .= '
                    <tr>
                        <td>' . $asignacion['id_estudiante_materia'] . '</td>
                        <td>' . $asignacion['nombre_estudiante'] . '</td>
                        <td>' . $asignacion['apellido_estudiante'] . '</td>
                        <td>' . $asignacion['nombre_materia'] . '</td>

                        <td>
                            <a href="../routers/estudianteMateriaRouter.php?action=edit&id=' . $asignacion['id_estudiante_materia'] . '" class="btn btn-warning btn-sm mb-1">Editar</a>
                            <a href="../routers/estudianteMateriaRouter.php?action=confirmDelete&id=' . $asignacion['id_estudiante_materia'] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                ';
            }
        } else {
            $output_em= '<tr><td colspan="4">No se encontraron considencias.</td></tr>';
        }
        
        echo $output_em;
    }
    
    // Función para exportar estudiantemateria a CSV
    public function exportToCSV()
    {

    }

    // Función para exportar estudiantemateria a Excel
    public function exportToExcel()
    {

    }

    // Función para exportar estudiantemateria a PDF
    public function exportToPDF()
    {
        
    }
}
?>