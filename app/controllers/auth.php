<?php
session_start();

use function RapiExpress\Helpers\base_url;
use RapiExpress\Models\Auth;

function auth_login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Username = trim($_POST['Username']);
        $password = trim($_POST['Password']);

        if (!empty($Username) && !empty($password)) {
            $authModel = new Auth();
            $usuario = $authModel->autenticar($Username, $password);

            if ($usuario) {
                $_SESSION['usuario'] = $usuario['Username'];
                $_SESSION['nombre_completo'] = $usuario['Nombres_Usuario'] . ' ' . $usuario['Apellidos_Usuario'];

                if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'success', 'message' => 'Inicio de sesión exitoso']);
                    exit;
                } else {
                    header('Location: ' . base_url('index.php?c=dashboard&a=index'));
                    exit();
                }
            } else {
                $error = "Credenciales inválidas.";
            }
        } else {
            $error = "Por favor, completa todos los campos.";
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $error]);
            exit;
        }
    }

    include __DIR__ . '/../views/auth/login.php';
}

function auth_recoverPassword() {
    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['Username'] ?? '');
        $newPassword = trim($_POST['Password'] ?? '');

        if (!empty($username) && !empty($newPassword)) {
            $authModel = new Auth();
            $resultado = $authModel->recuperarPassword($username, $newPassword);

            if ($resultado === true) {
                $success = "Contraseña actualizada correctamente.";
            } elseif ($resultado === 'no_encontrado') {
                $error = "Usuario no encontrado.";
            } else {
                $error = "Error al actualizar la contraseña.";
            }
        } else {
            $error = "Por favor, completa todos los campos.";
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $success ? 'success' : 'error',
                'message' => $success ?: $error
            ]);
            exit;
        }
    }

    include __DIR__ . '/../views/auth/recoverpassword.php';
}

function auth_logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: ' . base_url('index.php?c=auth&a=login'));
    exit();
}
