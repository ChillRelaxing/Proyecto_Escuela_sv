<?php

class Rol
{
    private $conn;
    private $table_name = "roles"; // Nombre de la tabla

    // Atributos que hacen referencia a los campos de la tabla
    public $id_rol;
    public $nombre;

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para crear un nuevo rol
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
            SET nombre = :nombre";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Limpiamos los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));

        // Enlazamos los parámetros
        $result->bindParam(":nombre", $this->nombre);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obtener todos los roles
    public function get_roles()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    // Método para obtener un rol por ID
    public function get_rol_by_id()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_rol = :id_rol";
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id_rol", $this->id_rol);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Asignamos los valores recuperados
        $this->nombre = $row['nombre'];
    }

    // Método para actualizar un rol
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
            SET nombre = :nombre
            WHERE id_rol = :id_rol";

        // Limpiamos los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->id_rol = htmlspecialchars(strip_tags($this->id_rol));

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos los parámetros
        $result->bindParam(":nombre", $this->nombre);
        $result->bindParam(":id_rol", $this->id_rol);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar un rol
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_rol = :id_rol";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id_rol", $this->id_rol);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }
}
?>
