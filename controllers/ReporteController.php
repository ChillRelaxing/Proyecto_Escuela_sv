<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/ReporteModel.php');

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

        // Incluimos la vista del formulario de creación
        include(dirname(__FILE__) . '/../views/reporte/createReporte.php');
    }

    // Método para editar un reporte
    public function edit($id)
    {
        // Cargamos el reporte que se desea editar
        $this->reporte->id_reporte = $id;
        $this->reporte->get_reporte_by_id();

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

        // Incluimos la vista del formulario de edición
        include(dirname(__FILE__) . '/../views/reporte/updateReporte.php');
    }

    // Método para mostrar la vista de confirmación de eliminación
    public function confirmDelete($id)
    {
        // Cargamos el reporte que se desea eliminar
        $this->reporte->id_reporte = $id;
        $this->reporte->get_reporte_by_id();

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
}
