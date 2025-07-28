<?php
namespace RapiExpress\Models;

use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\IClienteModel;

class Cliente extends Conexion implements IClienteModel {
    public function registrar(array $data) {
        try {
            $stmt = $this->db->prepare("SELECT ID_Cliente FROM clientes WHERE Cedula_Identidad = ?");
            $stmt->execute([$data['Cedula_Identidad']]);
            if ($stmt->fetch()) return 'cedula_existente';

             $stmt = $this->db->prepare("SELECT ID_Cliente FROM clientes WHERE Telefono_Cliente = ?");
            $stmt->execute([$data['Telefono_Cliente']]);
            if ($stmt->fetch()) return 'telefono_existente';

            $stmt = $this->db->prepare("SELECT ID_Cliente FROM clientes WHERE Correo_Cliente = ?");
            $stmt->execute([$data['Correo_Cliente']]);
            if ($stmt->fetch()) return 'correo_existente';

            $stmt = $this->db->prepare("INSERT INTO clientes 
                (ID_Cliente, Cedula_Identidad, Nombres_Cliente, Apellidos_Cliente, Direccion_Cliente, Telefono_Cliente, Correo_Cliente, Fecha_Registro, ID_Sucursal, ID_Casillero) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)");

            return $stmt->execute([
                $data['ID_Cliente'],
                $data['Cedula_Identidad'],
                $data['Nombres_Cliente'],
                $data['Apellidos_Cliente'],
                $data['Direccion_Cliente'],
                $data['Telefono_Cliente'],
                $data['Correo_Cliente'],
                $data['ID_Sucursal'],
                $data['ID_Casillero']
            ]) ? 'registro_exitoso' : 'error_registro';
        } catch (PDOException $e) {
            error_log("Error en registro cliente: " . $e->getMessage());
            return 'error_bd';
        }
    }

   public function obtenerTodos() {
    try {
        $stmt = $this->db->prepare("
            SELECT 
                c.ID_Cliente,
                c.Cedula_Identidad,
                c.Nombres_Cliente,
                c.Apellidos_Cliente,
                c.Direccion_Cliente,
                c.Telefono_Cliente,
                c.Correo_Cliente,
                c.Fecha_Registro,
                s.Sucursal_Nombre,
                ca.Casillero_Nombre
            FROM clientes c
            LEFT JOIN sucursales s ON c.ID_Sucursal = s.ID_Sucursal
            LEFT JOIN casilleros ca ON c.ID_Casillero = ca.ID_Casillero
            ORDER BY c.Fecha_Registro DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener clientes: " . $e->getMessage());
        return [];
    }
}


    public function obtenerPorId($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM clientes WHERE ID_Cliente = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener cliente por ID: " . $e->getMessage());
            return null;
        }
    }

    public function actualizar(array $data) {
        try {

            // Verificar si la cédula ya existe para otro cliente
        $stmt = $this->db->prepare("SELECT ID_Cliente FROM clientes WHERE Cedula_Identidad = ? AND ID_Cliente != ?");
        $stmt->execute([$data['Cedula_Identidad'], $data['ID_Cliente']]);
        if ($stmt->fetch()) return 'cedula_existente';

        // Verificar si el teléfono ya existe para otro cliente
        $stmt = $this->db->prepare("SELECT ID_Cliente FROM clientes WHERE Telefono_Cliente = ? AND ID_Cliente != ?");
        $stmt->execute([$data['Telefono_Cliente'], $data['ID_Cliente']]);
        if ($stmt->fetch()) return 'telefono_existente';

        // Verificar si el correo ya existe para otro cliente
        $stmt = $this->db->prepare("SELECT ID_Cliente FROM clientes WHERE Correo_Cliente = ? AND ID_Cliente != ?");
        $stmt->execute([$data['Correo_Cliente'], $data['ID_Cliente']]);
        if ($stmt->fetch()) return 'correo_existente';

            $stmt = $this->db->prepare("UPDATE clientes SET 
                Cedula_Identidad = ?, 
                Nombres_Cliente = ?, 
                Apellidos_Cliente = ?, 
                Direccion_Cliente = ?, 
                Telefono_Cliente = ?, 
                Correo_Cliente = ?, 
                ID_Sucursal = ?, 
                ID_Casillero = ?
                WHERE ID_Cliente = ?");

            return $stmt->execute([
                $data['Cedula_Identidad'],
                $data['Nombres_Cliente'],
                $data['Apellidos_Cliente'],
                $data['Direccion_Cliente'],
                $data['Telefono_Cliente'],
                $data['Correo_Cliente'],
                $data['ID_Sucursal'],
                $data['ID_Casillero'],
                $data['ID_Cliente']
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar cliente: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM clientes WHERE ID_Cliente = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar cliente: " . $e->getMessage());
            return false;
        }
    }
}
