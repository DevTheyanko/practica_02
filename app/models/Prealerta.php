<?php
namespace RapiExpress\Models;

use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\IPrealertaModel;

class Prealerta extends Conexion implements IPrealertaModel  {

    public function registrar(array $data) {
        try {
            $stmt = $this->db->prepare("INSERT INTO prealertas 
                (ID_Prealerta, ID_Cliente, ID_Tienda, ID_Casillero, Tienda_Traking, Prealerta_Piezas, Prealerta_Peso, Prealerta_Descripcion)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            return $stmt->execute([
                $data['ID_Prealerta'],
                $data['ID_Cliente'],
                $data['ID_Tienda'],
                $data['ID_Casillero'],
                $data['Tienda_Traking'],
                $data['Prealerta_Piezas'],
                $data['Prealerta_Peso'],
                $data['Prealerta_Descripcion']
            ]) ? 'registro_exitoso' : 'error_registro';
        } catch (PDOException $e) {
            error_log("Error en registro prealerta: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function obtenerTodas() {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    p.ID_Prealerta,
                    p.Tienda_Traking,
                    p.Prealerta_Piezas,
                    p.Prealerta_Peso,
                    p.Prealerta_Descripcion,
                    c.Nombres_Cliente,
                    c.Apellidos_Cliente,
                    ca.Casillero_Nombre,
                    t.Nombre_Tienda
                FROM prealertas p
                LEFT JOIN clientes c ON p.ID_Cliente = c.ID_Cliente
                LEFT JOIN casilleros ca ON p.ID_Casillero = ca.ID_Casillero
                LEFT JOIN tiendas t ON p.ID_Tienda = t.ID_Tienda
                ORDER BY p.ID_Prealerta DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener prealertas: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorId($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM prealertas WHERE ID_Prealerta = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener prealerta por ID: " . $e->getMessage());
            return null;
        }
    }

    public function actualizar(array $data) {
        try {
            $stmt = $this->db->prepare("UPDATE prealertas SET 
                ID_Cliente = ?, 
                ID_Tienda = ?, 
                ID_Casillero = ?, 
                Tienda_Traking = ?, 
                Prealerta_Piezas = ?, 
                Prealerta_Peso = ?, 
                Prealerta_Descripcion = ?
                WHERE ID_Prealerta = ?");
            
            return $stmt->execute([
                $data['ID_Cliente'],
                $data['ID_Tienda'],
                $data['ID_Casillero'],
                $data['Tienda_Traking'],
                $data['Prealerta_Piezas'],
                $data['Prealerta_Peso'],
                $data['Prealerta_Descripcion'],
                $data['ID_Prealerta']
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar prealerta: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM prealertas WHERE ID_Prealerta = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar prealerta: " . $e->getMessage());
            return false;
        }
    }
}
