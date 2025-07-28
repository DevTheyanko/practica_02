<?php

use function RapiExpress\Helpers\base_url;

use RapiExpress\Models\Casillero;
use function RapiExpress\Helpers\validarCampoRequerido;
use function RapiExpress\Helpers\validarNombreAlfanumerico;

function casillero_index()
{
    
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $casilleroModel = new Casillero();
    $casilleros = $casilleroModel->obtenerTodos();
    include __DIR__ . '/../views/casillero/casillero.php';
}

function casillero_registrar()
{

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['Casillero_Nombre']);
        $direccion = trim($_POST['Direccion']);

        // Validaciones
        $errores = [];

        if ($error = validarCampoRequerido($nombre, 'Nombre del casillero')) {
            $errores[] = $error;
        } elseif ($error = validarNombreAlfanumerico($nombre, 'Nombre del casillero')) {
            $errores[] = $error;
        }

        if ($error = validarCampoRequerido($direccion, 'Dirección')) {
            $errores[] = $error;
        }

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode('<br>', $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=casillero');
            exit();
        }

        $casilleroModel = new Casillero();

        $data = [
            'Casillero_Nombre' => $nombre,
            'Direccion' => $direccion
        ];

        $resultado = $casilleroModel->registrar($data);

        switch ($resultado) {
            case 'registro_exitoso':
                $_SESSION['mensaje'] = 'Casillero registrado exitosamente';
                $_SESSION['tipo_mensaje'] = 'success';
                break;
            case 'casillero_existente':
                $_SESSION['mensaje'] = 'El nombre del casillero ya está registrado';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            default:
                $_SESSION['mensaje'] = 'Error al registrar el casillero';
                $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=casillero');
        exit();
    }
}


function casillero_editar()
{
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['ID_Casillero', 'Casillero_Nombre'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['mensaje'] = "Error: El campo $field es requerido";
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?c=casillero');
                exit();
            }
        }

        $nombre = trim($_POST['Casillero_Nombre']);
        $direccion = trim($_POST['Direccion']);

        // Validaciones
        $errores = [];

        if ($error = validarCampoRequerido($nombre, 'Nombre del casillero')) {
            $errores[] = $error;
        } elseif ($error = validarNombreAlfanumerico($nombre, 'Nombre del casillero')) {
            $errores[] = $error;
        }

        if ($error = validarCampoRequerido($direccion, 'Dirección')) {
            $errores[] = $error;
        }

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode('<br>', $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=casillero');
            exit();
        }

        $casilleroModel = new Casillero();

        $data = [
            'ID_Casillero' => (int)$_POST['ID_Casillero'],
            'Casillero_Nombre' => $nombre,
            'Direccion' => $direccion
        ];

        $resultado = $casilleroModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Casillero actualizado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } elseif ($resultado === 'casillero_existente') {
            $_SESSION['mensaje'] = 'El nombre del casillero ya pertenece a otro registro';
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar el casillero';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=casillero');
        exit();
    }
}


function casillero_eliminar()
{
    session_start();
    if (isset($_POST['ID_Casillero'])) {
        $id = (int)$_POST['ID_Casillero'];
        $casilleroModel = new Casillero();

        $eliminado = $casilleroModel->eliminar($id);

        if ($eliminado) {
            $_SESSION['mensaje'] = "Casillero eliminado correctamente.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar el casillero.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "ID de casillero no proporcionado.";
        $_SESSION['tipo_mensaje'] = "danger";
    }

    header("Location: index.php?c=casillero");
    exit();
}

function casillero_obtenerPorId()
{
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $casilleroModel = new Casillero();

        $casillero = $casilleroModel->obtenerPorId($id);

        header('Content-Type: application/json');
        echo json_encode($casillero);
        exit();
    }
}
