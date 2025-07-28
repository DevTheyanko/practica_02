<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>RapiExpress - Cargos</title>
    <link rel="icon" href="assets/img/logo-rapi.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>
<body>
    <?php include 'src/views/layout/barras.php'; ?>
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="title pb-20">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4>Cargos</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php?c=dashboard&a=index">RapiExpress</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cargos</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <h2 class="h3 mb-0">Cargos</h2>
            </div>

            <div class="card-box mb-30">
                <div class="pd-30">
                    <h4 class="text-blue h4">Lista de Cargos</h4>
                    <?php include 'src/views/layout/notificaciones.php'; ?>
                    <div class="pull-right">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cargoModal">
                            <i class="fa fa-briefcase"></i> Agregar Cargo
                        </button>
                    </div>
                </div>
                <div class="pb-30">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Cargo</th>
                                <th class="datatable-nosort">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cargos as $cargo): ?>
                            <tr>
                                <td><?= htmlspecialchars($cargo['ID_Cargo']) ?></td>
                                <td><?= htmlspecialchars($cargo['Cargo_Nombre']) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-cargo-modal-<?= $cargo['ID_Cargo'] ?>">
                                                <i class="dw dw-edit2"></i> Editar
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-cargo-modal" onclick="setDeleteId(<?= $cargo['ID_Cargo'] ?>)">
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

            <!-- Modal Agregar Cargo -->
            <div class="modal fade" id="cargoModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form method="POST" action="index.php?c=cargo&a=registrar">
                            <div class="modal-header">
                                <h5 class="modal-title">Registrar Nuevo Cargo</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nombre del Cargo</label>
                                    <input 
                                        type="text"  name="Cargo_Nombre" class="form-control" required  maxlength="20" pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$" title="Solo se permiten letras y espacios. Máximo 50 caracteres.">
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

                <!-- Modal Editar Cargo -->
                <?php foreach ($cargos as $cargo): ?>
                <div class="modal fade" id="edit-cargo-modal-<?= $cargo['ID_Cargo'] ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form method="POST" action="index.php?c=cargo&a=editar">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Cargo</h5>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="ID_Cargo" value="<?= $cargo['ID_Cargo'] ?>">
                                    <div class="form-group">
                                        <label>Nombre del Cargo</label>
                                        <input 
                                            type="text"  name="Cargo_Nombre"   class="form-control"  value="<?= htmlspecialchars($cargo['Cargo_Nombre']) ?>"  required  maxlength="20" pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$"  title="Solo se permiten letras y espacios. Máximo 20 caracteres.">
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


          

        <!-- Modal para Eliminar Cargo -->
        <div class="modal fade" id="delete-cargo-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">
                    <div class="modal-body">
                        <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                        <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Cargo?</h4>
                        <p class="mb-30 text-muted">Esta acción no se puede deshacer. <br>¿Está seguro que desea eliminar este Cargo?</p>

                        <form method="POST" action="index.php?c=cargo&a=eliminar">
                            <input type="hidden" name="ID_Cargo" id="delete_cargo_id">
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
            <script>
                function setDeleteId(id) {
                    document.getElementById('delete_cargo_id').value = id;
                }
            </script>

            <div class="footer-wrap pd-20 mb-20 card-box">
                RapiExpress © 2025 - Sistema de Gestión de Paquetes
            </div>
        </div>
    </div>
</body>
</html>