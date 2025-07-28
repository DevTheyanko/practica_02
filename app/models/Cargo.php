<?php
namespace RapiExpress\Models;


use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\ICargoModel;

class Cargo extends Conexion implements ICargoModel {

    public function verificarCargoExistente($nombreCargo, $idCargo = null): bool {
    try {
        if ($idCargo) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM cargos WHERE Cargo_Nombre = ? AND ID_Cargo != ?");
            $stmt->execute([$nombreCargo, $idCargo]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM cargos WHERE Cargo_Nombre = ?");
            $stmt->execute([$nombreCargo]);
        }
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log("Error al verificar cargo existente: " . $e->getMessage());
        return false;
    }
}

    public function registrar(array $data): string {
        try {
            $stmt = $this->db->prepare("INSERT INTO cargos (Cargo_Nombre) VALUES (?)");
            return $stmt->execute([$data['Cargo_Nombre']]) ? 'registro_exitoso' : 'error_bd';
        } catch (PDOException $e) {
            error_log("Error al registrar cargo: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function obtenerTodos(): array {
        try {
            $stmt = $this->db->query("SELECT * FROM cargos ORDER BY ID_Cargo DESC");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener cargos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorId($id): ?array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM cargos WHERE ID_Cargo = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error al obtener cargo por ID: " . $e->getMessage());
            return null;
        }
    }
public function actualizar(array $data): bool {
    try {
        $stmt = $this->db->prepare("UPDATE cargos SET Cargo_Nombre = ? WHERE ID_Cargo = ?");
        return $stmt->execute([$data['Cargo_Nombre'], $data['ID_Cargo']]); // <-- CORREGIDO
    } catch (PDOException $e) {
        error_log("Error al actualizar cargo: " . $e->getMessage());
        return false;
    }
}


    public function eliminar($id): bool {
        try {
            $stmt = $this->db->prepare("DELETE FROM cargos WHERE ID_Cargo = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar cargo: " . $e->getMessage());
            return false;
        }
    }
}

