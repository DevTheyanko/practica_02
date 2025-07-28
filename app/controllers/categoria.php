<?php
use function RapiExpress\Helpers\base_url;
use RapiExpress\Models\Categoria;
use function RapiExpress\Helpers\validarCampoRequerido;
use function RapiExpress\Helpers\validarNombreAlfanumerico;
use function RapiExpress\Helpers\validarNumeroPositivo;
use function RapiExpress\Helpers\validarEnteroPositivo;

require_once __DIR__ . '/../interface/ICategoriaModel.php';
require_once __DIR__ . '/../models/Categoria.php';

function categoria_index() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $categoriaModel = new Categoria();
    $categorias = $categoriaModel->obtenerTodos();
    include __DIR__ . '/../views/categoria/categoria.php';
}

function categoria_registrar() {
    $categoriaModel = new Categoria();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'nombre'   => trim($_POST['nombre']),
            'altura'   => $_POST['altura'],
            'largo'    => $_POST['largo'],
            'ancho'    => $_POST['ancho'],
            'peso'     => $_POST['peso'],
            'piezas'   => $_POST['piezas'],
            'precio'   => $_POST['precio']
        ];

        $errores = [];

        // Validaciones
        if ($categoriaModel->verificarCategoriaExistente($data['nombre'])) {
                $errores[] = "El nombre de la categoría ya está registrado.";
            }

        if ($error = validarCampoRequerido($data['nombre'], 'Nombre')) {
            $errores[] = $error;
        } elseif ($error = validarNombreAlfanumerico($data['nombre'], 'Nombre')) {
            $errores[] = $error;
        }

        foreach (['altura', 'largo', 'ancho', 'peso', 'precio'] as $campo) {
            if ($error = validarCampoRequerido($data[$campo], ucfirst($campo))) {
                $errores[] = $error;
            } elseif ($error = validarNumeroPositivo($data[$campo], ucfirst($campo))) {
                $errores[] = $error;
            }
        }

        if ($error = validarCampoRequerido($data['piezas'], 'Piezas')) {
            $errores[] = $error;
        } elseif ($error = validarEnteroPositivo($data['piezas'], 'Piezas')) {
            $errores[] = $error;
        }

        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode('<br>', $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=categoria');
            exit();
        }

        // Conversión de tipo
        $data['altura'] = floatval($data['altura']);
        $data['largo']  = floatval($data['largo']);
        $data['ancho']  = floatval($data['ancho']);
        $data['peso']   = floatval($data['peso']);
        $data['precio'] = floatval($data['precio']);
        $data['piezas'] = intval($data['piezas']);

        $resultado = $categoriaModel->registrar($data);

        if ($resultado === 'registro_exitoso') {
            $_SESSION['mensaje'] = 'Categoría registrada exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al registrar la categoría';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=categoria');
        exit();
    }
}
function categoria_editar() {
    $categoriaModel = new Categoria();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'ID_Categoria' => $_POST['ID_Categoria'] ?? null,
            'nombre'       => trim($_POST['nombre'] ?? ''),
            'altura'       => $_POST['altura'] ?? '',
            'largo'        => $_POST['largo'] ?? '',
            'ancho'        => $_POST['ancho'] ?? '',
            'peso'         => $_POST['peso'] ?? '',
            'piezas'       => $_POST['piezas'] ?? '',
            'precio'       => $_POST['precio'] ?? ''
        ];

        $errores = [];

        // Validar ID
        
        if (empty($data['ID_Categoria'])) {
            $errores[] = "ID de la categoría es obligatorio.";
        }
        if ($categoriaModel->verificarCategoriaExistente($data['nombre'], $data['ID_Categoria'])) {
            $errores[] = "El nombre de la categoría ya pertenece a otro registro.";
            }


        // Validar nombre
        if ($error = validarCampoRequerido($data['nombre'], 'Nombre')) {
            $errores[] = $error;
        } elseif ($error = validarNombreAlfanumerico($data['nombre'], 'Nombre')) {
            $errores[] = $error;
        }

        // Validar campos numéricos (altura, largo, ancho, peso, precio)
        foreach (['altura', 'largo', 'ancho', 'peso', 'precio'] as $campo) {
            if ($error = validarCampoRequerido($data[$campo], ucfirst($campo))) {
                $errores[] = $error;
            } elseif ($error = validarNumeroPositivo($data[$campo], ucfirst($campo))) {
                $errores[] = $error;
            }
        }

        // Validar piezas
        if ($error = validarCampoRequerido($data['piezas'], 'Piezas')) {
            $errores[] = $error;
        } elseif ($error = validarEnteroPositivo($data['piezas'], 'Piezas')) {
            $errores[] = $error;
        }

        // Si hay errores, retornar
        if (!empty($errores)) {
            $_SESSION['mensaje'] = implode('<br>', $errores);
            $_SESSION['tipo_mensaje'] = 'error';
            header('Location: index.php?c=categoria');
            exit();
        }

        // Conversión segura
        $data['ID_Categoria'] = (int)$data['ID_Categoria'];
        $data['altura'] = floatval($data['altura']);
        $data['largo']  = floatval($data['largo']);
        $data['ancho']  = floatval($data['ancho']);
        $data['peso']   = floatval($data['peso']);
        $data['precio'] = floatval($data['precio']);
        $data['piezas'] = intval($data['piezas']);

        $resultado = $categoriaModel->actualizar($data);

        if ($resultado === true) {
            $_SESSION['mensaje'] = 'Categoría actualizada exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al actualizar la categoría';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=categoria');
        exit();
    }
}
function categoria_eliminar() {
    $categoriaModel = new Categoria();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];

        $resultado = $categoriaModel->eliminar($id);

        if ($resultado) {
            $_SESSION['mensaje'] = 'Categoría eliminada exitosamente';
            $_SESSION['tipo_mensaje'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar la categoría';
            $_SESSION['tipo_mensaje'] = 'error';
        }

        header('Location: index.php?c=categoria');
        exit();
    }
}

function categoria_obtener() {
    $categoriaModel = new Categoria();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $categoria = $categoriaModel->obtenerPorId($id);

        header('Content-Type: application/json');
        echo json_encode($categoria);
        exit();
    }
}
