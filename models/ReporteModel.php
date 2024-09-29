<?php

class Reportes
{
    private $conn;
    private $table_name = "reportes"; // nombre de la tabla

    // Atributos que hacen referencia a los campos de la tabla
    public $id;
    public $titulo;
    public $contenido;
    public $fecha;

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para crear un nuevo reporte
    public function create()
    {
        // Creamos la consulta
        $query = "INSERT INTO " . $this->table_name . 
                 " SET titulo = :titulo, contenido = :contenido, fecha = :fecha";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Limpiamos el código
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->contenido = htmlspecialchars(strip_tags($this->contenido));
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));

        // Enlazamos los parámetros
        $result->bindParam(":titulo", $this->titulo);
        $result->bindParam(":contenido", $this->contenido);
        $result->bindParam(":fecha", $this->fecha);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obtener todos los reportes
    public function get_reportes()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    // Método para obtener un reporte por ID
    public function get_reporte_by_id()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $result = $this->conn->prepare($query);
        $result->bindParam(":id", $this->id);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Asignamos los valores de las columnas a los atributos
        $this->titulo = $row["titulo"];
        $this->contenido = $row["contenido"];
        $this->fecha = $row["fecha"];
    }

    // Método para actualizar un reporte
    public function update()
    {
        $query = "UPDATE " . $this->table_name . 
                 " SET titulo = :titulo, contenido = :contenido, fecha = :fecha 
                 WHERE id = :id";

        // Limpiamos el código
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->contenido = htmlspecialchars(strip_tags($this->contenido));
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos los parámetros
        $result->bindParam(":titulo", $this->titulo);
        $result->bindParam(":contenido", $this->contenido);
        $result->bindParam(":fecha", $this->fecha);
        $result->bindParam(":id", $this->id);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar un reporte
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
