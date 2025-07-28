<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>RapiExpress - Couriers</title>
    <link rel="icon" href="assets/img/logo-rapi.ico" type="image/x-icon">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
    
    <!-- JS -->
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>
</head>
<body>
    <?php include 'src/views/layout/barras.php'; ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Couriers</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php?c=dashboard&a=index">RapiExpress</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Couriers
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            <div class="pd-30">
                <h4 class="text-blue h4">Lista de Couriers</h4>
                <?php include 'src\views\layout\notificaciones.php'; ?>
                <div class="pull-right">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#courierModal">
                        <i class="fa fa-plus"></i> Agregar Courier
                    </button>
                </div>
            </div>
            <div class="pb-30">
    <table class="data-table table stripe hover nowrap" id="courierTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>RIF</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th class="datatable-nosort">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($couriers as $courier): ?>
            <tr>
                <td><?= htmlspecialchars($courier['ID_Courier']) ?></td>
                <td><?= htmlspecialchars($courier['RIF_Courier']) ?></td>
                <td><?= htmlspecialchars($courier['Courier_Nombre']) ?></td>
                <td><?= htmlspecialchars($courier['Courier_Direccion']) ?></td>
                <td><?= htmlspecialchars($courier['Courier_Telefono']) ?></td>
                <td><?= htmlspecialchars($courier['Courier_Correo']) ?></td>
                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                             <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-courier-modal-<?= $courier['ID_Courier'] ?>">
                                <i class="dw dw-eye"></i> Ver Detalles
                            </a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-courier-modal-<?= $courier['ID_Courier'] ?>">
                                <i class="dw dw-edit2"></i> Editar
                            </a>
                            <a class="dropdown-item" href="#"  data-toggle="modal"    data-target="#delete-courier-modal"  data-id="<?= $courier['ID_Courier'] ?>">

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
<!-- Modal Agregar Courier -->
<div class="modal fade" id="courierModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="index.php?c=courier&a=registrar">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Courier</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <?php
                    $campos = [
                        'RIF_Courier' => 'RIF',
                        'Courier_Nombre' => 'Nombre',
                        'Courier_Direccion' => 'Dirección',
                        'Courier_Telefono' => 'Teléfono',
                        'Courier_Correo' => 'Correo'
                    ];
                    ?>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">RIF</label>
                        <div class="col-sm-9">
                            <input type="text" name="RIF_Courier" class="form-control" required
                                pattern="[JGVEP]{1}-\d{8}-\d{1}" maxlength="20"
                                title="Formato válido: J-12345678-9">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" name="Courier_Nombre" class="form-control" required
                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,20}"
                                title="Solo letras y espacios. Máximo 20 caracteres." maxlength="20">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dirección</label>
                        <div class="col-sm-9">
                            <input type="text" name="Courier_Direccion" class="form-control" required
                                pattern="[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()_]{1,100}"
                                title="Dirección válida: letras, números y ,.-()_" maxlength="100">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Teléfono</label>
                        <div class="col-sm-9">
                            <input type="text" name="Courier_Telefono" class="form-control" required
                                pattern="\d{7,15}" title="Solo dígitos. Entre 7 y 20 caracteres." maxlength="20">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Correo</label>
                        <div class="col-sm-9">
                            <input type="email" name="Courier_Correo" class="form-control" required
                                maxlength="100">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($couriers as $courier): ?>
<div class="modal fade bs-example-modal-lg" id="view-courier-modal-<?= $courier['ID_Courier'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalles del Courier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>RIF</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($courier['RIF_Courier']) ?>" readonly>
                        </div>
                    </div>                             
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre del Courier</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($courier['Courier_Nombre']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Dirección</label>
                            <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($courier['Courier_Direccion']) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($courier['Courier_Telefono']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($courier['Courier_Correo']) ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modales Editar -->
<?php foreach ($couriers as $c): ?>
<div class="modal fade" id="edit-courier-modal-<?= $c['ID_Courier'] ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="index.php?c=courier&a=editar">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Courier</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ID_Courier" value="<?= $c['ID_Courier'] ?>">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">RIF</label>
                        <div class="col-sm-9">
                            <input type="text" name="RIF_Courier" class="form-control" required
                                pattern="[JGVEP]{1}-\d{8}-\d{1}" maxlength="23"
                                title="Formato válido: J-12345678-9"
                                value="<?= htmlspecialchars($c['RIF_Courier']) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" name="Courier_Nombre" class="form-control" required
                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{1,50}"
                                maxlength="50"
                                title="Solo letras y espacios. Máximo 50 caracteres."
                                value="<?= htmlspecialchars($c['Courier_Nombre']) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dirección</label>
                        <div class="col-sm-9">
                            <input type="text" name="Courier_Direccion" class="form-control" required
                                pattern="[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()_]{1,100}"
                                maxlength="100"
                                title="Dirección válida: letras, números y ,.-()_"
                                value="<?= htmlspecialchars($c['Courier_Direccion']) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Teléfono</label>
                        <div class="col-sm-9">
                            <input type="text" name="Courier_Telefono" class="form-control" required
                                pattern="\d{7,15}" maxlength="15"
                                title="Solo dígitos. Entre 7 y 15 caracteres."
                                value="<?= htmlspecialchars($c['Courier_Telefono']) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Correo</label>
                        <div class="col-sm-9">
                            <input type="email" name="Courier_Correo" class="form-control" required
                                maxlength="100"
                                value="<?= htmlspecialchars($c['Courier_Correo']) ?>">
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


<!-- Modal para Eliminar Courier -->
<div class="modal fade" id="delete-courier-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Courier?</h4>
                <p class="mb-30 text-muted">Esta acción no se puede deshacer.<br>¿Está seguro que desea eliminar este courier?</p>

                <form method="POST" action="index.php?c=courier&a=eliminar">
                    <input type="hidden" name="ID_Courier" id="delete_courier_id">
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
<script>$('#delete-courier-modal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget); // Botón que activó el modal
    const id = button.data('id'); // Supongamos: data-id="5"
    $('#delete_courier_id').val(id);
});
</script>


        <div class="footer-wrap pd-20 mb-20 card-box">
            RapiExpress © 2025 - Sistema de Gestión de Paquetes                
        </div>
    </div>
</div>
</body>
</html>