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

    public function get_reporte_by_id()
    {
        $query = "SELECT reportes.id_reporte, reportes.descripcion, reportes.fecha_reporte, 
                     reportes.id_estudiante, estudiantes.nombre AS nombre_estudiante, 
                     reportes.id_usuario, usuarios.nombre AS nombre_usuario, 
                     reportes.id_materia_curso, materias_cursos.nombre AS nombre_materia
              FROM reportes
              JOIN estudiantes ON reportes.id_estudiante = estudiantes.id_estudiante
              JOIN usuarios ON reportes.id_usuario = usuarios.id_usuario
              JOIN materias_cursos ON reportes.id_materia_curso = materias_cursos.id_materia_curso
              WHERE reportes.id_reporte = :id";

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

    public function search_reporte($query_reporte)
    {
        $query_reporte = "%" . $query_reporte . "%";

        $query = "SELECT reportes.id_reporte, reportes.descripcion, reportes.fecha_reporte, 
                          estudiantes.nombre AS nombre_estudiante, 
                          usuarios.nombre  AS nombre_usuario, 
                          materias_cursos.nombre AS nombre_materia
                   FROM reportes
                   JOIN estudiantes ON reportes.id_estudiante = estudiantes.id_estudiante
                   JOIN usuarios ON reportes.id_usuario = usuarios.id_usuario
                   JOIN materias_cursos ON reportes.id_materia_curso = materias_cursos.id_materia_curso
            WHERE estudiantes.nombre  LIKE :query_reporte OR usuarios.nombre LIKE :query_reporte OR materias_cursos.nombre LIKE :query_reporte";

        $result = $this->conn->prepare($query);
        $result->bindParam(':query_reporte', $query_reporte);
        $result->execute();
        return $result;
    }

    public function get_reportes_filtrados($id_estudiante = null, $id_materia_curso = null, $fecha_inicio = null, $fecha_fin = null)
    {
        $query = "SELECT r.id_reporte, e.nombre AS nombre_estudiante, m.nombre AS nombre_materia, 
                         u.nombre AS nombre_usuario, r.fecha_reporte, r.descripcion
                  FROM reportes r
                  JOIN estudiantes e ON r.id_estudiante = e.id_estudiante
                  JOIN materias_cursos m ON r.id_materia_curso = m.id_materia_curso
                  JOIN usuarios u ON r.id_usuario = u.id_usuario
                  WHERE 1=1";

        // Condiciones dinámicas de acuerdo con los filtros
        if (!empty($id_estudiante)) {
            $query .= " AND r.id_estudiante = :id_estudiante";
        }
        if (!empty($id_materia_curso)) {
            $query .= " AND r.id_materia_curso = :id_materia_curso";
        }
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $query .= " AND r.fecha_reporte BETWEEN :fecha_inicio AND :fecha_fin";
        }

        $stmt = $this->conn->prepare($query);

        // Enlaza parámetros
        if (!empty($id_estudiante)) {
            $stmt->bindParam(':id_estudiante', $id_estudiante);
        }
        if (!empty($id_materia_curso)) {
            $stmt->bindParam(':id_materia_curso', $id_materia_curso);
        }
        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
