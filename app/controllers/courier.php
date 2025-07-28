<?php

use RapiExpress\Models\Courier;
require_once __DIR__ . '/../helpers/validaciones.php';
require_once __DIR__ . '/../interface/ICourierModel.php';
require_once __DIR__ . '/../models/Courier.php';
use function RapiExpress\Helpers\base_url;
use function RapiExpress\Helpers\validarCampoRequerido;
use function RapiExpress\Helpers\validarCorreo;
use function RapiExpress\Helpers\validarTelefono;
use function RapiExpress\Helpers\validarRif;
use function RapiExpress\Helpers\validarNombre;
use function RapiExpress\Helpers\validarNombreAlfanumerico;

function courier_index() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $courierModel = new Courier();
    $couriers = $courierModel->obtenerTodos();
    include __DIR__ . '/../views/courier/courier.php';
}

function courier_registrar() {
    $courierModel = new Courier();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'RIF_Courier'       => trim($_POST['RIF_Courier']),
            'Courier_Nombre'    => trim($_POST['Courier_Nombre']),
            'Courier_Direccion' => trim($_POST['Courier_Direccion']),
            'Courier_Telefono'  => trim($_POST['Courier_Telefono']),
            'Courier_Correo'    => trim($_POST['Courier_Correo']),
        ];

        // Validaciones
        $errores = [];
        $errores[] = validarCampoRequerido($data['RIF_Courier'], 'RIF');
        $errores[] = validarRif($data['RIF_Courier']);
        $errores[] = validarCampoRequerido($data['Courier_Nombre'], 'Nombre');
        $errores[] = validarNombre($data['Courier_Nombre'], 'Nombre');
        $errores[] = validarCampoRequerido($data['Courier_Direccion'], 'Dirección');
        $errores[] = validarNombreAlfanumerico($data['Courier_Direccion'], 'Dirección', 100);
        $errores[] = validarCampoRequerido($data['Courier_Telefono'], 'Teléfono');
        $errores[] = validarTelefono($data['Courier_Telefono']);
        $errores[] = validarCampoRequerido($data['Courier_Correo'], 'Correo');
        $errores[] = validarCorreo($data['Courier_Correo']);

        // Filtrar errores nulos
        $errores = array_filter($errores);

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode("\n", $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=courier');
            exit();
        }

        $resultado = $courierModel->registrar($data);
     switch ($resultado) {
    case 'registro_exitoso':
        $_SESSION['mensaje'] = 'Courier registrado exitosamente';
        $_SESSION['tipo_mensaje'] = 'success';
        break;
    case 'rif_duplicado':
        $_SESSION['mensaje'] = 'El RIF ingresado ya está registrado.';
        $_SESSION['tipo_mensaje'] = 'error';
        break;
    case 'correo_duplicado':
        $_SESSION['mensaje'] = 'El correo ingresado ya está registrado.';
        $_SESSION['tipo_mensaje'] = 'error';
        break;
    case 'telefono_duplicado':
        $_SESSION['mensaje'] = 'El teléfono ingresado ya está registrado.';
        $_SESSION['tipo_mensaje'] = 'error';
        break;
    
    default:
        $_SESSION['mensaje'] = 'Error inesperado al registrar el courier.';
        $_SESSION['tipo_mensaje'] = 'error';
}
header('Location: index.php?c=courier');
exit();


    }
}

function courier_editar() {
    $courierModel = new Courier();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'ID_Courier'        => (int)$_POST['ID_Courier'],
            'RIF_Courier'       => trim($_POST['RIF_Courier']),
            'Courier_Nombre'    => trim($_POST['Courier_Nombre']),
            'Courier_Direccion' => trim($_POST['Courier_Direccion']),
            'Courier_Telefono'  => trim($_POST['Courier_Telefono']),
            'Courier_Correo'    => trim($_POST['Courier_Correo']),
        ];

        // Validaciones
        $errores = [];
        $errores[] = validarCampoRequerido($data['RIF_Courier'], 'RIF');
        $errores[] = validarRif($data['RIF_Courier']);
        $errores[] = validarCampoRequerido($data['Courier_Nombre'], 'Nombre');
        $errores[] = validarNombre($data['Courier_Nombre'], 'Nombre');
        $errores[] = validarCampoRequerido($data['Courier_Direccion'], 'Dirección');
        $errores[] = validarNombreAlfanumerico($data['Courier_Direccion'], 'Dirección', 100);
        $errores[] = validarCampoRequerido($data['Courier_Telefono'], 'Teléfono');
        $errores[] = validarTelefono($data['Courier_Telefono']);
        $errores[] = validarCampoRequerido($data['Courier_Correo'], 'Correo');
        $errores[] = validarCorreo($data['Courier_Correo']);

        // Filtrar errores
        $errores = array_filter($errores);

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode("\n", $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=courier');
            exit();
        }
$resultado = $courierModel->actualizar($data);

switch ($resultado) {
    case 'registro_exitoso':
        $_SESSION['mensaje'] = 'Courier registrado exitosamente';
        $_SESSION['tipo_mensaje'] = 'success';
        break;
    case 'rif_duplicado':
        $_SESSION['mensaje'] = 'El RIF ingresado ya está registrado.';
        $_SESSION['tipo_mensaje'] = 'error';
        break;
    case 'correo_duplicado':
        $_SESSION['mensaje'] = 'El correo ingresado ya está registrado.';
        $_SESSION['tipo_mensaje'] = 'error';
        break;
    case 'telefono_duplicado':
        $_SESSION['mensaje'] = 'El teléfono ingresado ya está registrado.';
        $_SESSION['tipo_mensaje'] = 'error';
        break;
    
    default:
        $_SESSION['mensaje'] = 'Error inesperado al registrar el courier.';
        $_SESSION['tipo_mensaje'] = 'error';
}
header('Location: index.php?c=courier');
exit();

    }
}

function courier_eliminar() {
    $courierModel = new Courier();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Courier']) && is_numeric($_POST['ID_Courier'])) {
        $id = (int)$_POST['ID_Courier'];
        $resultado = $courierModel->eliminar($id);

        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Courier eliminado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } elseif ($resultado === 'error_restriccion') {
            $_SESSION['mensaje'] = 'Error: El courier no puede eliminarse porque está relacionado con otros registros';
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar el courier';
            $_SESSION['tipo_mensaje'] = 'error';
        }
    } else {
        $_SESSION['mensaje'] = 'Error: ID no recibido correctamente.';
        $_SESSION['tipo_mensaje'] = 'error';
    }

    header('Location: index.php?c=courier');
    exit();
}

function courier_obtenerCourier() {
    $courierModel = new Courier();

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int)$_GET['id'];
        $courier = $courierModel->obtenerPorId($id);

        header('Content-Type: application/json');
        echo json_encode($courier);
        exit();
    }
}
