<?php
use function RapiExpress\Helpers\base_url;


use RapiExpress\Models\Tienda;
use function RapiExpress\Helpers\{
    validarCampoRequerido,
    validarCorreo,
    validarTelefono,
    validarNombreAlfanumerico
};

function tienda_index() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $tiendaModel = new Tienda();
    $tiendas = $tiendaModel->obtenerTodas();
    include __DIR__ . '/../views/tienda/tienda.php';
}

function tienda_registrar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $tiendaModel = new Tienda();

        $nombre = trim($_POST['nombre_tienda']);
        $direccion = trim($_POST['direccion_tienda']);
        $telefono = trim($_POST['telefono_tienda']);
        $correo = trim($_POST['correo_tienda']);

        $errores = [];

        // Validaciones
        if ($error = validarCampoRequerido($nombre, "Nombre de tienda")) $errores[] = $error;
        if ($error = validarCampoRequerido($direccion, "Dirección de tienda")) $errores[] = $error;
        if ($error = validarCampoRequerido($telefono, "Teléfono de tienda")) $errores[] = $error;
        if ($error = validarCampoRequerido($correo, "Correo de tienda")) $errores[] = $error;

        if ($error = validarNombreAlfanumerico($nombre, "Nombre de tienda", 50)) $errores[] = $error;
        if ($error = validarNombreAlfanumerico($direccion, "Dirección de tienda", 100)) $errores[] = $error;
        if ($error = validarTelefono($telefono)) $errores[] = $error;
        if ($error = validarCorreo($correo)) $errores[] = $error;

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode("<br>", $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=tienda');
            exit();
        }

        $data = compact('nombre', 'direccion', 'telefono', 'correo');
        $data = [
            'nombre_tienda' => $nombre,
            'direccion_tienda' => $direccion,
            'telefono_tienda' => $telefono,
            'correo_tienda' => $correo,
        ];

        $resultado = $tiendaModel->registrar($data);

        switch ($resultado) {
            case 'registro_exitoso':
                $_SESSION['mensaje'] = 'Tienda registrada exitosamente.';
                $_SESSION['tipo_mensaje'] = 'success';
                break;
            case 'nombre_existente':
                $_SESSION['mensaje'] = 'Error: Ya existe una tienda con ese nombre.';
                $_SESSION['tipo_mensaje'] = 'warning';
                break;
            case 'direccion_existente':
                $_SESSION['mensaje'] = 'Error: Ya existe una tienda con esa dirección.';
                $_SESSION['tipo_mensaje'] = 'warning';
                break;
            case 'telefono_existente':
                $_SESSION['mensaje'] = 'Error: Ya existe una tienda con ese teléfono.';
                $_SESSION['tipo_mensaje'] = 'warning';
                break;
            case 'correo_existente':
                $_SESSION['mensaje'] = 'Error: Ya existe una tienda con ese correo.';
                $_SESSION['tipo_mensaje'] = 'warning';
                break;
            case 'error_bd':
            default:
                $_SESSION['mensaje'] = 'Error al registrar la tienda.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
        }

        header('Location: index.php?c=tienda');
        exit();
    }
}

function tienda_editar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $tiendaModel = new Tienda();

        $id = $_POST['id_tienda'];
        $nombre = trim($_POST['nombre_tienda']);
        $direccion = trim($_POST['direccion_tienda']);
        $telefono = trim($_POST['telefono_tienda']);
        $correo = trim($_POST['correo_tienda']);

        $errores = [];

        // Validaciones
        if ($error = validarCampoRequerido($id, "ID de tienda")) $errores[] = $error;
        if ($error = validarCampoRequerido($nombre, "Nombre de tienda")) $errores[] = $error;
        if ($error = validarCampoRequerido($direccion, "Dirección de tienda")) $errores[] = $error;
        if ($error = validarCampoRequerido($telefono, "Teléfono de tienda")) $errores[] = $error;
        if ($error = validarCampoRequerido($correo, "Correo de tienda")) $errores[] = $error;

        if ($error = validarNombreAlfanumerico($nombre, "Nombre de tienda", 50)) $errores[] = $error;
        if ($error = validarNombreAlfanumerico($direccion, "Dirección de tienda", 100)) $errores[] = $error;
        if ($error = validarTelefono($telefono)) $errores[] = $error;
        if ($error = validarCorreo($correo)) $errores[] = $error;

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode("<br>", $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=tienda');
            exit();
        }

        $data = [
            'id_tienda' => (int)$id,
            'nombre_tienda' => $nombre,
            'direccion_tienda' => $direccion,
            'telefono_tienda' => $telefono,
            'correo_tienda' => $correo,
        ];

        $resultado = $tiendaModel->actualizar($data);
        
        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Tienda actualizada exitosamente.';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            switch ($resultado) {
                case 'nombre_existente':
                    $_SESSION['mensaje'] = 'Error: Ya existe una tienda con ese nombre.';
                    $_SESSION['tipo_mensaje'] = 'warning';
                    break;
                case 'direccion_existente':
                    $_SESSION['mensaje'] = 'Error: Ya existe una tienda con esa dirección.';
                    $_SESSION['tipo_mensaje'] = 'warning';
                    break;
                case 'telefono_existente':
                    $_SESSION['mensaje'] = 'Error: Ya existe una tienda con ese teléfono.';
                    $_SESSION['tipo_mensaje'] = 'warning';
                    break;
                case 'correo_existente':
                    $_SESSION['mensaje'] = 'Error: Ya existe una tienda con ese correo.';
                    $_SESSION['tipo_mensaje'] = 'warning';
                    break;
                case 'error_bd':
                case 'error_actualizar':
                default:
                    $_SESSION['mensaje'] = 'Error al actualizar la tienda.';
                    $_SESSION['tipo_mensaje'] = 'error';
                    break;
            }
        }


        header('Location: index.php?c=tienda');
        exit();
    }
}

function tienda_eliminar() {
    session_start();

    if (isset($_POST['id_tienda'])) {
        $id = $_POST['id_tienda'];
        $tiendaModel = new Tienda();

        $eliminado = $tiendaModel->eliminar($id);

        if ($eliminado) {
            $_SESSION['mensaje'] = "Tienda eliminada correctamente.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar la tienda.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "ID de tienda no proporcionado.";
        $_SESSION['tipo_mensaje'] = "danger";
    }

    header("Location: index.php?c=tienda");
    exit();
}

function tienda_obtenerTienda() {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $tiendaModel = new Tienda();

        $tienda = $tiendaModel->obtenerPorId($id);
        header('Content-Type: application/json');
        echo json_encode($tienda);
        exit();
    }
}
