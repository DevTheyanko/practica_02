<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Sucursal.php';
require_once __DIR__ . '/../models/Casillero.php';
require_once __DIR__ . '/../helpers/validaciones.php';
use function RapiExpress\Helpers\base_url;
use function RapiExpress\Helpers\validarCampoRequerido;
use function RapiExpress\Helpers\validarCedula;
use function RapiExpress\Helpers\validarNombre;
use function RapiExpress\Helpers\validarCorreo;
use function RapiExpress\Helpers\validarTelefono;
use function RapiExpress\Helpers\validarNombreAlfanumerico;

function cliente_index() {
    $clienteModel = new \RapiExpress\Models\Cliente();
    $sucursalModel = new \RapiExpress\Models\Sucursal();
    $casilleroModel = new \RapiExpress\Models\Casillero();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $clientes = $clienteModel->obtenerTodos();
    $sucursales = $sucursalModel->obtenerTodas();
    $casilleros = $casilleroModel->obtenerTodos();
    include __DIR__ . '/../views/cliente/cliente.php';
}

function cliente_registrar() {
    $clienteModel = new \RapiExpress\Models\Cliente();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'ID_Cliente' => (int)$_POST['ID_Cliente'],
            'Cedula_Identidad' => trim($_POST['Cedula_Identidad']),
            'Nombres_Cliente' => trim($_POST['Nombres_Cliente']),
            'Apellidos_Cliente' => trim($_POST['Apellidos_Cliente']),
            'Direccion_Cliente' => trim($_POST['Direccion_Cliente']),
            'Telefono_Cliente' => trim($_POST['Telefono_Cliente']),
            'Correo_Cliente' => trim($_POST['Correo_Cliente']),
            'ID_Sucursal' => (int)$_POST['ID_Sucursal'],
            'ID_Casillero' => (int)$_POST['ID_Casillero']
        ];

        // Validaciones
        $errores = [];

        $errores[] = validarCampoRequerido($data['Cedula_Identidad'], 'Cédula');
        $errores[] = validarCedula($data['Cedula_Identidad']);
        $errores[] = validarCampoRequerido($data['Nombres_Cliente'], 'Nombres');
        $errores[] = validarNombre($data['Nombres_Cliente'], 'Nombres');
        $errores[] = validarCampoRequerido($data['Apellidos_Cliente'], 'Apellidos');
        $errores[] = validarNombre($data['Apellidos_Cliente'], 'Apellidos');
        $errores[] = validarCampoRequerido($data['Direccion_Cliente'], 'Dirección');
        $errores[] = validarNombreAlfanumerico($data['Direccion_Cliente'], 'Dirección');
        $errores[] = validarCampoRequerido($data['Telefono_Cliente'], 'Teléfono');
        $errores[] = validarTelefono($data['Telefono_Cliente']);
        $errores[] = validarCampoRequerido($data['Correo_Cliente'], 'Correo');
        $errores[] = validarCorreo($data['Correo_Cliente']);

        // Filtrar errores nulos
        $errores = array_filter($errores);

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode(" ", $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=cliente');
            exit();
        }

        $resultado = $clienteModel->registrar($data);

        if ($resultado === 'registro_exitoso') {
            $_SESSION['mensaje'] = 'Cliente registrado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } elseif ($resultado === 'telefono_existente') {
            $_SESSION['mensaje'] = 'Error: El teléfono ya está registrado';
            $_SESSION['tipo_mensaje'] = 'error';
        } elseif ($resultado === 'cedula_existente') {
            $_SESSION['mensaje'] = 'Error: La cédula ya está registrada';
            $_SESSION['tipo_mensaje'] = 'error';
        } elseif ($resultado === 'correo_existente') {
            $_SESSION['mensaje'] = 'Error: El correo ya está registrado';
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = 'Error inesperado al registrar el cliente';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=cliente');
        exit();
    }
}

function cliente_editar() {
    $clienteModel = new \RapiExpress\Models\Cliente();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'ID_Cliente' => (int)$_POST['ID_Cliente'],
            'Cedula_Identidad' => trim($_POST['Cedula_Identidad']),
            'Nombres_Cliente' => trim($_POST['Nombres_Cliente']),
            'Apellidos_Cliente' => trim($_POST['Apellidos_Cliente']),
            'Direccion_Cliente' => trim($_POST['Direccion_Cliente']),
            'Telefono_Cliente' => trim($_POST['Telefono_Cliente']),
            'Correo_Cliente' => trim($_POST['Correo_Cliente']),
            'ID_Sucursal' => (int)$_POST['ID_Sucursal'],
            'ID_Casillero' => (int)$_POST['ID_Casillero']
        ];

        // Validaciones
        $errores = [];

        $errores[] = validarCampoRequerido($data['Cedula_Identidad'], 'Cédula');
        $errores[] = validarCedula($data['Cedula_Identidad']);
        $errores[] = validarCampoRequerido($data['Nombres_Cliente'], 'Nombres');
        $errores[] = validarNombre($data['Nombres_Cliente'], 'Nombres');
        $errores[] = validarCampoRequerido($data['Apellidos_Cliente'], 'Apellidos');
        $errores[] = validarNombre($data['Apellidos_Cliente'], 'Apellidos');
        $errores[] = validarCampoRequerido($data['Direccion_Cliente'], 'Dirección');
        $errores[] = validarNombreAlfanumerico($data['Direccion_Cliente'], 'Dirección');
        $errores[] = validarCampoRequerido($data['Telefono_Cliente'], 'Teléfono');
        $errores[] = validarTelefono($data['Telefono_Cliente']);
        $errores[] = validarCampoRequerido($data['Correo_Cliente'], 'Correo');
        $errores[] = validarCorreo($data['Correo_Cliente']);

        $errores = array_filter($errores);

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode(" ", $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=cliente');
            exit();
        }

        $resultado = $clienteModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Cliente actualizado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } elseif ($resultado === 'telefono_existente') {
            $_SESSION['mensaje'] = 'Error: El teléfono ya está registrado por otro cliente';
            $_SESSION['tipo_mensaje'] = 'error';
        } elseif ($resultado === 'cedula_existente') {
            $_SESSION['mensaje'] = 'Error: La cédula ya está registrada por otro cliente';
            $_SESSION['tipo_mensaje'] = 'error';
        } elseif ($resultado === 'correo_existente') {
            $_SESSION['mensaje'] = 'Error: El correo ya está registrado por otro cliente';
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar el cliente';
            $_SESSION['tipo_mensaje'] = 'error';
        }


        header('Location: index.php?c=cliente');
        exit();
    }
}

function cliente_eliminar() {
    $clienteModel = new \RapiExpress\Models\Cliente();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        $resultado = $clienteModel->eliminar($id);

        if ($resultado) {
            $_SESSION['mensaje'] = 'Cliente eliminado exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar el cliente';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=cliente');
        exit();
    }
}

function cliente_obtenerCliente() {
    $clienteModel = new \RapiExpress\Models\Cliente();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $cliente = $clienteModel->obtenerPorId($id);

        header('Content-Type: application/json');
        echo json_encode($cliente);
        exit();
    }
}
