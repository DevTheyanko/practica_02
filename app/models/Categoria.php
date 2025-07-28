<?php
namespace RapiExpress\Models;

use PDO;
use PDOException;
use RapiExpress\Config\Conexion;
use RapiExpress\Interface\ICategoriaModel;

class Categoria extends Conexion implements ICategoriaModel {

    public function registrar(array $data) {
        try {
            $sql = "INSERT INTO categorias (
                        Categoria_Nombre, Categoria_Altura, Categoria_Largo,
                        Categoria_Ancho, Categoria_Peso, Categoria_Piezas, Categoria_Precio
                    ) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $resultado = $stmt->execute([
                $data['nombre'],
                $data['altura'],
                $data['largo'],
                $data['ancho'],
                $data['peso'],
                $data['piezas'],
                $data['precio']
            ]);

            return $resultado ? 'registro_exitoso' : 'error_registro';
        } catch (PDOException $e) {
            error_log("Error al registrar categoría: " . $e->getMessage());
            return 'error_bd';
        }
    }

    public function obtenerTodos(): array {
        try {
            $stmt = $this->db->query("SELECT * FROM categorias ORDER BY ID_Categoria DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener categorías: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorId($id): ?array {
        try {
            $stmt = $this->db->prepare("SELECT * FROM categorias WHERE ID_Categoria = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log("Error al obtener categoría por ID: " . $e->getMessage());
            return null;
        }
    }

    public function actualizar(array $data): bool {
        try {
            $sql = "UPDATE categorias SET 
                        Categoria_Nombre = ?, Categoria_Altura = ?, Categoria_Largo = ?, 
                        Categoria_Ancho = ?, Categoria_Peso = ?, Categoria_Piezas = ?, 
                        Categoria_Precio = ?
                    WHERE ID_Categoria = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['nombre'],
                $data['altura'],
                $data['largo'],
                $data['ancho'],
                $data['peso'],
                $data['piezas'],
                $data['precio'],
                $data['ID_Categoria']
            ]);
        } catch (PDOException $e) {
            error_log("Error al actualizar categoría: " . $e->getMessage());
            return false;
        }
    }
    public function verificarCategoriaExistente($nombre, $idCategoria = null) {
    try {
        if ($idCategoria) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM categorias WHERE Categoria_Nombre = ? AND ID_Categoria != ?");
            $stmt->execute([$nombre, $idCategoria]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM categorias WHERE Categoria_Nombre = ?");
            $stmt->execute([$nombre]);
        }
        return $stmt->fetchColumn() > 0;
    } catch (\PDOException $e) {
        return false;
    }
}


    public function eliminar($id): bool {
        try {
            $stmt = $this->db->prepare("DELETE FROM categorias WHERE ID_Categoria = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar categoría: " . $e->getMessage());
            return false;
        }
    }
}
