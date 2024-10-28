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
        // Recuperar las asignaciones (ya es un array)
        $asignaciones = $this->estudianteMateria->get_estudiante_materia();

        // Nombre del archivo CSV
        $filename = "asignaciones_" . date('Y-m-d') . ".csv";

        // Cabeceras para forzar descarga
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Crear una tabla en formato CSV
        echo "ID,Nombre Estudiante,Apellido Estudiante,Nombre Materia\n";

        // Escribir los datos
        foreach ($asignaciones as $estudianteMateria) {
            echo "{$estudianteMateria['id_estudiante_materia']},{$estudianteMateria['nombre_estudiante']},{$estudianteMateria['apellido_estudiante']},{$estudianteMateria['nombre_materia']}\n";
        }

        exit();
    }

    // Función para exportar estudiantemateria a Excel
    public function exportToExcel()
    {
        // Recuperar las asignaciones (ya es un array)
        $asignaciones = $this->estudianteMateria->get_estudiante_materia();

        // Nombre del archivo Excel
        $filename = "asignaciones_" . date('Y-m-d') . ".xls";

        // Cabeceras para forzar descarga
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Crear una tabla HTML para Excel
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre Estudiante</th><th>Apellido Estudiante</th><th>Nombre Materia</th></tr>";

        // Escribir los datos
        foreach ($asignaciones as $estudianteMateria) {
            echo "<tr>";
            echo "<td>{$estudianteMateria['id_estudiante_materia']}</td>";
            echo "<td>{$estudianteMateria['nombre_estudiante']}</td>";
            echo "<td>{$estudianteMateria['apellido_estudiante']}</td>";
            echo "<td>{$estudianteMateria['nombre_materia']}</td>";
            echo "</tr>";
        }

        echo "</table>";
        exit();
    }

    // Función para exportar estudiantemateria a PDF
    public function exportToPDF()
    {
        // Recuperar las asignaciones (ya es un array)
        $asignaciones = $this->estudianteMateria->get_estudiante_materia();

        // Crear una instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Establecer fuente
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Asignaciones', 0, 1, 'C'); // Título centrado

        // Establecer encabezados de tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(30, 10, 'ID', 1);
        $pdf->Cell(50, 10, 'Nombre Estudiante', 1);
        $pdf->Cell(50, 10, 'Apellido Estudiante', 1);
        $pdf->Cell(60, 10, 'Nombre Materia', 1);
        $pdf->Ln();

        // Establecer fuente para los datos
        $pdf->SetFont('Arial', '', 12);

        // Agregar los datos a la tabla
        foreach ($asignaciones as $estudianteMateria) {
            $pdf->Cell(30, 10, $estudianteMateria['id_estudiante_materia'], 1);
            $pdf->Cell(50, 10, $estudianteMateria['nombre_estudiante'], 1);
            $pdf->Cell(50, 10, $estudianteMateria['apellido_estudiante'], 1);
            $pdf->Cell(60, 10, $estudianteMateria['nombre_materia'], 1);
            $pdf->Ln();
        }

        // Descargar el PDF
        $pdfFileName = "asignaciones_" . date('Y-m-d') . ".pdf";
        $pdf->Output('D', $pdfFileName);
        exit();
    }
}
?>