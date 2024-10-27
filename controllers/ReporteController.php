<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/ReporteModel.php');
require_once(dirname(__FILE__) . '/../fpdf/fpdf.php');

class ReporteController
{
    private $db;
    private $reporte;

    // Constructor
    public function __construct()
    {
        // Capturamos la conexión a la base de datos
        $database = new Conexion();
        $this->db = $database->Conectar();

        // Instanciamos el modelo Reportes
        $this->reporte = new Reporte($this->db);
    }

    // Método para mostrar la lista de reportes
    public function index()
    {
        $result = $this->reporte->get_reportes();
        $reportes = $result->fetchAll(PDO::FETCH_ASSOC);

        // Obtener los datos de las tablas relacionadas para el formulario
        $estudiantes = $this->reporte->get_estudiantes();  // Obtener la lista de estudiantes
        $usuarios = $this->reporte->get_usuarios();        // Obtener la lista de usuarios
        $materias = $this->reporte->get_materias();        // Obtener la lista de materias/cursos

        // Llamamos la vista que muestra la lista de reportes
        include(dirname(__FILE__) . '/../views/reporte/indexReporte.php');
    }

    // Método para crear un nuevo reporte
    public function create()
    {
        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del reporte
            $this->reporte->descripcion = $_POST['descripcion'];
            $this->reporte->fecha_reporte = $_POST['fecha_reporte'];
            $this->reporte->id_estudiante = $_POST['id_estudiante'];
            $this->reporte->id_usuario = $_POST['id_usuario'];
            $this->reporte->id_materia_curso = $_POST['id_materia_curso'];

            if ($this->reporte->create()) {
                header("Location: ../routers/reporteRouter.php");
                exit();
            } else {
                echo "Error al crear el reporte.";
            }
        }

        // Obtener los datos de las tablas relacionadas para el formulario
        $estudiantes = $this->reporte->get_estudiantes();  // Obtener la lista de estudiantes
        $usuarios = $this->reporte->get_usuarios();        // Obtener la lista de usuarios
        $materias = $this->reporte->get_materias();        // Obtener la lista de materias/cursos

        // Incluimos la vista del formulario de creación
        include(dirname(__FILE__) . '/../views/reporte/createReporte.php');
    }

    public function edit($id)
    {
        // Cargamos el reporte que se desea editar
        $this->reporte->id_reporte = $id;
        $reporte = $this->reporte->get_reporte_by_id();

        // Verifica si el reporte fue encontrado
        if (!$reporte) {
            header("Location: ../routers/reporteRouter.php?error=not_found");
            exit();
        }

        // Obtener los datos de las tablas relacionadas para el formulario
        $estudiantes = $this->reporte->get_estudiantes();
        $usuarios = $this->reporte->get_usuarios();
        $materias = $this->reporte->get_materias();

        // Verificar si se recibió una solicitud POST para actualizar
        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del reporte
            $this->reporte->descripcion = $_POST['descripcion'];
            $this->reporte->fecha_reporte = $_POST['fecha_reporte'];
            $this->reporte->id_estudiante = $_POST['id_estudiante'];
            $this->reporte->id_usuario = $_POST['id_usuario'];
            $this->reporte->id_materia_curso = $_POST['id_materia_curso'];

            if ($this->reporte->update()) {
                header("Location: ../routers/reporteRouter.php");
                exit();
            } else {
                echo "Error al actualizar el reporte.";
            }
        }

        // Incluimos la vista del formulario de edición y pasamos los datos
        include(dirname(__FILE__) . '/../views/reporte/updateReporte.php');
    }


    public function confirmDelete($id)
    {
        // Cargamos el reporte que se desea eliminar
        $this->reporte->id_reporte = $id;
        $reporte = $this->reporte->get_reporte_by_id(); // Asegúrate de que este método retorna el reporte

        if (!$reporte) {
            // Maneja el caso en que el reporte no se encuentra
            echo "Reporte no encontrado.";
            return; // Salimos de la función
        }

        // Incluimos la vista del formulario de eliminación
        include(dirname(__FILE__) . '/../views/reporte/deleteReporte.php');
    }


    // Método para confirmar y eliminar un reporte
    public function delete()
    {
        if ($_POST && isset($_POST['id'])) {
            $this->reporte->id_reporte = $_POST['id'];

            // Lógica de eliminación
            if ($this->reporte->delete()) {
                header("Location: ../routers/reporteRouter.php"); // Redirigimos a la lista después de eliminar
                exit();
            } else {
                echo "Error al eliminar el reporte.";
            }
        } else {
            echo "ID no proporcionado.";
        }
    }


    /**BUSCADOR */
    public function buscando($query_reporte)
    {
        // Llamamos al método del modelo que realiza la búsqueda
        $result = $this->reporte->search_reporte($query_reporte);
        $reportes = $result->fetchAll(PDO::FETCH_ASSOC);

        // Generamos el HTML para mostrar los resultados
        $output_report = '';
        if (count($reportes) > 0) {
            foreach ($reportes as $reporte) {
                $output_report .= '
                    <tr>
                        <td>' . $reporte['id_reporte'] . '</td>
                        <td>' . $reporte['descripcion'] . '</td>
                        <td>' . $reporte['fecha_reporte'] . '</td>
                        <td>' . $reporte['nombre_estudiante'] . '</td>
                        <td>' . $reporte['nombre_usuario'] . '</td>
                        <td>' . $reporte['nombre_materia'] . '</td>

                        <td>
                            <a href="../routers/reporteRouter.php?action=edit&id=' . $reporte['id_reporte'] . '" class="btn btn-warning btn-sm mb-1">Editar</a>
                            <a href="../routers/reporteRouter.php?action=confirmDelete&id=' . $reporte['id_reporte'] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                ';
            }
        } else {
            $output_report = '<tr><td colspan="4">No se encontraron considencias.</td></tr>';
        }

        echo $output_report;
    }

    // Función para exportar reportes a CSV
    public function exportToCSV()
    {
        $id_estudiante = isset($_GET['id_estudiante']) ? $_GET['id_estudiante'] : null;
        $id_materia_curso = isset($_GET['id_materia_curso']) ? $_GET['id_materia_curso'] : null;
        $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
        $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

        $reportes = $this->reporte->get_reportes_filtrados($id_estudiante, $id_materia_curso, $fecha_inicio, $fecha_fin);

        $filename = "reportes_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Limpiar salida
        ob_clean();

        echo "ID,Descripción,Fecha,Estudiante,Profesor,Materia\n";
        foreach ($reportes as $reporte) {
            echo "{$reporte['id_reporte']},{$reporte['descripcion']},{$reporte['fecha_reporte']},{$reporte['nombre_estudiante']},{$reporte['nombre_usuario']},{$reporte['nombre_materia']}\n";
        }

        exit();
    }

    // Función para exportar reportes a Excel
    public function exportToExcel()
    {
        $id_estudiante = isset($_GET['id_estudiante']) ? $_GET['id_estudiante'] : null;
        $id_materia_curso = isset($_GET['id_materia_curso']) ? $_GET['id_materia_curso'] : null;
        $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
        $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

        $reportes = $this->reporte->get_reportes_filtrados($id_estudiante, $id_materia_curso, $fecha_inicio, $fecha_fin);

        $filename = "reportes_" . date('Y-m-d') . ".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Limpiar salida
        ob_clean();

        // Agregar BOM para UTF-8
        echo "\xEF\xBB\xBF"; // Esto es el BOM

        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Descripción</th><th>Fecha</th><th>Estudiante</th><th>Profesor</th><th>Materia</th></tr>";
        foreach ($reportes as $reporte) {
            echo "<tr>";
            echo "<td>{$reporte['id_reporte']}</td>";
            echo "<td>{$reporte['descripcion']}</td>";
            echo "<td>{$reporte['fecha_reporte']}</td>";
            echo "<td>{$reporte['nombre_estudiante']}</td>";
            echo "<td>{$reporte['nombre_usuario']}</td>";
            echo "<td>{$reporte['nombre_materia']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        exit();
    }

    public function exportToPDF()
    {
        $id_estudiante = isset($_GET['id_estudiante']) ? $_GET['id_estudiante'] : null;
        $id_materia_curso = isset($_GET['id_materia_curso']) ? $_GET['id_materia_curso'] : null;
        $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
        $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
    
        $reportes = $this->reporte->get_reportes_filtrados($id_estudiante, $id_materia_curso, $fecha_inicio, $fecha_fin);
    
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Reportes', 0, 1, 'C');
    
        // Cambié el tamaño de fuente del encabezado a 8
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(8, 10, 'ID', 1);
        $pdf->Cell(75, 10, 'Descripcion', 1);
        $pdf->Cell(25, 10, 'Fecha', 1);
        $pdf->Cell(30, 10, 'Estudiante', 1);
        $pdf->Cell(30, 10, 'Profesor', 1);
        $pdf->Cell(25, 10, 'Materia', 1);
        $pdf->Ln();
    
        $pdf->SetFont('Arial', '', 8); // Tamaño de fuente para los datos
        foreach ($reportes as $reporte) {
            $pdf->Cell(8, 10, utf8_decode($reporte['id_reporte']), 1);
    
            // Usar MultiCell para la descripción
            $pdf->Cell(75, 10, utf8_decode($reporte['descripcion']), 1, 0, 'L', false);
            $pdf->Cell(25, 10, utf8_decode($reporte['fecha_reporte']), 1);
            $pdf->Cell(30, 10, utf8_decode($reporte['nombre_estudiante']), 1);
            $pdf->Cell(30, 10, utf8_decode($reporte['nombre_usuario']), 1);
            $pdf->Cell(25, 10, utf8_decode($reporte['nombre_materia']), 1);
            $pdf->Ln();
        }
    
        $pdf->Output();
    }
    
}
