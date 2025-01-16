<?php
declare(strict_types=1);

require_once './services/users.services.php';

class UserController {
    public static function create(string $name, string $lastname, string $address, string $email): array {
        // Validar datos
        $validation = self::validateUserData($name, $lastname, $address, $email);
        if (!$validation['valid']) {
            return ["success" => false, "error" => $validation['message']];
        }

        // Crear usuario
        return UserService::createUser($name, $lastname, $address, $email);
    }

    public static function read(?int $id): array {
        return $id !== null ? UserService::getUser($id) : UserService::getAllUsers();
    }

    public static function update(int $id, string $name, string $lastname, string $address, string $email): array {
        // Validar datos
        $validation = self::validateUserData($name, $lastname, $address, $email);
        if (!$validation['valid']) {
            return ["success" => false, "error" => $validation['message']];
        }

        // Actualizar usuario
        return UserService::updateUser($id, $name, $lastname, $address, $email);
    }

    public static function delete(int $id): array {
        if ($id <= 0) {
            return ["success" => false, "error" => "Invalid ID"];
        }

        return UserService::deleteUser($id);
    }

    // Validar los datos del usuario
    private static function validateUserData(string $name, string $lastname, string $address, string $email): array {
        // Validar campos vacíos
        if (empty($name) || empty($lastname) || empty($address) || empty($email)) {
            return ["valid" => false, "message" => "All fields are required."];
        }

        // Validar longitud
        if (strlen($name) > 100) {
            return ["valid" => false, "message" => "Name exceeds 100 characters."];
        }
        if (strlen($lastname) > 100) {
            return ["valid" => false, "message" => "Lastname exceeds 100 characters."];
        }
        if (strlen($address) > 250) {
            return ["valid" => false, "message" => "Address exceeds 250 characters."];
        }
        if (strlen($email) > 100) {
            return ["valid" => false, "message" => "Email exceeds 100 characters."];
        }

        // Validar formato de correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["valid" => false, "message" => "Invalid email format."];
        }

        return ["valid" => true, "message" => "Valid data."];
    }
}
?>