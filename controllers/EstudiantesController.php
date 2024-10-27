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
}
