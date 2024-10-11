<?php

class Reporte
{
    private $conn;
    private $table_name = "reportes"; // nombre de la tabla

    // Atributos que hacen referencia a los campos de la tabla
    public $id_reporte;            // Identificador único del reporte
    public $descripcion;           // Descripción del reporte
    public $fecha_reporte;         // Fecha del reporte
    public $id_estudiante;         // ID del estudiante relacionado con el reporte
    public $id_usuario;            // ID del usuario que creó el reporte
    public $id_materia_curso;      // ID de la materia o curso relacionado

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para crear un nuevo reporte
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name .
            " SET descripcion = :descripcion, fecha_reporte = :fecha_reporte, 
                   id_estudiante = :id_estudiante, id_usuario = :id_usuario, 
                   id_materia_curso = :id_materia_curso";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Limpiamos el código
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->fecha_reporte = htmlspecialchars(strip_tags($this->fecha_reporte));
        $this->id_estudiante = htmlspecialchars(strip_tags($this->id_estudiante));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->id_materia_curso = htmlspecialchars(strip_tags($this->id_materia_curso));

        // Enlazamos los parámetros
        $result->bindParam(":descripcion", $this->descripcion);
        $result->bindParam(":fecha_reporte", $this->fecha_reporte);
        $result->bindParam(":id_estudiante", $this->id_estudiante);
        $result->bindParam(":id_usuario", $this->id_usuario);
        $result->bindParam(":id_materia_curso", $this->id_materia_curso);

        // Ejecutamos la consulta
        return $result->execute();
    }

    // Método para obtener todos los reportes
    public function get_reportes()
    {
        // Consulta simplificada con JOIN para traer información relacionada de las otras tablas
        $query = "SELECT reportes.id_reporte, reportes.descripcion, reportes.fecha_reporte, 
                          estudiantes.nombre AS nombre_estudiante, 
                          usuarios.nombre  AS nombre_usuario, 
                          materias_cursos.nombre AS nombre_materia
                   FROM reportes
                   JOIN estudiantes ON reportes.id_estudiante = estudiantes.id_estudiante
                   JOIN usuarios ON reportes.id_usuario = usuarios.id_usuario
                   JOIN materias_cursos ON reportes.id_materia_curso = materias_cursos.id_materia_curso";

        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

   // Método para obtener un reporte por ID
   public function get_reporte_by_id()
   {
       $query = "SELECT id_reporte, descripcion, fecha_reporte, id_estudiante, id_usuario, id_materia_curso 
             FROM reportes 
             WHERE id_reporte = :id";

       $result = $this->conn->prepare($query);
       $result->bindParam(":id", $this->id_reporte);
       $result->execute();

       // Retorna el resultado como un array asociativo
       return $result->fetch(PDO::FETCH_ASSOC);
   }
    // Método para actualizar un reporte
    public function update()
    {
        $query = "UPDATE reportes 
                   SET descripcion = :descripcion, fecha_reporte = :fecha_reporte, 
                       id_estudiante = :id_estudiante, id_usuario = :id_usuario, 
                       id_materia_curso = :id_materia_curso 
                   WHERE id_reporte = :id";

        // Limpiamos el código
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->fecha_reporte = htmlspecialchars(strip_tags($this->fecha_reporte));
        $this->id_estudiante = htmlspecialchars(strip_tags($this->id_estudiante));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->id_materia_curso = htmlspecialchars(strip_tags($this->id_materia_curso));
        $this->id_reporte = htmlspecialchars(strip_tags($this->id_reporte));

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos los parámetros
        $result->bindParam(":descripcion", $this->descripcion);
        $result->bindParam(":fecha_reporte", $this->fecha_reporte);
        $result->bindParam(":id_estudiante", $this->id_estudiante);
        $result->bindParam(":id_usuario", $this->id_usuario);
        $result->bindParam(":id_materia_curso", $this->id_materia_curso);
        $result->bindParam(":id", $this->id_reporte);

        // Ejecutamos la consulta
        return $result->execute();
    }

    // Método para eliminar un reporte
    public function delete()
    {
        $query = "DELETE FROM reportes WHERE id_reporte = :id";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id", $this->id_reporte);

        // Ejecutamos la consulta
        return $result->execute();
    }

    // Obtener la lista de estudiantes
    public function get_estudiantes()
    {
        $query = "SELECT id_estudiante, nombre FROM estudiantes";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);  // Devuelve el resultado como un array asociativo
    }

    // Obtener la lista de usuarios (profesores o administradores)
    public function get_usuarios()
    {
        $query = "SELECT id_usuario, nombre FROM usuarios";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);  // Devuelve el resultado como un array asociativo
    }

    // Obtener la lista de materias/cursos
    public function get_materias()
    {
        $query = "SELECT id_materia_curso, nombre FROM materias_cursos";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);  // Devuelve el resultado como un array asociativo
    }
}
