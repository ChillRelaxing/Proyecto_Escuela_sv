<?php

class Usuario
{
    private $conn;
    private $table_name = "usuarios"; // Nombre de la tabla

    // Atributos que hacen referencia a los campos de la tabla
    public $id_usuario;
    public $nombre;
    public $apellido;
    public $correo;
    public $password;
    public $id_rol;

    // Constructor de la clase
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Método para crear un nuevo usuario
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
            SET nombre = :nombre, apellido = :apellido, correo = :correo, password = :password, id_rol = :id_rol";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Limpiamos los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->id_rol = htmlspecialchars(strip_tags($this->id_rol));

        // Enlazamos los parámetros
        $result->bindParam(":nombre", $this->nombre);
        $result->bindParam(":apellido", $this->apellido);
        $result->bindParam(":correo", $this->correo);
        $result->bindParam(":password", $this->password);
        $result->bindParam(":id_rol", $this->id_rol);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Método para obtener todos los usuarios
    public function get_usuarios()
    {
        //consulta para que muestre el nm del rol en la vista
        $query =  "SELECT usuarios.*, r.nombre AS nombre_rol FROM " . $this->table_name . " usuarios
              JOIN roles r ON usuarios.id_rol = r.id_rol";
        $result = $this->conn->prepare($query);
        $result->execute();
        return $result;
    }

    // Método para obtener un usuario por ID
    public function get_usuario_by_id()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_usuario = :id_usuario";
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id_usuario", $this->id_usuario);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Asignamos los valores recuperados
        $this->nombre = $row['nombre'];
        $this->apellido = $row['apellido'];
        $this->correo = $row['correo'];
        $this->password = $row['password'];
        $this->id_rol = $row['id_rol'];

    }

    // Método para actualizar un usuario
    public function update()
    {
         // consulta que sino se proporcionó una nueva contraseña, no la actualizamos
        $query = "UPDATE " . $this->table_name . " 
        SET nombre = :nombre, apellido = :apellido, correo = :correo, id_rol = :id_rol" .
        (!empty($this->password) ? ", password = :password" : "") . "
        WHERE id_usuario = :id_usuario";

        /*$query = "UPDATE " . $this->table_name . " 
            SET nombre = :nombre, apellido = :apellido, correo = :correo, password = :password, id_rol = :id_rol
            WHERE id_usuario = :id_usuario";*/

        // Limpiamos los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->id_rol = htmlspecialchars(strip_tags($this->id_rol));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

         // Enlazamos los parámetros
        $result->bindParam(":nombre", $this->nombre);
        $result->bindParam(":apellido", $this->apellido);
        $result->bindParam(":correo", $this->correo);
        if (!empty($this->password)) {
            $result->bindParam(":password", $this->password);
        }
        $result->bindParam(":id_rol", $this->id_rol);
        $result->bindParam(":id_usuario", $this->id_usuario);


        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }

    // Método para eliminar un usuario
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_usuario = :id_usuario";

        // Preparamos la consulta
        $result = $this->conn->prepare($query);

        // Enlazamos el parámetro
        $result->bindParam(":id_usuario", $this->id_usuario);

        // Ejecutamos la consulta
        if ($result->execute()) {
            return true;
        }

        return false;
    }

       // Obtener la lista de estudiantes y pasarla al controller
       public function get_roles()
       {
           $query = "SELECT id_rol, nombre FROM roles";
           $result = $this->conn->prepare($query);
           $result->execute();
           return $result->fetchAll(PDO::FETCH_ASSOC);  // Devuelve el resultado como un array asociativo
       }
}
?>
