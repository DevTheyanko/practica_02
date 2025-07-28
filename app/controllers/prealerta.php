<?php
require_once __DIR__ . '/../models/Prealerta.php';

function prealerta_index() {
    $prealertaModel = new \RapiExpress\Models\Prealerta();
    $clienteModel = new \RapiExpress\Models\Cliente();
    $casilleroModel = new \RapiExpress\Models\Casillero();
    $tiendaModel = new \RapiExpress\Models\Tienda();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $prealertas = $prealertaModel->obtenerTodas();
    $clientes = $clienteModel->obtenerTodos();
    $casilleros = $casilleroModel->obtenerTodos();
    $tiendas = $tiendaModel->obtenerTodas();

    include __DIR__ . '/../views/paquete/prealerta.php';
}

function prealerta_registrar() {
    $prealertaModel = new \RapiExpress\Models\Prealerta();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'ID_Prealerta' => (int)$_POST['ID_Prealerta'],
            'ID_Cliente' => (int)$_POST['ID_Cliente'],
            'ID_Tienda' => (int)$_POST['ID_Tienda'],
            'ID_Casillero' => (int)$_POST['ID_Casillero'],
            'Tienda_Traking' => trim($_POST['Tienda_Traking']),
            'Prealerta_Piezas' => (int)$_POST['Prealerta_Piezas'],
            'Prealerta_Peso' => (float)$_POST['Prealerta_Peso'],
            'Prealerta_Descripcion' => trim($_POST['Prealerta_Descripcion'])
        ];

        $resultado = $prealertaModel->registrar($data);

        if ($resultado === 'registro_exitoso') {
            $_SESSION['mensaje'] = 'Prealerta registrada exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al registrar la prealerta';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=prealerta');
        exit();
    }
}

function prealerta_editar() {
    $prealertaModel = new \RapiExpress\Models\Prealerta();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'ID_Prealerta' => (int)$_POST['ID_Prealerta'],
            'ID_Cliente' => (int)$_POST['ID_Cliente'],
            'ID_Tienda' => (int)$_POST['ID_Tienda'],
            'ID_Casillero' => (int)$_POST['ID_Casillero'],
            'Tienda_Traking' => trim($_POST['Tienda_Traking']),
            'Prealerta_Piezas' => (int)$_POST['Prealerta_Piezas'],
            'Prealerta_Peso' => (float)$_POST['Prealerta_Peso'],
            'Prealerta_Descripcion' => trim($_POST['Prealerta_Descripcion'])
        ];

        $resultado = $prealertaModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Prealerta actualizada exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar la prealerta';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=prealerta');
        exit();
    }
}

function prealerta_eliminar() {
    $prealertaModel = new \RapiExpress\Models\Prealerta();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        $resultado = $prealertaModel->eliminar($id);

        if ($resultado) {
            $_SESSION['mensaje'] = 'Prealerta eliminada exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar la prealerta';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=prealerta');
        exit();
    }
}

function prealerta_obtenerPrealerta() {
    $prealertaModel = new \RapiExpress\Models\Prealerta();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $prealerta = $prealertaModel->obtenerPorId($id);

        header('Content-Type: application/json');
        echo json_encode($prealerta);
        exit();
    }
}
