<?php

class Estudiantes
{
    private $conn;
    private $table_name = "estudiantes"; // nombre de la tabla

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

    // Método para crear un producto
    public function create()
    {
        // Creamos la consulta
        /*
         los placeholders como :nombre, :descripcion etc.. son simplemente nombres que usas para enlazar los valores de las variables en tu código
         PHP con los valores que se insertan en la base de datos. Puedes cambiar el nombre de estos placeholders a cualquier cosa que desees
        */
        //Los otros campos si puntos son las columnas de la tabla la cual si debe se ser iguales a los de la base de datos
        $query = "INSERT INTO " . $this->table_name .
            " SET nombre = :nombre, apellido = :apellido, correo = :correo, telefono = :telefono, carnet = :carnet, modalidad = :modalidad";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Limpiamos el código
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

    // Método para obtener todos los productos
    public function get_estudiantes()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    // Método para obtener un producto por ID
    public function get_estudiantes_by_id()
{
    $query = "SELECT * FROM " . $this->table_name . " WHERE id_estudiante = :id_estudiante";
    $result = $this->conn->prepare($query);
    $result->bindParam(":id_estudiante", $this->id_estudiante); // Cambia :id a :id_estudiante
    $result->execute();

    $row = $result->fetch(PDO::FETCH_ASSOC);

    // Verifica si se encontró un estudiante
    if ($row) {
        $this->nombre = $row["nombre"];
        $this->apellido = $row["apellido"];
        $this->correo = $row["correo"];
        $this->telefono = $row["telefono"];
        $this->carnet = $row["carnet"];
        $this->modalidad = $row["modalidad"];
    } else {
        // Maneja el caso donde no se encuentra el estudiante
        echo "Estudiante no encontrado.";
    }
}


    // Método para actualizar un producto
    public function update()
{
    $query = "UPDATE " . $this->table_name .
        " SET nombre = :nombre, apellido = :apellido, correo = :correo, telefono = :telefono, carnet = :carnet, modalidad = :modalidad  
             WHERE id_estudiante = :id_estudiante";

    // Limpiamos el código
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
    $result->bindParam(":id_estudiante", $this->id_estudiante); // Asegúrate que coincida

    // Ejecutamos la consulta
    if ($result->execute()) {
        return true;
    }

    return false;
}


    // Método para eliminar un producto
    public function delete()
{
    $query = "DELETE FROM " . $this->table_name . " WHERE id_estudiante = :id_estudiante"; // Cambia a :id_estudiante

    // Preparamos la consulta
    $result = $this->conn->prepare($query);

    // Enlazamos el parámetro correcto
    $result->bindParam(":id_estudiante", $this->id_estudiante); // Cambia a :id_estudiante

    // Ejecutamos la consulta
    if ($result->execute()) {
        return true;
    }

    return false;
}
}