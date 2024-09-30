<?php

class MateriasCursos
{
    private $conn;
    private $table_name = "materias_cursos"; // Nombre de la tabla

    // Atributos que hacen referencia a los campos de la tabla
    public $id_materia_curso;
    public $nombre;
    public $descripcion;

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para crear un nueva Materia del Curso
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
            SET nombre = :nombre,
                descripcion = :descripcion";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Limpiamos los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // Enlazamos los parámetros
        $result->bindParam(":nombre", $this->nombre);
        $result->bindParam(":descripcion", $this->descripcion);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obtener todas las Materia del Curso
    public function get_MateriasCursos()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    // Método para obtener una Materia del Curso por ID
    public function get_MateriasCursos_by_id()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_materia_curso = :id_materia_curso";
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id_materia_curso", $this->id_materia_curso);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Asignamos los valores recuperados
        $this->nombre = $row['nombre'];
        $this->descripcion = $row['descripcion'];
    }

    // Método para actualizar una Materia del Curso
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
            SET nombre = :nombre,
                descripcion = :descripcion
            WHERE id_materia_curso = :id_materia_curso";

        // Limpiamos los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->id_materia_curso = htmlspecialchars(strip_tags($this->id_materia_curso));

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos los parámetros
        $result->bindParam(":nombre", $this->nombre);
        $result->bindParam(":descripcion", $this->descripcion);
        $result->bindParam(":id_materia_curso", $this->id_materia_curso);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar una Materia del Curso
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_materia_curso = :id_materia_curso";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id_materia_curso", $this->id_materia_curso);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }
}
?>