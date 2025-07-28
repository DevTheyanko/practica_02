<?php
namespace RapiExpress\Models;

use RapiExpress\Config\Conexion;
use RapiExpress\Interface\ICasilleroModel; // Asumo que tienes la interfaz

class Casillero extends Conexion implements ICasilleroModel
{
    public function registrar(array $data)
    {
        try {
            // Verificar si existe un casillero con el mismo nombre para evitar duplicados
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM casilleros WHERE Casillero_Nombre = :nombre");
            $stmt->execute([':nombre' => $data['Casillero_Nombre']]);
            if ($stmt->fetchColumn() > 0) {
                return 'casillero_existente';
            }

            $sql = "INSERT INTO casilleros (Casillero_Nombre, Direccion) VALUES (:nombre, :direccion)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nombre' => $data['Casillero_Nombre'],
                ':direccion' => $data['Direccion'] ?? null
            ]);
            return 'registro_exitoso';
        } catch (\PDOException $e) {
            // Loguear el error si lo deseas
            return 'error_registro';
        }
    }

    public function obtenerTodos()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM casilleros ORDER BY ID_Casillero DESC");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function actualizar(array $data)
    {
        try {
            // Validar que no exista otro casillero con el mismo nombre (excepto el actual)
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM casilleros WHERE Casillero_Nombre = :nombre AND ID_Casillero != :id");
            $stmt->execute([
                ':nombre' => $data['Casillero_Nombre'],
                ':id' => $data['ID_Casillero']
            ]);
            if ($stmt->fetchColumn() > 0) {
                return 'casillero_existente';
            }

            $sql = "UPDATE casilleros SET Casillero_Nombre = :nombre, Direccion = :direccion WHERE ID_Casillero = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nombre' => $data['Casillero_Nombre'],
                ':direccion' => $data['Direccion'] ?? null,
                ':id' => $data['ID_Casillero']
            ]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function eliminar(int $id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM casilleros WHERE ID_Casillero = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function obtenerPorId(int $id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM casilleros WHERE ID_Casillero = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return null;
        }
    }
}
