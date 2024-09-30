<?php

class Estudiantes
{
    private $conn;
    private $table_name = "estudiantes"; // Nombre de la tabla

    // Atributos que hacen referencia a los campos de la tabla
    public $id_estudiante;
    public $nombre;
    public $apellido;
    public $correo;
    public $telefono;
    public $carnet;
    public $modalidad;

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para crear un nuevo Estudiante
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
            SET nombre = :nombre,
                apellido = :apellido,
                correo = :correo,
                telefono = :telefono,
                carnet = :carnet,
                modalidad = :modalidad
                ";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Limpiamos los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->carnet = htmlspecialchars(strip_tags($this->carnet));
        $this->modalidad = htmlspecialchars(strip_tags($this->modalidad));

        // Enlazamos los parámetros
        $result->bindParam(":nombre", $this->nombre);
        $result->bindParam(":apellido", $this->apellido);
        $result->bindParam(":correo", $this->correo);
        $result->bindParam(":telefono", $this->telefono);
        $result->bindParam(":carnet", $this->carnet);
        $result->bindParam(":modalidad", $this->modalidad);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obtener todos los Estudiantes
    public function get_Estudiantes()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    // Método para obtener un Estudiante por ID
    public function get_Estudiantes_by_id()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_estudiante = :id_estudiante";
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id_estudiante", $this->id_estudiante);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Asignamos los valores recuperados
        $this->nombre = $row['nombre'];
        $this->nombre = $row['apellido'];
        $this->nombre = $row['correo'];
        $this->nombre = $row['telefono'];
        $this->nombre = $row['carnet'];
        $this->nombre = $row['modalidad'];
    }

    // Método para actualizar un estudiante
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
            SET nombre = :nombre,
                apellido = :apellido,
                correo = :correo,
                telefono = :telefono,
                carnet = :carnet,
                modalidad = :modalidad
            WHERE id_estudiante = :id_estudiante";

        // Limpiamos los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->carnet = htmlspecialchars(strip_tags($this->carnet));
        $this->modalidad = htmlspecialchars(strip_tags($this->modalidad));
        $this->id_estudiante = htmlspecialchars(strip_tags($this->id_estudiante));

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos los parámetros
        $result->bindParam(":nombre", $this->nombre);
        $result->bindParam(":apellido", $this->apellido);
        $result->bindParam(":correo", $this->correo);
        $result->bindParam(":telefono", $this->telefono);
        $result->bindParam(":carnet", $this->carnet);
        $result->bindParam(":modalidad", $this->modalidad);
        $result->bindParam(":id_estudiante", $this->id_estudiante);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar un estudiante
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_estudiante = :id_estudiante";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id_estudiante", $this->id_estudiante);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }
}
?>