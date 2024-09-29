<?php

class EstudianteMateria
{
    private $conn;
    private $table_name = "estudiante_materia"; // Nombre de la tabla

    // Atributos que hacen referencia a los campos de la tabla
    public $id;
    public $id_estudiante;
    public $id_materia_curso;

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para crear una asignación estudiante-materia
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
            SET id_estudiante = :id_estudiante, id_materia_curso = :id_materia_curso";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Limpiamos los datos
        $this->id_estudiante = htmlspecialchars(strip_tags($this->id_estudiante));
        $this->id_materia_curso = htmlspecialchars(strip_tags($this->id_materia_curso));

        // Enlazamos los parámetros
        $result->bindParam(":id_estudiante", $this->id_estudiante);
        $result->bindParam(":id_materia_curso", $this->id_materia_curso);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obtener todas las asignaciones estudiante-materia
    public function get_estudiante_materia()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    // Método para obtener una asignación por ID
    public function get_estudiante_materia_by_id()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id", $this->id);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Asignamos los valores recuperados
        $this->id_estudiante = $row['id_estudiante'];
        $this->id_materia_curso = $row['id_materia_curso'];
    }

    // Método para actualizar una asignación estudiante-materia
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
            SET id_estudiante = :id_estudiante, id_materia_curso = :id_materia_curso
            WHERE id = :id";

        // Limpiamos los datos
        $this->id_estudiante = htmlspecialchars(strip_tags($this->id_estudiante));
        $this->id_materia_curso = htmlspecialchars(strip_tags($this->id_materia_curso));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos los parámetros
        $result->bindParam(":id_estudiante", $this->id_estudiante);
        $result->bindParam(":id_materia_curso", $this->id_materia_curso);
        $result->bindParam(":id", $this->id);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar una asignación estudiante-materia
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id", $this->id);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }
}
?>
