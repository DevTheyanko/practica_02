<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>RapiExpress</title>
    <link rel="icon" href="assets/img/logo-rapi.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>
<body>
    <?php include 'src/views/layout/barras.php'; ?>

    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Prealertas</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php?c=dashboard&a=index">RapiExpress</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Prealertas
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            <div class="pd-30">
                <h4 class="text-blue h4">Lista de Prealertas</h4>
                <?php include 'src/views/layout/notificaciones.php'; ?>
                <div class="pull-right">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#prealertaModal">
                        <i class="fa fa-plus"></i> Agregar Prealerta
                    </button>
                </div>
            </div>
            <div class="pb-30">
                <table class="data-table table stripe hover nowrap" id="prealertasTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Tienda</th>
                            <th>Casillero</th>
                            <th>Tracking</th>
                            <th>Piezas</th>
                            <th>Peso</th>
                            <th>Descripción</th>
                            <th class="datatable-nosort">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prealertas as $pre): ?>
                        <tr>
                            <td><?= $pre['ID_Prealerta'] ?></td>
                            <td><?= $pre['Nombres_Cliente'] . ' ' . $pre['Apellidos_Cliente'] ?></td>
                            <td><?= $pre['Nombre_Tienda'] ?></td>
                            <td><?= $pre['Casillero_Nombre'] ?></td>
                            <td><?= $pre['Tienda_Traking'] ?></td>
                            <td><?= $pre['Prealerta_Piezas'] ?></td>
                            <td><?= $pre['Prealerta_Peso'] ?> kg</td>
                            <td><?= $pre['Prealerta_Descripcion'] ?></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-prealerta-modal-<?= $pre['ID_Prealerta'] ?>">
                                            <i class="dw dw-edit2"></i> Editar
                                        </a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-prealerta-modal" onclick="document.getElementById('delete_prealerta_id').value = <?= $pre['ID_Prealerta'] ?>">
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

        <!-- Modal Agregar Prealerta -->
        <div class="modal fade" id="prealertaModal" tabindex="-1" role="dialog" aria-labelledby="prealertaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="POST" action="index.php?c=prealerta&a=registrar">
                        <div class="modal-header">
                            <h5 class="modal-title">Registrar Prealerta</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Cliente</label>
                                    <select name="ID_Cliente" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <?php foreach ($clientes as $c): ?>
                                            <option value="<?= $c['ID_Cliente'] ?>"><?= $c['Nombres_Cliente'] . ' ' . $c['Apellidos_Cliente'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Tienda</label>
                                    <select name="ID_Tienda" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <?php foreach ($tiendas as $t): ?>
                                            <option value="<?= $t['ID_Tienda'] ?>"><?= $t['Nombre_Tienda'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Casillero</label>
                                    <select name="ID_Casillero" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <?php foreach ($casilleros as $ca): ?>
                                            <option value="<?= $ca['ID_Casillero'] ?>"><?= $ca['Casillero_Nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label>Tracking</label>
                                    <input type="text" name="Tienda_Traking" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Piezas</label>
                                    <input type="number" name="Prealerta_Piezas" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Peso (kg)</label>
                                    <input type="number" step="0.01" name="Prealerta_Peso" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label>Descripción</label>
                                    <textarea name="Prealerta_Descripcion" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Eliminar Prealerta -->
        <div class="modal fade" id="delete-prealerta-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center p-4">
                    <div class="modal-body">
                        <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                        <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Prealerta?</h4>
                        <p class="mb-30 text-muted">Esta acción no se puede deshacer.<br>¿Desea continuar?</p>
                        <form method="POST" action="index.php?c=prealerta&a=eliminar">
                            <input type="hidden" name="id" id="delete_prealerta_id">
                            <div class="row justify-content-center gap-2" style="max-width: 200px; margin: 0 auto;">
                                <div class="col-6 px-1">
                                    <button type="button" class="btn btn-secondary btn-lg btn-block" data-dismiss="modal">
                                        <i class="fa fa-times"></i> No
                                    </button>
                                </div>
                                <div class="col-6 px-1">
                                    <button type="submit" class="btn btn-danger btn-lg btn-block">
                                        <i class="fa fa-check"></i> Sí
                                    </button>
                                </div>
                            </div>
                        </form>
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
