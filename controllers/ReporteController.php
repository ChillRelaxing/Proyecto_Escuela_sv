<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/ReporteModel.php');

class ReportesController
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
        $this->reporte = new Reportes($this->db);
    }

    // Método para mostrar la lista de reportes
    public function index()
    {
        $result = $this->reporte->get_reportes();
        $reportes = $result->fetchAll(PDO::FETCH_ASSOC);

        // Llamamos la vista que muestra la lista de reportes
        include(dirname(__FILE__) . '/../views/indexReporte.php');
    }

    // Método para crear un nuevo reporte
    public function create()
    {
        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del reporte
            $this->reporte->titulo = $_POST['titulo'];
            $this->reporte->contenido = $_POST['contenido'];
            $this->reporte->fecha = $_POST['fecha'];

            if ($this->reporte->create()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error al crear el reporte.";
            }
        }

        // Incluimos la vista del formulario de creación
        include(dirname(__FILE__) . '/../views/createReporte.php');
    }

    // Método para editar un reporte
    public function edit($id)
    {
        // Cargamos el reporte que se desea editar
        $this->reporte->id = $id;
        $this->reporte->get_reporte_by_id();

        if ($_POST) {
            // Asignamos los datos del formulario a las propiedades del reporte
            $this->reporte->titulo = $_POST['titulo'];
            $this->reporte->contenido = $_POST['contenido'];
            $this->reporte->fecha = $_POST['fecha'];

            if ($this->reporte->update()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error al actualizar el reporte.";
            }
        }

        // Incluimos la vista del formulario de edición
        include(dirname(__FILE__) . '/../views/updateReporte.php');
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id)
    {
        // Cargamos el reporte que se desea eliminar
        $this->reporte->id = $id;
        $this->reporte->get_reporte_by_id();

        // Incluimos la vista del formulario de eliminación
        include(dirname(__FILE__) . '/../views/deleteReporte.php');
    }

    // Método para confirmar y eliminar un reporte
    public function delete()
    {
        if ($_POST && isset($_POST['id'])) {
            $this->reporte->id = $_POST['id'];

            // Lógica de eliminación
            if ($this->reporte->delete()) {
                header("Location: indexReporte.php"); // Redirigimos a la lista después de eliminar
                exit();
            } else {
                echo "Error al eliminar el reporte.";
            }
        } else {
            echo "ID no proporcionado.";
        }
    }

    
}
