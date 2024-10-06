<?php
require_once(dirname(__FILE__) . '/../config/conf.php');
require_once(dirname(__FILE__) . '/../models/EstudiantesModel.php');

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
            
            // Guardar y redirigir
            if ($this->estudiante->create()) {
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
}

?>