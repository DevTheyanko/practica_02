<?php
use function RapiExpress\Helpers\base_url;

use RapiExpress\Models\Sucursal;
use RapiExpress\Interface\ISucursalModel;
require_once __DIR__ . '/../helpers/validaciones.php';
use RapiExpress\Helpers;




function sucursal_index() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $sucursalModel = new Sucursal();
    $sucursales = $sucursalModel->obtenerTodas();
    include __DIR__ . '/../views/sucursal/sucursal.php';
}

function sucursal_registrar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $sucursalModel = new Sucursal();

        $data = [
            'RIF_Sucursal'       => trim($_POST['RIF_Sucursal']),
            'Sucursal_Nombre'    => trim($_POST['Sucursal_Nombre']),
            'Sucursal_Direccion' => trim($_POST['Sucursal_Direccion']),
            'Sucursal_Telefono'  => trim($_POST['Sucursal_Telefono']),
            'Sucursal_Correo'    => trim($_POST['Sucursal_Correo'])
        ];

        // Validaciones
        $errores = [];

        $errores[] = Helpers\validarCampoRequerido($data['RIF_Sucursal'], 'RIF');
        $errores[] = Helpers\validarRif($data['RIF_Sucursal']);
        $errores[] = Helpers\validarCampoRequerido($data['Sucursal_Nombre'], 'Nombre');
        $errores[] = Helpers\validarNombre($data['Sucursal_Nombre']);
        $errores[] = Helpers\validarCampoRequerido($data['Sucursal_Direccion'], 'Dirección');
        $errores[] = Helpers\validarNombreAlfanumerico($data['Sucursal_Direccion'], 'Dirección');
        $errores[] = Helpers\validarCampoRequerido($data['Sucursal_Telefono'], 'Teléfono');
        $errores[] = Helpers\validarTelefono($data['Sucursal_Telefono']);
        $errores[] = Helpers\validarCampoRequerido($data['Sucursal_Correo'], 'Correo');
        $errores[] = Helpers\validarCorreo($data['Sucursal_Correo']);

        $errores = array_filter($errores); // eliminar nulls

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode('<br>', $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=sucursal');
            exit();
        }

        $resultado = $sucursalModel->registrar($data);

        switch ($resultado) {
            case 'registro_exitoso':
                $_SESSION['mensaje'] = 'Sucursal registrada exitosamente';
                $_SESSION['tipo_mensaje'] = 'success';
                break;
            case 'rif_existente':
                $_SESSION['mensaje'] = 'El RIF ya está registrado';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            case 'nombre_existente':
                $_SESSION['mensaje'] = 'El nombre de la sucursal ya está registrado';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            case 'telefono_existente':
                $_SESSION['mensaje'] = 'El teléfono ya está registrado en otra sucursal';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            case 'correo_existente':
                $_SESSION['mensaje'] = 'El correo ya está registrado en otra sucursal';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            default:
                $_SESSION['mensaje'] = 'Error al registrar la sucursal';
                $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=sucursal');
        exit();
    }
}

function sucursal_eliminar() {
        
    

    if (isset($_POST['ID_Sucursal'])) {
        $id = (int)$_POST['ID_Sucursal'];
        $sucursalModel = new Sucursal();

        $eliminado = $sucursalModel->eliminar($id);

        if ($eliminado) {
            $_SESSION['mensaje'] = "Sucursal eliminada correctamente.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar la sucursal.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "ID de sucursal no proporcionado.";
        $_SESSION['tipo_mensaje'] = "danger";
    }

    header("Location: index.php?c=sucursal");
    exit();
}

function sucursal_obtenerSucursales() {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $sucursalModel = new Sucursal();

        $sucursal = $sucursalModel->obtenerPorId($id);
        header('Content-Type: application/json');
        echo json_encode($sucursal);
        exit();
    }
}
