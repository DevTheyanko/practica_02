<?php
namespace RapiExpress\Models;

use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\ITiendaModel;

class Tienda extends Conexion implements ITiendaModel
{
    public function registrar(array $data): string
    {
        try {
            // Validar duplicados individuales
            $verificaciones = [
                ['campo' => 'Tienda_Nombre', 'valor' => $data['nombre_tienda'], 'error' => 'nombre_existente'],
                ['campo' => 'Tienda_Direccion', 'valor' => $data['direccion_tienda'], 'error' => 'direccion_existente'],
                ['campo' => 'Tienda_Telefono', 'valor' => $data['telefono_tienda'], 'error' => 'telefono_existente'],
                ['campo' => 'Tienda_Correo', 'valor' => $data['correo_tienda'], 'error' => 'correo_existente'],
            ];

            foreach ($verificaciones as $verif) {
                $stmt = $this->db->prepare("SELECT ID_Tienda FROM tiendas WHERE {$verif['campo']} = ?");
                $stmt->execute([$verif['valor']]);
                if ($stmt->fetch()) return $verif['error'];
            }

            // Insertar tienda
            $stmt = $this->db->prepare("INSERT INTO tiendas (Tienda_Nombre, Tienda_Direccion, Tienda_Telefono, Tienda_Correo) VALUES (?, ?, ?, ?)");
            return $stmt->execute([
                $data['nombre_tienda'],
                $data['direccion_tienda'],
                $data['telefono_tienda'],
                $data['correo_tienda']
            ]) ? 'registro_exitoso' : 'error_registro';

        } catch (PDOException $e) {
            error_log("Error en registro tienda: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function obtenerTodas(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tiendas ORDER BY ID_Tienda DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener todas las tiendas: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorId(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tiendas WHERE ID_Tienda = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error al obtener tienda por ID: " . $e->getMessage());
            return null;
        }
    }

    public function actualizar(array $data): string|bool
    {
        try {
            // Validar duplicados individuales (excluyendo la misma tienda)
            $verificaciones = [
                ['campo' => 'Tienda_Nombre', 'valor' => $data['nombre_tienda'], 'error' => 'nombre_existente'],
                ['campo' => 'Tienda_Direccion', 'valor' => $data['direccion_tienda'], 'error' => 'direccion_existente'],
                ['campo' => 'Tienda_Telefono', 'valor' => $data['telefono_tienda'], 'error' => 'telefono_existente'],
                ['campo' => 'Tienda_Correo', 'valor' => $data['correo_tienda'], 'error' => 'correo_existente'],
            ];

            foreach ($verificaciones as $verif) {
                $stmt = $this->db->prepare("SELECT ID_Tienda FROM tiendas WHERE {$verif['campo']} = ? AND ID_Tienda != ?");
                $stmt->execute([$verif['valor'], $data['id_tienda']]);
                if ($stmt->fetch()) return $verif['error'];
            }

            // Actualizar tienda
            $stmt = $this->db->prepare("UPDATE tiendas 
                SET Tienda_Nombre = ?, Tienda_Direccion = ?, Tienda_Telefono = ?, Tienda_Correo = ?
                WHERE ID_Tienda = ?");
            return $stmt->execute([
                $data['nombre_tienda'],
                $data['direccion_tienda'],
                $data['telefono_tienda'],
                $data['correo_tienda'],
                $data['id_tienda']
            ]) ? true : 'error_actualizar';

        } catch (PDOException $e) {
            error_log("Error al actualizar tienda: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function eliminar(int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM tiendas WHERE ID_Tienda = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar tienda: " . $e->getMessage());
            return false;
        }
    }
}
