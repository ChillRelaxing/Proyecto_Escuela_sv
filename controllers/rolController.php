<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/rolModel.php');
require_once(dirname(__FILE__) . '/../fpdf/fpdf.php');

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

    /**BUSCADOR */
    public function buscar($consulta)
    {
        // Llamamos al método del modelo que realiza la búsqueda
        $result = $this->rol->search_roles($consulta); // Aquí aseguramos que $this->rol no sea null
        $roles = $result->fetchAll(PDO::FETCH_ASSOC);

        // Generamos el HTML para mostrar los resultados
        $newTableDato = '';
        if (count($roles) > 0) {
            foreach ($roles as $rol) {
                $newTableDato .= '
                    <tr>
                        <td>' . $rol['id_rol'] . '</td>
                        <td>' . $rol['nombre'] . '</td>
                        <td>
                            <a href="../routers/rolesRouter.php?action=edit&id=' . $rol['id_rol'] . '" class="btn btn-warning btn-sm mb-1">Editar</a>
                            <a href="../routers/rolesRouter.php?action=confirmDelete&id=' . $rol['id_rol'] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                ';
            }
        } else {
            $newTableDato = '<tr><td colspan="4">No se encontraron roles.</td></tr>';
        }
        
        echo $newTableDato;
    }

    // Función para exportar roles a CSV
    public function exportToCSV()
    {
        // Recuperar los roles
        $result = $this->rol->get_roles();
        $roles = $result->fetchAll(PDO::FETCH_ASSOC);

        // Nombre del archivo CSV
        $filename = "roles_" . date('Y-m-d') . ".csv";

        // Cabeceras para forzar descarga
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Crear una tabla en formato CSV
        echo "ID,Nombre\n";

        // Escribir los datos
        foreach ($roles as $rol) {
            echo "{$rol['id_rol']},{$rol['nombre']}\n";
        }

        exit();
    }

    // Función para exportar roles a Excel
    public function exportToExcel()
    {
        // Recuperar los roles
        $result = $this->rol->get_roles();
        $roles = $result->fetchAll(PDO::FETCH_ASSOC);

        // Nombre del archivo Excel
        $filename = "roles_" . date('Y-m-d') . ".xls";

        // Cabeceras para forzar descarga
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Crear una tabla HTML para Excel
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th></tr>";

        // Escribir los datos
        foreach ($roles as $rol) {
            echo "<tr>";
            echo "<td>{$rol['id_rol']}</td>";
            echo "<td>{$rol['nombre']}</td>";
            echo "</tr>";
        }

        echo "</table>";
        exit();
    }

    // Función para exportar roles a PDF
    public function exportToPDF()
    {
        // Recuperar los roles
        $result = $this->rol->get_roles();
        $roles = $result->fetchAll(PDO::FETCH_ASSOC);

        // Crear una instancia de FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
    
        // Establecer fuente
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Roles', 0, 1, 'C'); // Título centrado

        // Calcular el ancho total de la tabla (20 + 40 = 60)
        $totalWidth = 60;
        $pageWidth = $pdf->GetPageWidth(); // Obtener el ancho de la página
        $xOffset = ($pageWidth - $totalWidth) / 2; // Calcular el desplazamiento desde la izquierda para centrar

        // Establecer encabezados de tabla y centrar
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetX($xOffset); // Desplazar X para centrar
        $pdf->Cell(20, 10, 'ID', 1);
        $pdf->Cell(40, 10, 'Nombre', 1);
        $pdf->Ln();

        // Establecer fuente para los datos
        $pdf->SetFont('Arial', '', 12);

        // Agregar los roles a la tabla y centrar
        foreach ($roles as $rol) {
            $pdf->SetX($xOffset); // Desplazar X para centrar cada fila
            $pdf->Cell(20, 10, $rol['id_rol'], 1);
            $pdf->Cell(40, 10, $rol['nombre'], 1);
            $pdf->Ln(); // Nueva línea
        }

        // Descargar el PDF
        $pdfFileName = "roles_" . date('Y-m-d') . ".pdf";
        $pdf->Output('D', $pdfFileName);
        exit();
    }
}
?>
