<?php
namespace RapiExpress\Models;

use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\ISucursalModel;

class Sucursal extends Conexion implements ISucursalModel
{
    private string $lastError = '';

    public function registrar(array $data): string
    {
        try {
            $verificaciones = [
                ['campo' => 'RIF_Sucursal',       'valor' => $data['RIF_Sucursal'],       'error' => 'rif_existente'],
                ['campo' => 'Sucursal_Nombre',    'valor' => $data['Sucursal_Nombre'],    'error' => 'nombre_existente'],
                ['campo' => 'Sucursal_Telefono',  'valor' => $data['Sucursal_Telefono'],  'error' => 'telefono_existente'],
                ['campo' => 'Sucursal_Correo',    'valor' => $data['Sucursal_Correo'],    'error' => 'correo_existente'],
            ];

            foreach ($verificaciones as $verif) {
                $stmt = $this->db->prepare("SELECT ID_Sucursal FROM sucursales WHERE {$verif['campo']} = ?");
                $stmt->execute([$verif['valor']]);
                if ($stmt->fetch()) {
                    return $verif['error'];
                }
            }

            $stmt = $this->db->prepare("
                INSERT INTO sucursales (RIF_Sucursal, Sucursal_Nombre, Sucursal_Direccion, Sucursal_Telefono, Sucursal_Correo)
                VALUES (?, ?, ?, ?, ?)
            ");

            $resultado = $stmt->execute([
                $data['RIF_Sucursal'],
                $data['Sucursal_Nombre'],
                $data['Sucursal_Direccion'],
                $data['Sucursal_Telefono'],
                $data['Sucursal_Correo']
            ]);

            return $resultado ? 'registro_exitoso' : 'error_registro';

        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error en registro sucursal: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function obtenerTodas(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM sucursales ORDER BY ID_Sucursal DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al obtener sucursales: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorId(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM sucursales WHERE ID_Sucursal = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al obtener sucursal por ID: " . $e->getMessage());
            return null;
        }
    }

    public function actualizar(array $data): bool|string
    {
        try {
            $verificaciones = [
                ['campo' => 'RIF_Sucursal',       'valor' => $data['RIF_Sucursal'],       'error' => 'rif_existente'],
                ['campo' => 'Sucursal_Nombre',    'valor' => $data['Sucursal_Nombre'],    'error' => 'nombre_existente'],
                ['campo' => 'Sucursal_Telefono',  'valor' => $data['Sucursal_Telefono'],  'error' => 'telefono_existente'],
                ['campo' => 'Sucursal_Correo',    'valor' => $data['Sucursal_Correo'],    'error' => 'correo_existente'],
            ];

            foreach ($verificaciones as $verif) {
                $stmt = $this->db->prepare("SELECT ID_Sucursal FROM sucursales WHERE {$verif['campo']} = ? AND ID_Sucursal != ?");
                $stmt->execute([$verif['valor'], $data['ID_Sucursal']]);
                if ($stmt->fetch()) {
                    return $verif['error'];
                }
            }

            $stmt = $this->db->prepare("
                UPDATE sucursales
                SET RIF_Sucursal = ?, Sucursal_Nombre = ?, Sucursal_Direccion = ?, Sucursal_Telefono = ?, Sucursal_Correo = ?
                WHERE ID_Sucursal = ?
            ");

            return $stmt->execute([
                $data['RIF_Sucursal'],
                $data['Sucursal_Nombre'],
                $data['Sucursal_Direccion'],
                $data['Sucursal_Telefono'],
                $data['Sucursal_Correo'],
                $data['ID_Sucursal']
            ]);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al actualizar sucursal: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar(int $id): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM sucursales WHERE ID_Sucursal = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log("Error al eliminar sucursal: " . $e->getMessage());
            return false;
        }
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }
}
