<?php
namespace RapiExpress\Models;

use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\IUsuarioModel;

abstract class Persona {
    protected $nombre;
    protected $apellido;

    abstract public function getNombreCompleto();
}

class Usuario extends Conexion implements IUsuarioModel {
    private $ID_Usuario;
    private $Cedula_Identidad;
    private $Username;
    private $Nombres_Usuario;
    private $Apellidos_Usuario;
    private $Telefono_Usuario;
    private $Correo_Usuario;
    private $Direccion_Usuario;
    private $ID_Sucursal;
    private $ID_Cargo;
    private $Password;
    private $fecha_registro;
    private string $lastError = '';

    public function __construct($data = []) {
        parent::__construct();

        $this->ID_Usuario        = $data['ID_Usuario'] ?? '';
        $this->Cedula_Identidad  = $data['Cedula_Identidad'] ?? '';
        $this->Username          = $data['Username'] ?? '';
        $this->Nombres_Usuario   = $data['Nombres_Usuario'] ?? '';
        $this->Apellidos_Usuario = $data['Apellidos_Usuario'] ?? '';
        $this->Telefono_Usuario  = $data['Telefono_Usuario'] ?? '';
        $this->Correo_Usuario    = $data['Correo_Usuario'] ?? '';
        $this->Direccion_Usuario = $data['Direccion_Usuario'] ?? '';
        $this->ID_Sucursal       = $data['ID_Sucursal'] ?? '';
        $this->ID_Cargo          = $data['ID_Cargo'] ?? '';
        $this->Password          = $data['Password'] ?? '';
    }

    public function registrar() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE Cedula_Identidad = ? OR Correo_Usuario = ? OR Username = ? OR Telefono_Usuario = ?");
            $stmt->execute([$this->Cedula_Identidad, $this->Correo_Usuario, $this->Username, $this->Telefono_Usuario]);
            $existe = $stmt->fetch();

            if ($existe) {
                if ($existe['Cedula_Identidad'] == $this->Cedula_Identidad) return 'documento_existente';
                if ($existe['Correo_Usuario'] == $this->Correo_Usuario) return 'email_existente';
                if ($existe['Username'] == $this->Username) return 'username_existente';
                if ($existe['Telefono_Usuario'] == $this->Telefono_Usuario) return 'telefono_existente';
                return 'error_bd';
            }

            $stmt = $this->db->prepare("INSERT INTO usuarios 
                (ID_Usuario, Cedula_Identidad, Nombres_Usuario, Apellidos_Usuario, Username, Password, Telefono_Usuario, Correo_Usuario, Direccion_Usuario, Fecha_Registro, ID_Cargo, ID_Sucursal)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)");

            $resultado = $stmt->execute([
                $this->ID_Usuario,
                $this->Cedula_Identidad,
                $this->Nombres_Usuario,
                $this->Apellidos_Usuario,
                $this->Username,
                $this->Password,
                $this->Telefono_Usuario,
                $this->Correo_Usuario,
                $this->Direccion_Usuario,
                $this->ID_Cargo,
                $this->ID_Sucursal
            ]);

            return $resultado ? 'registro_exitoso' : 'error_bd';
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error en registro usuario: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function actualizar(array $data) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE (Username = ? OR Cedula_Identidad = ? OR Correo_Usuario = ? OR Telefono_Usuario = ?) AND ID_Usuario != ?");
            $stmt->execute([
                $data['Username'],
                $data['Cedula_Identidad'],
                $data['Correo_Usuario'],
                $data['Telefono_Usuario'],
                $data['ID_Usuario']
            ]);
            $existe = $stmt->fetch();

            if ($existe) {
                if ($existe['Cedula_Identidad'] == $data['Cedula_Identidad']) return 'documento_existente';
                if ($existe['Username'] == $data['Username']) return 'username_existente';
                if ($existe['Correo_Usuario'] == $data['Correo_Usuario']) return 'email_existente';
                if ($existe['Telefono_Usuario'] == $data['Telefono_Usuario']) return 'telefono_existente';
                return false;
            }

            $stmt = $this->db->prepare("UPDATE usuarios SET 
                Cedula_Identidad = ?, Username = ?, Nombres_Usuario = ?, Apellidos_Usuario = ?, 
                Telefono_Usuario = ?, Correo_Usuario = ?, Direccion_Usuario = ?, ID_Sucursal = ?, ID_Cargo = ? 
                WHERE ID_Usuario = ?");

            return $stmt->execute([
                $data['Cedula_Identidad'],
                $data['Username'],
                $data['Nombres_Usuario'],
                $data['Apellidos_Usuario'],
                $data['Telefono_Usuario'],
                $data['Correo_Usuario'],
                $data['Direccion_Usuario'],
                $data['ID_Sucursal'],
                $data['ID_Cargo'],
                $data['ID_Usuario']
            ]);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error en actualizar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($ID_Usuario, $currentUsername = null) {
        try {
            if ($currentUsername !== null) {
                $stmt = $this->db->prepare("SELECT Username FROM usuarios WHERE ID_Usuario = ?");
                $stmt->execute([$ID_Usuario]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user && $user['Username'] === $currentUsername) {
                    return false;
                }
            }

            $stmt = $this->db->prepare("DELETE FROM usuarios WHERE ID_Usuario = ?");
            return $stmt->execute([$ID_Usuario]);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al eliminar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerTodos() {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    u.ID_Usuario,
                    u.Cedula_Identidad,
                    u.Username,
                    u.Nombres_Usuario,
                    u.Apellidos_Usuario,
                    u.Telefono_Usuario,
                    u.Correo_Usuario,
                    u.Direccion_Usuario,
                    u.Fecha_Registro,
                    s.Sucursal_Nombre,
                    c.Cargo_Nombre
                FROM usuarios u
                LEFT JOIN sucursales s ON u.ID_Sucursal = s.ID_Sucursal
                LEFT JOIN cargos c ON u.ID_Cargo = c.ID_Cargo
                ORDER BY u.Fecha_Registro DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al obtener usuarios con join: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorId($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE ID_Usuario = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al obtener usuario por ID: " . $e->getMessage());
            return null;
        }
    }

    public function getNombreCompleto() {
        return $this->Nombres_Usuario . ' ' . $this->Apellidos_Usuario;
    }

    public function getDocumento()      { return $this->ID_Usuario; }
    public function getTelefono()       { return $this->Telefono_Usuario; }
    public function getSucursal()       { return $this->ID_Sucursal; }
    public function getCargo()          { return $this->ID_Cargo; }
    public function getFechaRegistro()  { return $this->fecha_registro; }

    public function getLastError(): string {
        return $this->lastError;
    }
}
