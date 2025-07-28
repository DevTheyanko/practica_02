<?php

namespace RapiExpress\Helpers;



function validarCampoRequerido($campo, $nombreCampo) {
    if (empty(trim($campo))) {
        return "$nombreCampo es obligatorio.";
    }
    return null;
}

function validarLongitud($campo, $nombreCampo, $maxLength) {
    if (strlen($campo) > $maxLength) {
        return "$nombreCampo no debe exceder los $maxLength caracteres.";
    }
    return null;
}

function validarCorreo($correo) {
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        return "El correo electrónico no es válido.";
    }
    return null;
}

function validarTelefono($telefono) {
    if (!preg_match('/^\d{7,15}$/', $telefono)) {
        return "El número de teléfono debe contener solo dígitos (7 a 15 caracteres).";
    }
    return null;
}

function validarNombre($nombre, $nombreCampo = "El nombre") {
    if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u', $nombre)) {
        return "$nombreCampo contiene caracteres inválidos.";
    }
    return null;
}

function validarUsuario($usuario) {
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $usuario)) {
        return "El nombre de usuario debe tener entre 3 y 20 caracteres y solo puede contener letras, números y guiones bajos.";
    }
    return null;
}

function validarCedula($cedula) {
    if (!preg_match('/^[0-9]{6,23}$/', $cedula)) {
        return "La cédula debe contener entre 6 y 23 dígitos.";
    }
    return null;
}

function validarRif($rif) {
    if (!preg_match('/^[JGVEP]{1}-\d{8}-\d{1}$/', strtoupper($rif))) {
        return "El RIF no tiene un formato válido. Ej: J-12345678-9";
    }
    return null;
}

function validarNombreAlfanumerico($campo, $nombreCampo, $maxLength = 50) {
    if (!preg_match('/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()_]+$/u', $campo)) {
        return "$nombreCampo solo debe contener letras, números y caracteres permitidos (,.-())";
    }
    if (strlen($campo) > $maxLength) {
        return "$nombreCampo no debe superar los $maxLength caracteres.";
    }
    return null;
}

function validarNumeroPositivo($valor, $nombreCampo) {
    if (!is_numeric($valor) || $valor < 0) {
        return "$nombreCampo debe ser un número positivo.";
    }
    return null;
}

function validarEnteroPositivo($valor, $nombreCampo) {
    if (!preg_match('/^\d+$/', $valor)) {
        return "$nombreCampo debe ser un número entero positivo.";
    }
    return null;
}




?>
