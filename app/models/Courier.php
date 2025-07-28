<?php
namespace RapiExpress\Models;

use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\ICourierModel;

class Courier extends Conexion implements ICourierModel {

public function registrar(array $data) {
    try {
        // Verificar si ya existe algún dato duplicado
        $stmtCheck = $this->db->prepare("
            SELECT * FROM courier 
            WHERE RIF_Courier = ? OR  Courier_Correo = ? OR Courier_Telefono = ? 
        ");
        $stmtCheck->execute([
            $data['RIF_Courier'],
            $data['Courier_Correo'],
            $data['Courier_Telefono']
           
        ]);

        $result = $stmtCheck->fetch();
if ($result) {
    if ($result['RIF_Courier'] === $data['RIF_Courier']) return 'rif_duplicado';
    if ($result['Courier_Correo'] === $data['Courier_Correo']) return 'correo_duplicado';
    if ($result['Courier_Telefono'] === $data['Courier_Telefono']) return 'telefono_duplicado';
   
    return 'duplicado_existente';
}


        // Insertar nuevo courier
        $stmt = $this->db->prepare("
            INSERT INTO courier (RIF_Courier, Courier_Nombre, Courier_Direccion, Courier_Telefono, Courier_Correo)
            VALUES (?, ?, ?, ?, ?)
        ");

        $resultado = $stmt->execute([
            $data['RIF_Courier'],
            $data['Courier_Nombre'],
            $data['Courier_Direccion'],
            $data['Courier_Telefono'],
            $data['Courier_Correo']
        ]);

        return $resultado ? 'registro_exitoso' : 'error_registro';
    } catch (PDOException $e) {
        error_log("Error en registro de courier: " . $e->getMessage());
        return 'error_bd';
    }
}


    public function obtenerTodos() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM courier ORDER BY ID_Courier DESC");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener couriers: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorId($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM courier WHERE ID_Courier = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener courier por ID: " . $e->getMessage());
            return false;
        }
    }

   public function actualizar(array $data) {
    try {
        // Verificar duplicados excluyendo el ID actual
        $stmtCheck = $this->db->prepare("
            SELECT * FROM courier 
            WHERE (RIF_Courier = ? OR Courier_Correo = ? OR Courier_Telefono = ? )
            AND ID_Courier != ?
        ");
        $stmtCheck->execute([
            $data['RIF_Courier'],
            $data['Courier_Correo'],
            $data['Courier_Telefono'],            
            $data['ID_Courier']
        ]);

        if ($stmtCheck->fetch()) {
            return 'duplicado_existente';
        }

        // Actualizar datos
        $stmt = $this->db->prepare("
            UPDATE courier 
            SET RIF_Courier = ?, Courier_Nombre = ?, Courier_Direccion = ?, Courier_Telefono = ?, Courier_Correo = ?
            WHERE ID_Courier = ?
        ");
        return $stmt->execute([
            $data['RIF_Courier'],
            $data['Courier_Nombre'],
            $data['Courier_Direccion'],
            $data['Courier_Telefono'],
            $data['Courier_Correo'],
            $data['ID_Courier']
        ]);
    } catch (PDOException $e) {
        error_log("Error en actualizar courier: " . $e->getMessage());
        return false;
    }
}

public function eliminar($id) {
    try {
        $stmt = $this->db->prepare("DELETE FROM courier WHERE ID_Courier = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() === 0) {
            // No se eliminó nada (probablemente por restricción)
            return 'no_eliminado';
        }

        return true;
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'foreign key constraint') !== false) {
            return 'error_restriccion';
        }
        error_log("Error al eliminar courier: " . $e->getMessage());
        return false;
    }
}


}
