<?php

use function RapiExpress\Helpers\base_url;

use RapiExpress\Models\Usuario;
use RapiExpress\Config\Conexion;
use function RapiExpress\Helpers\{
    validarCampoRequerido,
    validarCedula,
    validarCorreo,
    validarTelefono,
    validarNombre,
    validarUsuario
};

function usuario_index() {
    $sucursalModel = new \RapiExpress\Models\Sucursal();    // Instancia
    $cargoModel = new \RapiExpress\Models\Cargo();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $sucursales = $sucursalModel->obtenerTodas();
    $cargos = $cargoModel->obtenerTodos();
    $usuarios = obtenerTodosUsuarios();
    include __DIR__ . '/../views/usuario/usuario.php';
}

function usuario_registrar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'Cedula_Identidad'   => trim($_POST['Cedula_Identidad']),
            'Username'           => trim($_POST['Username']),
            'Nombres_Usuario'    => trim($_POST['Nombres_Usuario']),
            'Apellidos_Usuario'  => trim($_POST['Apellidos_Usuario']),
            'Correo_Usuario'     => trim($_POST['Correo_Usuario']),
            'Telefono_Usuario'   => trim($_POST['Telefono_Usuario']),
            'ID_Sucursal'        => trim($_POST['ID_Sucursal']),
            'ID_Cargo'           => trim($_POST['ID_Cargo']),
            'Password'           => trim($_POST['Password']),
            'Direccion_Usuario'  => trim($_POST['Direccion_Usuario'] ?? '')
        ];

        // Validaciones de campos requeridos
        foreach (['Cedula_Identidad', 'Username', 'Nombres_Usuario', 'Apellidos_Usuario', 'Correo_Usuario', 'Password', 'Telefono_Usuario'] as $campo) {
            $error = validarCampoRequerido($data[$campo], $campo);
            if ($error) {
                $_SESSION['mensaje'] = $error;
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?c=usuario');
                exit();
            }
        }

        // Validaciones específicas
        if ($error = validarCedula($data['Cedula_Identidad'])) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }
        if ($error = validarUsuario($data['Username'])) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }
        if ($error = validarNombre($data['Nombres_Usuario'], "Nombres")) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }
        if ($error = validarNombre($data['Apellidos_Usuario'], "Apellidos")) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }
        if ($error = validarCorreo($data['Correo_Usuario'])) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }
        if ($error = validarTelefono($data['Telefono_Usuario'])) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }

        // Hashear la contraseña
        $data['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);

        $usuario = new Usuario($data);
        $resultado = $usuario->registrar();

        switch ($resultado) {
            case 'registro_exitoso':
                $_SESSION['mensaje'] = 'Usuario registrado exitosamente.';
                $_SESSION['tipo_mensaje'] = 'success';
                break;
            case 'documento_existente':
                $_SESSION['mensaje'] = 'El cedula ya está registrado.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            case 'email_existente':
                $_SESSION['mensaje'] = 'El correo electrónico ya está registrado.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            case 'username_existente':
                $_SESSION['mensaje'] = 'El nombre de usuario ya está registrado.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            case 'telefono_existente':
                $_SESSION['mensaje'] = 'El teléfono ya está registrado.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
            default:
                $_SESSION['mensaje'] = 'Error al registrar el usuario.';
                $_SESSION['tipo_mensaje'] = 'error';
                break;
        }

        header('Location: index.php?c=usuario');
        exit();
    }
}

function usuario_editar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = ['ID_Usuario', 'Username', 'Nombres_Usuario', 'Apellidos_Usuario', 'Correo_Usuario', 'Telefono_Usuario', 'ID_Sucursal', 'ID_Cargo'];
        foreach ($required as $field) {
            $error = validarCampoRequerido(trim($_POST[$field] ?? ''), $field);
            if ($error) {
                $_SESSION['mensaje'] = "Error: " . $error;
                $_SESSION['tipo_mensaje'] = 'error';
                header('Location: index.php?c=usuario');
                exit();
            }
        }

        $data = [
    'ID_Usuario'        => trim($_POST['ID_Usuario']),
    'Cedula_Identidad'  => trim($_POST['Cedula_Identidad']),
    'Username'          => trim($_POST['Username']),
    'Nombres_Usuario'   => trim($_POST['Nombres_Usuario']),
    'Apellidos_Usuario' => trim($_POST['Apellidos_Usuario']),
    'Correo_Usuario'    => trim($_POST['Correo_Usuario']),
    'Telefono_Usuario'  => trim($_POST['Telefono_Usuario']),
    'ID_Sucursal'       => trim($_POST['ID_Sucursal']),
    'ID_Cargo'          => trim($_POST['ID_Cargo']),
    'Direccion_Usuario' => trim($_POST['Direccion_Usuario'] ?? '')
        ];



        // Validaciones específicas
        if ($error = validarUsuario($data['Username'])) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }
        if ($error = validarNombre($data['Nombres_Usuario'], "Nombres")) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }
        if ($error = validarNombre($data['Apellidos_Usuario'], "Apellidos")) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }
        if ($error = validarCorreo($data['Correo_Usuario'])) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }
        if ($error = validarTelefono($data['Telefono_Usuario'])) {
            $_SESSION['mensaje'] = $error;
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }

        $usuario = new Usuario();
        $resultado = $usuario->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Usuario actualizado exitosamente.';
            $_SESSION['tipo_mensaje'] = 'success';
        } else if ($resultado === 'username_existente') {
            $_SESSION['mensaje'] = 'El nombre de usuario ya está registrado.';
            $_SESSION['tipo_mensaje'] = 'error';
        } else if ($resultado === 'documento_existente') {
            $_SESSION['mensaje'] = 'El cedula ya está registrado.';
            $_SESSION['tipo_mensaje'] = 'error';
        } else if ($resultado === 'email_existente') {
            $_SESSION['mensaje'] = 'El correo electrónico ya está registrado.';
            $_SESSION['tipo_mensaje'] = 'error';
        } else if ($resultado === 'telefono_existente') {
            $_SESSION['mensaje'] = 'El teléfono ya está registrado.';
            $_SESSION['tipo_mensaje'] = 'error';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar el usuario.';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=usuario');
        exit();
    }
}

function usuario_eliminar() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ID_Usuario = $_POST['ID_Usuario'];
        $usuarioActual = $_SESSION['usuario'];

        $usuarioModel = new Usuario();
        $usuarioAEliminar = $usuarioModel->obtenerPorId($ID_Usuario);

        if ($usuarioAEliminar && $usuarioAEliminar['Username'] === $usuarioActual) {
            $_SESSION['mensaje'] = 'No puedes eliminar tu propia cuenta mientras estás logueado.';
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=usuario');
            exit();
        }

        $resultado = $usuarioModel->eliminar($ID_Usuario);

        if ($resultado) {
            $_SESSION['mensaje'] = 'Usuario eliminado exitosamente.';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar el usuario.';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=usuario');
        exit();
    }
}

function obtenerTodosUsuarios() {
    $usuarioModel = new Usuario();
    return $usuarioModel->obtenerTodos();
}
