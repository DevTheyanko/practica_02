<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>RapiExpress - Casilleros</title>
    <link rel="icon" href="assets/img/logo-rapi.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

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
                    <h4>Casilleros</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php?c=dashboard">RapiExpress</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Casilleros</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card-box mb-30">
        <div class="pd-30">
            <h4 class="text-blue h4">Lista de Casilleros</h4>
            <?php include 'src/views/layout/notificaciones.php'; ?>
            <div class="pull-right">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#casilleroModal">
                    <i class="fa fa-plus"></i> Agregar Casillero
                </button>
            </div>
        </div>
        <div class="pb-30">
            <table class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th class="datatable-nosort">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($casilleros as $casillero): ?>
                        <tr>
                            <td><?= $casillero['ID_Casillero'] ?></td>
                            <td><?= htmlspecialchars($casillero['Casillero_Nombre']) ?></td>
                            <td><?= htmlspecialchars($casillero['Direccion']) ?></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-casillero-modal-<?= $casillero['ID_Casillero'] ?>">
                                            <i class="dw dw-eye"></i> Ver Detalles
                                        </a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-casillero-modal-<?= $casillero['ID_Casillero'] ?>">
                                            <i class="dw dw-edit2"></i> Editar
                                        </a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-casillero-modal"
                                           onclick="document.getElementById('delete_casillero_id').value = <?= $casillero['ID_Casillero'] ?>">
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
    </div>

    <!-- Modal Registrar -->
   <div class="modal fade" id="casilleroModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="index.php?c=casillero&a=registrar" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Casillero</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <label>Nombre</label>
                    <input type="text" name="Casillero_Nombre" class="form-control" required  maxlength="20"
                        pattern="[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()]"
                        title="Solo letras, números y los caracteres (,.-()) son permitidos. Máximo 50 caracteres.">
                </div>
                <div class="col-md-6">
                    <label>Dirección</label>
                    <input type="text" name="Direccion" class="form-control" required
                        maxlength="100"
                        title="La dirección es obligatoria y debe tener máximo 100 caracteres.">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" type="submit">Registrar</button>
            </div>
        </form>
    </div>
</div>


    <!-- Modal Ver Detalles -->
    <?php foreach ($casilleros as $casillero): ?>
        <div class="modal fade" id="view-casillero-modal-<?= $casillero['ID_Casillero'] ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detalles del Casillero</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($casillero['Casillero_Nombre']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label>Dirección</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($casillero['Direccion']) ?>" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Modal Editar -->
    <?php foreach ($casilleros as $casillero): ?>
        <div class="modal fade" id="edit-casillero-modal-<?= $casillero['ID_Casillero'] ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form method="POST" action="index.php?c=casillero&a=editar" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Casillero</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body row">
                    <input type="hidden" name="ID_Casillero" value="<?= $casillero['ID_Casillero'] ?>">
                    <div class="col-md-6">
                        <label>Nombre</label>
                        <input type="text" name="Casillero_Nombre" class="form-control"
                            value="<?= htmlspecialchars($casillero['Casillero_Nombre']) ?>" required  maxlength="20"
                            pattern="[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()]"
                            title="Solo letras, números y los caracteres (,.-()) son permitidos. Máximo 50 caracteres.">
                    </div>
                    <div class="col-md-6">
                        <label>Dirección</label>
                        <input type="text" name="Direccion" class="form-control"
                            value="<?= htmlspecialchars($casillero['Direccion']) ?>" required
                            maxlength="100"
                            title="La dirección es obligatoria y debe tener máximo 100 caracteres.">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                </div>
            </form>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="delete-casillero-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" action="index.php?c=casillero&a=eliminar" class="modal-content text-center p-4">
                <div class="modal-body">
                    <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                    <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Casillero?</h4>
                    <p class="mb-30 text-muted">Esta acción no se puede deshacer.</p>
                    <input type="hidden" name="ID_Casillero" id="delete_casillero_id">
                    <div class="row justify-content-center gap-2">
                        <div class="col-6 px-1">
                            <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">
                                <i class="fa fa-times"></i> No
                            </button>
                        </div>
                        <div class="col-6 px-1">
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fa fa-check"></i> Sí
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="footer-wrap pd-20 mb-20 card-box">
        RapiExpress © 2025 - Sistema de Gestión de Paquetes                
    </div>
</div>
</body>
</html>
