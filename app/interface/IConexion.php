<?php
namespace RapiExpress\Interface;

interface IConexion {

    public function inicializarConexion();
    public function verificarEstructura(): bool;
}
