<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>RapiExpress</title>
    <link rel="icon" href="assets\img\logo-rapi.ico" type="image/x-icon">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>
<body>
    <?php include 'src\views\layout\barras.php'; ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Clientes</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php?c=dashboard&a=index">RapiExpress</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Clientes
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            <div class="pd-30">
                <h4 class="text-blue h4">Lista de Clientes</h4>
                <?php include 'src\views\layout\notificaciones.php'; ?>

                <div class="pull-right">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#clienteModal">
                        <i class="fa fa-user-plus"></i> Agregar Cliente
                    </button>
                </div>
            </div>
         <div class="pb-30">
    <table class="data-table table stripe hover nowrap" id="clientesTable">
        <thead>
              <tr>
            <th>Cédula</th>
            <th>Sucursal</th>
            <th>Casillero</th>
            <th>Nombre y Apellido</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Fecha Registro</th>
            <th class="datatable-nosort">Acciones</th>
        </tr>
        </thead>
        <tbody>
             <?php foreach ($clientes as $cliente): ?>                     
         <tr>
            <td><?= htmlspecialchars($cliente['Cedula_Identidad']) ?></td>
            <td><?= htmlspecialchars($cliente['Sucursal_Nombre'] ?? 'Sin sucursal') ?></td>
            <td><?= htmlspecialchars($cliente['Casillero_Nombre'] ?? 'Sin casillero') ?></td>
            <td class="table-plus"><?= htmlspecialchars($cliente['Nombres_Cliente'] . ' ' . $cliente['Apellidos_Cliente']) ?></td>
            <td><?= htmlspecialchars($cliente['Direccion_Cliente']) ?></td>
            <td><?= htmlspecialchars($cliente['Telefono_Cliente']) ?></td>
            <td><?= htmlspecialchars($cliente['Correo_Cliente']) ?></td>
            <td><?= date('d/m/Y', strtotime($cliente['Fecha_Registro'])) ?></td>
            <td>               
            
             
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-cliente-modal-<?= $cliente['ID_Cliente'] ?>">
                                <i class="dw dw-eye"></i> Ver Detalles
                            </a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-cliente-modal-<?= $cliente['ID_Cliente'] ?>">
                                <i class="dw dw-edit2"></i> Editar
                            </a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-cliente-modal" 
                               onclick="document.getElementById('delete_cliente_id').value = <?= $cliente['ID_Cliente'] ?>">
                                <i class="dw dw-delete-3"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Modal para agregar cliente -->
<div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="index.php?c=cliente&a=registrar">
                <div class="modal-header">
                    <h5 class="modal-title" id="clienteModalLabel">Registrar Nuevo Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!-- Cédula -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cédula</label>
                                <input type="text" class="form-control" name="Cedula_Identidad"
                                       pattern="\d{6,23}" title="La cédula debe tener entre 6 y 10 dígitos"
                                       required  maxlength="23">
                            </div>
                        </div>

                        <!-- Sucursal -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sucursal</label>
                                <select class="form-control" name="ID_Sucursal" required>
                                    <option value="">Seleccione sucursal</option>
                                    <?php foreach ($sucursales as $sucursal): ?>
                                        <option value="<?= $sucursal['ID_Sucursal'] ?>">
                                            <?= htmlspecialchars($sucursal['Sucursal_Nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Casillero -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Casillero</label>
                                <select class="form-control" name="ID_Casillero" required>
                                    <option value="">Seleccione un casillero</option>
                                    <?php foreach ($casilleros as $casillero): ?>
                                        <option value="<?= $casillero['ID_Casillero'] ?>">
                                            <?= htmlspecialchars($casillero['Casillero_Nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Nombres -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombres</label>
                                <input type="text" class="form-control" name="Nombres_Cliente"
                                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios"
                                       required  maxlength="20">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Apellidos -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Apellidos</label>
                                <input type="text" class="form-control" name="Apellidos_Cliente"
                                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios"
                                       required  maxlength="20">
                            </div>
                        </div>

                        <!-- Correo -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <input type="email" class="form-control" name="Correo_Cliente"
                                       title="Ingresa un correo válido"
                                       required  maxlength="100">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Teléfono -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" name="Telefono_Cliente"
                                       pattern="\d{7,15}" title="Solo dígitos (mínimo 7, máximo 15)"
                                       required  maxlength="20">
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dirección</label>
                                <textarea class="form-control" name="Direccion_Cliente" rows="3"
                                          maxlength="100"
                                          title="Máximo 100 caracteres. Se permiten letras, números y (,.-())"
                                          required  maxlength="255"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php foreach ($clientes as $cli): ?>
<div class="modal fade" id="edit-cliente-modal-<?= $cli['ID_Cliente'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="index.php?c=cliente&a=editar">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ID_Cliente" value="<?= htmlspecialchars($cli['ID_Cliente']) ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <label>Cédula de Identidad</label>
                            <input type="text" class="form-control" name="Cedula_Identidad"
                                value="<?= htmlspecialchars($cli['Cedula_Identidad']) ?>"
                                pattern="\d{6,10}" title="La cédula debe tener entre 6 y 10 dígitos" required maxlength="23">
                        </div>
                        <div class="col-md-6">
                            <label>Correo Electrónico</label>
                            <input type="email" class="form-control" name="Correo_Cliente"
                                value="<?= htmlspecialchars($cli['Correo_Cliente']) ?>"
                                title="Ingresa un correo válido" required>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Nombres</label>
                            <input type="text" class="form-control" name="Nombres_Cliente"
                                value="<?= htmlspecialchars($cli['Nombres_Cliente']) ?>"
                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios" required  maxlength="20">
                        </div>
                        <div class="col-md-6">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" name="Apellidos_Cliente"
                                value="<?= htmlspecialchars($cli['Apellidos_Cliente']) ?>"
                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras y espacios" required  maxlength="20">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label>Dirección</label>
                            <textarea class="form-control" name="Direccion_Cliente" rows="3"
                                maxlength="100"
                                title="Máximo 100 caracteres. Se permiten letras, números y (,.-())"
                                required  maxlength="255"><?= htmlspecialchars($cli['Direccion_Cliente']) ?></textarea>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" name="Telefono_Cliente"
                                value="<?= htmlspecialchars($cli['Telefono_Cliente']) ?>"
                                pattern="\d{7,15}" title="Solo dígitos (mínimo 7, máximo 15)" required maxlength="20">
                        </div>
                        <div class="col-md-6">
                            <label>Sucursal</label>
                            <select class="form-control" name="ID_Sucursal" required>
                                <option value="">Seleccione sucursal</option>
                                <?php foreach ($sucursales as $sucursal): ?>
                                    <option value="<?= $sucursal['ID_Sucursal'] ?>"
                                        <?= $sucursal['Sucursal_Nombre'] == $cli['Sucursal_Nombre'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sucursal['Sucursal_Nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Casillero</label>
                            <select class="form-control" name="ID_Casillero" required>
                                <option value="">Seleccione casillero</option>
                                <?php foreach ($casilleros as $casillero): ?>
                                    <option value="<?= $casillero['ID_Casillero'] ?>"
                                        <?= $casillero['Casillero_Nombre'] == $cli['Casillero_Nombre'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($casillero['Casillero_Nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Fecha de Registro</label>
                            <input type="text" class="form-control"
                                value="<?= date('d/m/Y H:i', strtotime($cli['Fecha_Registro'])) ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>





        <!-- Modal para Eliminar Cliente -->
        <div class="modal fade" id="delete-cliente-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">
                    <div class="modal-body">
                        <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                        <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Cliente?</h4>
                        <p class="mb-30 text-muted">Esta acción no se puede deshacer. <br>¿Está seguro que desea eliminar este cliente?</p>

                        <form method="POST" action="index.php?c=cliente&a=eliminar">
                            <input type="hidden" name="id" id="delete_cliente_id">
                            <div class="row justify-content-center gap-2" style="max-width: 200px; margin: 0 auto;">
                                <div class="col-6 px-1">
                                    <button type="button" class="btn btn-secondary btn-lg btn-block border-radius-100" data-dismiss="modal">
                                        <i class="fa fa-times"></i> No
                                    </button>
                                </div>
                                <div class="col-6 px-1">
                                    <button type="submit" class="btn btn-danger btn-lg btn-block border-radius-100">
                                        <i class="fa fa-check"></i> Sí
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="footer-wrap pd-20 mb-20 card-box">
            RapiExpress © 2025 - Sistema de Gestión de Paquetes                
        </div>
    </div>
</body>
</html>