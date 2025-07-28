<?php
namespace RapiExpress\Helpers;

function base_url($ruta = '') {
    return '/System_RapiExpress/public/' . ltrim($ruta, '/');
}
