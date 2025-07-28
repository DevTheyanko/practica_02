<?php
namespace RapiExpress\Models;

use RapiExpress\Config\Conexion;
use RapiExpress\Interface\IAuthModel;
use PDO;

class Auth extends Conexion implements IAuthModel {
    
    // Método para autenticar al usuario
    public function autenticar($Username, $Password) {
        // Preparar la consulta para verificar si el usuario existe
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE Username = ?");
        $stmt->execute([$Username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y si la contraseña es válida
        return $usuario && password_verify($Password, $usuario['Password']) ? $usuario : false;
    }

    // Método para recuperar y actualizar la contraseña
    public function recuperarPassword($Username, $newPassword) {
        // Preparar la consulta para buscar al usuario
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE Username = ?");
        $stmt->execute([$Username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si el usuario existe, actualizar su contraseña
        if ($user) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $this->db->prepare("UPDATE usuarios SET Password = ? WHERE Username = ?");
            return $updateStmt->execute([$hashedPassword, $Username]);
        }

        // Si no se encuentra el usuario, devolver un estado
        return 'no_encontrado';
    }
}
