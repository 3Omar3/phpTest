<?php
require_once './db/db.class.php';

class AdminService {
   public static function login($email, $password) {
        $database = new Database();
        $conn = $database->getConnection();
    
        // Busca el usuario por su nombre de usuario
        $sql = "SELECT * FROM admins WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            // Verificar la contraseña usando password_verify
            if (password_verify($password, $user['password'])) {
                // Si las credenciales son correctas, devolver el usuario
                unset($user['password']); // No enviar la contraseña en la respuesta
                return ["success" => true, "message" => "Login successful", "user" => $user];
            } else {
                header("HTTP/1.1 300 Invalid");
                return ["success" => false, "message" => "Invalid"];
            }
        } else {
            header("HTTP/1.1 300 Invalid");
            return ["success" => false, "message" => "Not found"];
        }
    }   

    public static function create($email, $password) {
        $database = new Database();
        $conn = $database->getConnection();

        // Verificar datos
        if (empty($email) || empty($password)) {
            return ["success" => false, "message" => "Email and password are required."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format."];
        }

        // Hashear contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insertar en la base de datos
        $sql = "INSERT INTO admins (email, password) VALUES (:email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        try {
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                    header("HTTP/1.1 201 Created");
                    return ["success" => true, "message" => "Admin created successfully"];
            }
    
            header("HTTP/1.1 400 Bad Request");
            return ["success" => false, "message" => "Admin to create admin"];
        } catch (\Throwable $th) {
            header("HTTP/1.1 400 Bad Request");
            return ["success" => false, "message" => "Failed to create admin, email has been already registered"];
        }

        return ["success" => false, "message" => "Failed to create admin."];
    }

    public static function getAdmin($id) {
        $database = new Database();
        $conn = $database->getConnection();
    
        $sql = "SELECT * FROM admins WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
    
        if ($stmt->execute()) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($admin) {
                header("HTTP/1.1 200 OK");
                return $admin;
            } else {
                header("HTTP/1.1 404 Not Found");
                return ["success" => false, "message" => "Admin not found"];
            }
        }
    
        header("HTTP/1.1 400 Bad Request");
        return ["success" => false, "message" => "Failed to get admin"];
    }
    
    public static function getAllAdmins() {
            $database = new Database();
            $conn = $database->getConnection();
        
            $sql = "SELECT * FROM admins";
            $stmt = $conn->query($sql);
        
            if ($stmt) {
                $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                return $admins;
            }
        
            header("HTTP/1.1 400 Bad Request");
            return ["success" => false, "message" => "Failed to get admins"];
    }

    public static function update($id, $email, $password = null) {
        $database = new Database();
        $conn = $database->getConnection();

        // Validar datos
        if (empty($email)) {
            return ["success" => false, "message" => "Email is required."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["success" => false, "message" => "Invalid email format."];
        }

        // Construir consulta dinámica
        $sql = "UPDATE admins SET email = :email";
        if (!empty($password)) {
            $sql .= ", password = :password";
        }
        $sql .= " WHERE id = :id";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id);
    
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $hashedPassword);
            }
    
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                return ["success" => true, "message" => "Admin updated successfully"];
            } 
            else {
                  return ["success" => true, "message" => "No changes made (data may be identical)"];
              }
        } catch (\Throwable $th) {
            return ["success" => false, "message" => "SQL Error: " . $th->getMessage()];
        }
    }

    public static function delete($id) {
        $database = new Database();
        $conn = $database->getConnection();

        $sql = "DELETE FROM admins WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return ["success" => true, "message" => "Admin deleted successfully."];
        }

        return ["success" => false, "message" => "Admin not found or could not be deleted."];
    }
}
?>