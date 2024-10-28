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
        $materiacursos = $result->fetchAll(PDO::FETCH_ASSOC);

        // Generamos el HTML para mostrar los resultados
        $output_mt_curso= '';
        if (count($materiacursos) > 0) {
            foreach ($materiacursos as $materiacurso) {
                $output_mt_curso .= '
                    <tr>
                        <td>' . $materiacurso['id_materia_curso'] . '</td>
                        <td>' . $materiacurso['nombre'] . '</td>
                        <td>' . $materiacurso['descripcion'] . '</td>
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
        // Recuperar los cursos
        $result = $this->materiacurso->get_MateriasCursos();
        $cursos = $result->fetchAll(PDO::FETCH_ASSOC);

        // Nombre del archivo CSV
        $filename = "cursos_" . date('Y-m-d') . ".csv";

        // Cabeceras para forzar descarga
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Crear una tabla en formato CSV
        echo "ID,Nombre,Descripcion\n";

        // Escribir los datos
        foreach ($cursos as $materiacurso) {
            echo "{$materiacurso['id_materia_curso']},{$materiacurso['nombre']},{$materiacurso['descripcion']}\n";
        }

        exit();
    }

    // Función para exportar materiascursos a Excel
    public function exportToExcel()
    {
        // Recuperar los cursos
        $result = $this->materiacurso->get_MateriasCursos();
        $cursos = $result->fetchAll(PDO::FETCH_ASSOC);

        // Nombre del archivo Excel
        $filename = "cursos_" . date('Y-m-d') . ".xls";

        // Cabeceras para forzar descarga
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Crear una tabla HTML para Excel
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Descripcion</th></tr>";

        // Escribir los datos
        foreach ($cursos as $materiacurso) {
            echo "<tr>";
            echo "<td>{$materiacurso['id_materia_curso']}</td>";
            echo "<td>{$materiacurso['nombre']}</td>";
            echo "<td>{$materiacurso['descripcion']}</td>";
            echo "</tr>";
        }

        echo "</table>";
        exit();
    }

    // Función para exportar materiascursos a PDF
    public function exportToPDF()
    {
        // Recuperar los cursos
        $result = $this->materiacurso->get_MateriasCursos();
        $cursos = $result->fetchAll(PDO::FETCH_ASSOC);

        // Crear una instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Establecer fuente
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Cursos', 0, 1, 'C'); // Título centrado

        // Establecer encabezados de tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 10, 'ID', 1);
        $pdf->Cell(50, 10, 'Nombre', 1);
        $pdf->Cell(80, 10, 'Descripcion', 1);
        $pdf->Ln();

        // Establecer fuente para los datos
        $pdf->SetFont('Arial', '', 12);

        // Agregar los datos a la tabla
        foreach ($cursos as $materiacurso) {
            $pdf->Cell(30, 10, $materiacurso['id_materia_curso'], 1);
            $pdf->Cell(50, 10, $materiacurso['nombre'], 1);
            $pdf->Cell(80, 10, $materiacurso['descripcion'], 1);
            $pdf->Ln();
        }

        // Descargar el PDF
        $pdfFileName = "cursos_" . date('Y-m-d') . ".pdf";
        $pdf->Output('D', $pdfFileName);
        exit();
    }
}
?>