<?php

require_once './services/admin.services.php';

class AdminController {
    // Función para manejar el login de administrador
    public static function login(string &$email, string &$password): array {
        // Validar datos de entrada
        $validation = self::validateLoginData($email, $password);
        if (!$validation['valid']) {
            return ["success" => false, "message" => $validation['message']];
        }

        // Llamar al servicio para el login
        return AdminService::login($email, $password);
    }

    // Función para crear un nuevo administrador
    public static function create(string &$email, string &$password): array {
        // Validar datos de entrada (puedes agregar validaciones específicas aquí si es necesario)
        return AdminService::create($email, $password);
    }

    // Función para obtener administradores (uno o todos)
    public static function read(?int &$id = null): array {
        return $id ? AdminService::getAdmin($id) : AdminService::getAllAdmins();
    }

    // Función para actualizar un administrador
    public static function update(int &$id, string &$email, ?string &$password = null): array {
        return AdminService::update($id, $email, $password);
    }

    // Función para eliminar un administrador
    public static function delete(int &$id): array {
        return AdminService::delete($id);
    }

    // Validación de los datos del login
    private static function validateLoginData(string &$email, string &$password): array {
        // Validar campos vacíos
        if (empty($email) || empty($password)) {	
            return ["valid" => false, "message" => "All fields are required."];
        }

        // Validar longitud de los campos
        if (strlen($email) > 100) {
            return ["valid" => false, "message" => "Email exceeds 100 characters."];
        }
        if (strlen($password) > 100) {
            return ["valid" => false, "message" => "Password exceeds 100 characters."];
        }

        // Validar formato del email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["valid" => false, "message" => "Invalid email format."];
        }

        return ["valid" => true, "message" => "Valid data."];
    }
}
?>
