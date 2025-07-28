<?php

use function RapiExpress\Helpers\base_url;

use RapiExpress\Models\Cargo;
require_once __DIR__ . '/../helpers/validaciones.php';

use RapiExpress\Interface\ICargoModel;
use function RapiExpress\Helpers\validarCampoRequerido;
use function RapiExpress\Helpers\validarLongitud;
use function RapiExpress\Helpers\validarNombre; // <--- NUEVO



function cargo_index() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $cargoModel = new Cargo();
    $cargos = $cargoModel->obtenerTodos();
    include __DIR__ . '/../views/cargo/cargo.php';
}
function cargo_registrar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cargoModel = new Cargo();
        $Cargo_Nombre = trim($_POST['Cargo_Nombre']);
        $errores = [];

        // Validaciones
        $errorRequerido = validarCampoRequerido($Cargo_Nombre, 'Nombre del Cargo');
        if ($errorRequerido) $errores[] = $errorRequerido;

        $errorSoloLetras = validarNombre($Cargo_Nombre, 'Nombre del Cargo');
        if ($errorSoloLetras) $errores[] = $errorSoloLetras;

        $errorLongitud = validarLongitud($Cargo_Nombre, 'Nombre del Cargo', 50);
        if ($errorLongitud) $errores[] = $errorLongitud;

        // Validación de duplicado
        if ($cargoModel->verificarCargoExistente($Cargo_Nombre)) {
            $errores[] = 'Ya existe un cargo con ese nombre.';
        }

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode(' ', $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=cargo');
            exit();
        }

        $resultado = $cargoModel->registrar(['Cargo_Nombre' => $Cargo_Nombre]);

        switch ($resultado) {
            case 'registro_exitoso':
                $_SESSION['mensaje'] = 'Cargo registrado exitosamente';
                $_SESSION['tipo_mensaje'] = 'success';
                break;
            case 'error_bd':
                $_SESSION['mensaje'] = 'Error al registrar el cargo';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            default:
                $_SESSION['mensaje'] = 'Error desconocido';
                $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=cargo');
        exit();
    }
}

function cargo_editar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cargoModel = new Cargo();
        $id = $_POST['ID_Cargo'] ?? null;
        $Cargo_Nombre = trim($_POST['Cargo_Nombre'] ?? '');
        $errores = [];

        if (empty($id)) {
            $errores[] = 'ID del cargo no proporcionado.';
        }

        $errorRequerido = validarCampoRequerido($Cargo_Nombre, 'Nombre del Cargo');
        if ($errorRequerido) $errores[] = $errorRequerido;

        $errorSoloLetras = validarNombre($Cargo_Nombre, 'Nombre del Cargo');
        if ($errorSoloLetras) $errores[] = $errorSoloLetras;

        $errorLongitud = validarLongitud($Cargo_Nombre, 'Nombre del Cargo', 20);
        if ($errorLongitud) $errores[] = $errorLongitud;

        // Validación de duplicado (excluyendo el mismo ID)
        if ($cargoModel->verificarCargoExistente($Cargo_Nombre, $id)) {
            $errores[] = 'Ya existe un cargo con ese nombre.';
        }

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode(' ', $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=cargo');
            exit();
        }

        $data = [
            'ID_Cargo' => (int)$id,
            'Cargo_Nombre' => $Cargo_Nombre
        ];

        $resultado = $cargoModel->actualizar($data);

        if ($resultado) {
            $_SESSION['mensaje'] = 'Cargo actualizado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar el cargo';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=cargo');
        exit();
    }
}




function cargo_eliminar() {

    if (isset($_POST['ID_Cargo'])) {
        $id = (int)$_POST['ID_Cargo'];
        $cargoModel = new Cargo();

        $resultado = $cargoModel->eliminar($id);

        if ($resultado) {
            $_SESSION['mensaje'] = 'Cargo eliminado correctamente.';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar el cargo.';
            $_SESSION['tipo_mensaje'] = 'error';
        }
    } else {
        $_SESSION['mensaje'] = 'ID del cargo no proporcionado.';
        $_SESSION['tipo_mensaje'] = 'error';
    }

    header("Location: index.php?c=cargo");
    exit();
}

function cargo_obtenerCargo() {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $cargoModel = new Cargo();
        $cargo = $cargoModel->obtenerPorId($id);

        header('Content-Type: application/json');
        echo json_encode($cargo);
        exit();
    }
}
