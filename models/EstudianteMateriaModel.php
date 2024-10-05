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
        return $result->execute();
    }

    // Método para obtener todas las asignaciones estudiante-materia
    public function get_estudiante_materia()
    {
        $query = "
        SELECT em.id_estudiante_materia, 
               e.nombre AS nombre_estudiante, 
               e.apellido AS apellido_estudiante, 
               mc.nombre AS nombre_materia
        FROM estudiante_materia em
        JOIN estudiantes e ON em.id_estudiante = e.id_estudiante
        JOIN materias_cursos mc ON em.id_materia_curso = mc.id_materia_curso
    ";

        $result = $this->conn->prepare($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC); // Devuelve un array de resultados
    }

    // Método para obtener una asignación por ID
    public function get_estudiante_materia_by_id($id)
    {
        // Consulta modificada para incluir el nombre y apellido del estudiante y el nombre de la materia
        $query = "
         SELECT em.id_estudiante_materia, 
                e.nombre AS nombre_estudiante, 
                e.apellido AS apellido_estudiante, 
                mc.nombre AS nombre_materia,
                em.id_estudiante,  -- ID del estudiante para el formulario de edición
                em.id_materia_curso -- ID de la materia para el formulario de edición
         FROM estudiante_materia em
         JOIN estudiantes e ON em.id_estudiante = e.id_estudiante
         JOIN materias_cursos mc ON em.id_materia_curso = mc.id_materia_curso
         WHERE em.id_estudiante_materia = :id";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id", $id);
        $result->execute();

        // Obtenemos el registro
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Verifica si se encontró el registro
        if ($row) {
            // Asignamos los valores recuperados a las propiedades de la clase
            $this->id_estudiante = $row['id_estudiante']; // Asigna el ID del estudiante
            $this->id_materia_curso = $row['id_materia_curso']; // Asigna el ID de la materia
            $this->id = $row['id_estudiante_materia']; // Asigna el ID de la asignación
            return $row; // Retorna el registro completo
        }

        return null; // Si no se encuentra, retorna null
    }

    // Método para actualizar una asignación estudiante-materia
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
        SET id_estudiante = :id_estudiante, id_materia_curso = :id_materia_curso
        WHERE id_estudiante_materia = :id";

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
        return $result->execute();
    }

    // Método para eliminar una asignación estudiante-materia
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_estudiante_materia = :id"; // Corrección aquí

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id", $this->id);

        // Ejecutamos la consulta
        return $result->execute();
    }

    // Método para obtener todos los estudiantes
    public function get_estudiantes()
    {
        $query = "SELECT id_estudiante, nombre, apellido FROM estudiantes";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC); // Cambiado para mantener la consistencia
    }

    // Método para obtener todas las materias
    public function get_materias_cursos()
    {
        $query = "SELECT id_materia_curso, nombre FROM materias_cursos";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC); // Cambiado para mantener la consistencia
    }
}
