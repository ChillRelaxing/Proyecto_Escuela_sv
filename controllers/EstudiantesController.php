<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/EstudiantesModel.php');
require_once(dirname(__FILE__) . '/../fpdf/fpdf.php');

class EstudiantesController
{
    private $db;
    private $estudiante;

    public function __construct()
    {
        // Conexión a la base de datos
        $database = new Conexion();
        $this->db = $database->Conectar();

        // Instanciamos el modelo Estudiantes
        $this->estudiante = new Estudiantes($this->db);
    }

    public function index()
    {
        $result = $this->estudiante->get_estudiantes();
        $estudiantes = $result->fetchAll(PDO::FETCH_ASSOC);

        include(dirname(__FILE__) . '/../views/Estudiantes/indexEstudiantes.php');
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Asignar datos del formulario
            $this->estudiante->nombre = $_POST['nombre'];
            $this->estudiante->apellido = $_POST['apellido'];
            $this->estudiante->correo = $_POST['correo'];
            $this->estudiante->telefono = $_POST['telefono'];
            $this->estudiante->carnet = $_POST['carnet'];
            $this->estudiante->modalidad = $_POST['modalidad'];

            // Validar si el carnet ya existe
            if ($this->estudiante->carnetExists($this->estudiante->carnet)) {
                echo '<div style="background-color: #ffcccb; color: #c70000; padding: 10px; border: 1px solid #c70000; border-radius: 5px; margin: 20px 0;">
        El carnet ya existe. Por favor, ingrese uno diferente.
      </div>';
            } elseif ($this->estudiante->create()) {
                // Guardar y redirigir si no hay error
                header("Location: ../routers/estudiantesRouter.php");
                exit();
            } else {
                echo "Error al guardar el estudiante.";
            }
        }

        include(dirname(__FILE__) . '/../views/Estudiantes/createEstudiantes.php');
    }


    public function edit($id)
    {
        $this->estudiante->id_estudiante = $id;
        $this->estudiante->get_estudiantes_by_id();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->estudiante->nombre = $_POST['nombre'];
            $this->estudiante->apellido = $_POST['apellido'];
            $this->estudiante->correo = $_POST['correo'];
            $this->estudiante->telefono = $_POST['telefono'];
            $this->estudiante->carnet = $_POST['carnet'];
            $this->estudiante->modalidad = $_POST['modalidad'];

            if ($this->estudiante->update()) {
                header("Location: ../routers/estudiantesRouter.php");
                exit();
            } else {
                echo "Error al actualizar el estudiante.";
            }
        }

        include(dirname(__FILE__) . '/../views/Estudiantes/updateEstudiantes.php');
    }

    public function confirmDelete($id)
    {
        $this->estudiante->id_estudiante = $id;
        $this->estudiante->get_estudiantes_by_id(); // Obtener los detalles del estudiante

        include(dirname(__FILE__) . '/../views/Estudiantes/deleteEstudiantes.php'); // Incluir la vista de confirmación
    }

    public function delete($id)
    {
        $this->estudiante->id_estudiante = $id;
        if ($this->estudiante->delete()) {
            header("Location: ../routers/estudiantesRouter.php");
            exit();
        } else {
            echo "Error al eliminar el estudiante.";
        }
    }

    /**BUSCADOR */
    public function Estudiante_buscan($query_est)
    {
        // Llamamos al método del modelo que realiza la búsqueda
        $result = $this->estudiante->search_estudiante($query_est);
        $estudiantes = $result->fetchAll(PDO::FETCH_ASSOC);

        // Generamos el HTML para mostrar los resultados
        $output_est = '';
        if (count($estudiantes) > 0) {
            foreach ($estudiantes as $estudiante) {
                $output_est .= '
                    <tr>
                        <td>' . $estudiante['id_estudiante'] . '</td>
                        <td>' . $estudiante['nombre'] . '</td>
                        <td>' . $estudiante['apellido'] . '</td>
                        <td>' . $estudiante['correo'] . '</td>
                        <td>' . $estudiante['telefono'] . '</td>
                        <td>' . $estudiante['carnet'] . '</td>
                        <td>' . $estudiante['modalidad'] . '</td>
                        <td>
                            <a href="../routers/estudiantesRouter.php?action=edit&id=' . $estudiante['id_estudiante'] . '" class="btn btn-warning btn-sm mb-1">Editar</a>
                            <a href="../routers/estudiantesRouter.php?action=confirmDelete&id=' . $estudiante['id_estudiante'] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                ';
            }
        } else {
            $output_est = '<tr><td colspan="4">No se encontraron considencias.</td></tr>';
        }

        echo $output_est;
    }

    // Función para exportar estudiantes a CSV
    public function exportToCSV()
    {
        // Recuperar los estudiantes
        $result = $this->estudiante->get_estudiantes();
        $estudiantes = $result->fetchAll(PDO::FETCH_ASSOC);

        // Nombre del archivo CSV
        $filename = "estudiantes_" . date('Y-m-d') . ".csv";

        // Cabeceras para forzar descarga
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Crear una tabla en formato CSV
        echo "ID,Nombre,Apellido,Correo,Telefono,Carnet,Modalidad\n";

        // Escribir los datos
        foreach ($estudiantes as $estudiante) {
            echo "{$estudiante['id_estudiante']},{$estudiante['nombre']},{$estudiante   ['apellido']},{$estudiante['correo']},{$estudiante['telefono']},{$estudiante['carnet']},{$estudiante['modalidad']}\n";
        }

        exit();
    }

    // Función para exportar estudiantes a Excel
    public function exportToExcel()
    {
        // Recuperar los estudiantes
        $result = $this->estudiante->get_estudiantes();
        $estudiantes = $result->fetchAll(PDO::FETCH_ASSOC);

        // Nombre del archivo Excel
        $filename = "estudiantes_" . date('Y-m-d') . ".xls";

        // Cabeceras para forzar descarga
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Crear una tabla HTML para Excel
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Correo</th><th>Telefono</  th><th>Carnet</th><th>Modalidad</th></tr>";

        // Escribir los datos
        foreach ($estudiantes as $estudiante) {
            echo "<tr>";
            echo "<td>{$estudiante['id_estudiante']}</td>";
            echo "<td>{$estudiante['nombre']}</td>";
            echo "<td>{$estudiante['apellido']}</td>";
            echo "<td>{$estudiante['correo']}</td>";
            echo "<td>{$estudiante['telefono']}</td>";
            echo "<td>{$estudiante['carnet']}</td>";
            echo "<td>{$estudiante['modalidad']}</td>";
            echo "</tr>";
        }

        echo "</table>";
        exit();
    }

    // Función para exportar estudiantes a PDF
    public function exportToPDF()
    {
        // Recuperar los estudiantes
        $result = $this->estudiante->get_estudiantes();
        $estudiantes = $result->fetchAll(PDO::FETCH_ASSOC);

        // Crear una instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Establecer fuente
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Estudiantes', 0, 1,     'C'); // Título centrado

        // Establecer encabezados de tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(8, 10, 'ID', 1);
        $pdf->Cell(22, 10, 'Nombre', 1);
        $pdf->Cell(22, 10, 'Apellido', 1);
        $pdf->Cell(60, 10, 'Correo', 1);
        $pdf->Cell(25, 10, 'Telefono', 1);
        $pdf->Cell(25, 10, 'Carnet', 1);
        $pdf->Cell(25, 10, 'Modalidad', 1);
        $pdf->Ln();

        // Establecer fuente para los datos
        $pdf->SetFont('Arial', '', 12);

        // Agregar los datos a la tabla
        foreach ($estudiantes as $estudiante) {
            $pdf->Cell(8, 10, $estudiante['id_estudiante'], 1);
            $pdf->Cell(22, 10, $estudiante['nombre'], 1);
            $pdf->Cell(22, 10, $estudiante['apellido'], 1);
            $pdf->Cell(60, 10, $estudiante['correo'], 1);
            $pdf->Cell(25, 10, $estudiante['telefono'], 1);
            $pdf->Cell(25, 10, $estudiante['carnet'], 1);
            $pdf->Cell(25, 10, $estudiante['modalidad'], 1);
            $pdf->Ln();
        }

        // Descargar el PDF
        $pdfFileName = "estudiantes_" . date('Y-m-d') . ".pdf";
        $pdf->Output('D', $pdfFileName);
        exit();
    }

}
?>