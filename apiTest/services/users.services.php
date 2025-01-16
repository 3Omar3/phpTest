<?php
require_once './db/db.class.php';

class AdminService {
    public static function login(string $email, string $password): array {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            $sql = "SELECT * FROM admins WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                unset($user['password']); // No incluir la contraseña en la respuesta
                return ["success" => true, "message" => "Login successful", "user" => $user];
            }

            header("HTTP/1.1 401 Unauthorized");
            return ["success" => false, "message" => "Invalid email or password."];
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            header("HTTP/1.1 500 Internal Server Error");
            return ["success" => false, "message" => "An error occurred during login."];
        }
    }

    public static function create(string $email, string $password): array {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            if (empty($email) || empty($password)) {
                header("HTTP/1.1 400 Bad Request");
                return ["success" => false, "message" => "Email and password are required."];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("HTTP/1.1 400 Bad Request");
                return ["success" => false, "message" => "Invalid email format."];
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO admins (email, password) VALUES (:email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                header("HTTP/1.1 201 Created");
                return ["success" => true, "message" => "Admin created successfully."];
            }

            header("HTTP/1.1 500 Internal Server Error");
            return ["success" => false, "message" => "Failed to create admin."];
        } catch (Exception $e) {
            error_log("Create error: " . $e->getMessage());
            header("HTTP/1.1 500 Internal Server Error");
            return ["success" => false, "message" => "An error occurred while creating the admin."];
        }
    }

    public static function getAdmin(int $id): array {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            $sql = "SELECT * FROM admins WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                header("HTTP/1.1 200 OK");
                return $admin;
            }

            header("HTTP/1.1 404 Not Found");
            return ["success" => false, "message" => "Admin not found."];
        } catch (Exception $e) {
            error_log("Get admin error: " . $e->getMessage());
            header("HTTP/1.1 500 Internal Server Error");
            return ["success" => false, "message" => "An error occurred while retrieving the admin."];
        }
    }

    public static function getAllAdmins(): array {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            $sql = "SELECT * FROM admins";
            $stmt = $conn->query($sql);

            $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header("HTTP/1.1 200 OK");
            return $admins;
        } catch (Exception $e) {
            error_log("Get all admins error: " . $e->getMessage());
            header("HTTP/1.1 500 Internal Server Error");
            return ["success" => false, "message" => "An error occurred while retrieving admins."];
        }
    }

    public static function update(int $id, string $email, ?string $password = null): array {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            if (empty($email)) {
                header("HTTP/1.1 400 Bad Request");
                return ["success" => false, "message" => "Email is required."];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("HTTP/1.1 400 Bad Request");
                return ["success" => false, "message" => "Invalid email format."];
            }

            $sql = "UPDATE admins SET email = :email";
            if ($password) {
                $sql .= ", password = :password";
            }
            $sql .= " WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id);

            if ($password) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $hashedPassword);
            }

            if ($stmt->execute()) {
                header("HTTP/1.1 200 OK");
                return ["success" => true, "message" => "Admin updated successfully."];
            }

            header("HTTP/1.1 304 Not Modified");
            return ["success" => false, "message" => "No changes were made."];
        } catch (Exception $e) {
            error_log("Update admin error: " . $e->getMessage());
            header("HTTP/1.1 500 Internal Server Error");
            return ["success" => false, "message" => "An error occurred while updating the admin."];
        }
    }

    public static function delete(int $id): array {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            $sql = "DELETE FROM admins WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                header("HTTP/1.1 200 OK");
                return ["success" => true, "message" => "Admin deleted successfully."];
            }

            header("HTTP/1.1 404 Not Found");
            return ["success" => false, "message" => "Admin not found."];
        } catch (Exception $e) {
            error_log("Delete admin error: " . $e->getMessage());
            header("HTTP/1.1 500 Internal Server Error");
            return ["success" => false, "message" => "An error occurred while deleting the admin."];
        }
    }
}
?>
