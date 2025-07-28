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
                    <h4>Categorías</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php?c=dashboard&a=index">RapiExpress</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Categorías
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

  <div class="card-box mb-30">
    <div class="pd-30">
        <h4 class="text-blue h4">Lista de Categorías</h4>
        <?php include 'src/views/layout/notificaciones.php'; ?>
        <div class="pull-right">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#categoriaModal">
                <i class="fa fa-plus"></i> Agregar Categoría
            </button>
        </div>
    </div>

    <div class="pb-30">
        <table class="data-table table stripe hover nowrap" id="categoriasTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dimensiones (cm)</th>
                    <th>Peso (kg)</th>
                    <th>Piezas</th>
                    <th>Precio ($)</th>
                    <th class="datatable-nosort">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?= $categoria['ID_Categoria'] ?></td>
                        <td><?= htmlspecialchars($categoria['Categoria_Nombre']) ?></td>
                        <td><?= $categoria['Categoria_Altura'] . ' x ' . $categoria['Categoria_Largo'] . ' x ' . $categoria['Categoria_Ancho'] ?></td>
                        <td><?= $categoria['Categoria_Peso'] ?></td>
                        <td><?= $categoria['Categoria_Piezas'] ?></td>
                        <td>$<?= number_format($categoria['Categoria_Precio'], 2) ?></td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-categoria-modal-<?= $categoria['ID_Categoria'] ?>">
                                        <i class="dw dw-eye"></i> Ver Detalles
                                    </a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-categoria-modal-<?= $categoria['ID_Categoria'] ?>">
                                        <i class="dw dw-edit2"></i> Editar
                                    </a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-categoria-modal"
                                       onclick="document.getElementById('delete_categoria_id').value = <?= $categoria['ID_Categoria'] ?>">
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


<!-- Modal Registrar Categoría -->
<div class="modal fade" id="categoriaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="index.php?c=categoria&a=registrar" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nueva Categoría</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre"
                           required maxlength="20"
                           pattern="^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()]+$"
                           title="Solo letras, números y (,.-()) permitidos. Máx 50 caracteres.">
                </div>
                <div class="col-md-6">
                    <label>Precio ($)</label>
                    <input type="number" class="form-control" name="precio"
                           required min="0" step="0.01">
                </div>
                <div class="col-md-3">
                    <label>Altura (cm)</label>
                    <input type="number" class="form-control" name="altura"
                           required min="0" step="0.01">
                </div>
                <div class="col-md-3">
                    <label>Largo (cm)</label>
                    <input type="number" class="form-control" name="largo"
                           required min="0" step="0.01">
                </div>
                <div class="col-md-3">
                    <label>Ancho (cm)</label>
                    <input type="number" class="form-control" name="ancho"
                           required min="0" step="0.01">
                </div>
                <div class="col-md-3">
                    <label>Peso (kg)</label>
                    <input type="number" class="form-control" name="peso"
                           required min="0" step="0.01">
                </div>
                <div class="col-md-3">
                    <label>Piezas</label>
                    <input type="number" class="form-control" name="piezas"
                           required min="1" step="1">
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
<?php foreach ($categorias as $categoria): ?>
    <div class="modal fade" id="view-categoria-modal-<?= $categoria['ID_Categoria'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalles de Categoría</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6"><label>Nombre</label><input class="form-control" value="<?= htmlspecialchars($categoria['Categoria_Nombre']) ?>" readonly></div>
                    <div class="col-md-6"><label>Precio</label><input class="form-control" value="$<?= number_format($categoria['Categoria_Precio'], 2) ?>" readonly></div>
                    <div class="col-md-3"><label>Altura</label><input class="form-control" value="<?= $categoria['Categoria_Altura'] ?>" readonly></div>
                    <div class="col-md-3"><label>Largo</label><input class="form-control" value="<?= $categoria['Categoria_Largo'] ?>" readonly></div>
                    <div class="col-md-3"><label>Ancho</label><input class="form-control" value="<?= $categoria['Categoria_Ancho'] ?>" readonly></div>
                    <div class="col-md-3"><label>Peso</label><input class="form-control" value="<?= $categoria['Categoria_Peso'] ?>" readonly></div>
                    <div class="col-md-3"><label>Piezas</label><input class="form-control" value="<?= $categoria['Categoria_Piezas'] ?>" readonly></div>
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">Cerrar</button></div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<!-- Modal Editar -->
<?php foreach ($categorias as $categoria): ?>
    <div class="modal fade" id="edit-categoria-modal-<?= $categoria['ID_Categoria'] ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form method="POST" action="index.php?c=categoria&a=editar" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Categoría</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body row">
                    <input type="hidden" name="ID_Categoria" value="<?= $categoria['ID_Categoria'] ?>">

                    <div class="col-md-6">
                        <label>Nombre</label>
                        <input class="form-control" name="nombre"
                               value="<?= htmlspecialchars($categoria['Categoria_Nombre']) ?>"
                               required maxlength="20"
                               pattern="^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()]+$"
                               title="Solo letras, números y (,.-()) permitidos. Máx 50 caracteres.">
                    </div>

                    <div class="col-md-6">
                        <label>Precio ($)</label>
                        <input class="form-control" name="precio"
                               type="number" step="0.01" min="0"
                               value="<?= $categoria['Categoria_Precio'] ?>" required>
                    </div>

                    <div class="col-md-3">
                        <label>Altura</label>
                        <input class="form-control" name="altura"
                               type="number" step="0.01" min="0"
                               value="<?= $categoria['Categoria_Altura'] ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Largo</label>
                        <input class="form-control" name="largo"
                               type="number" step="0.01" min="0"
                               value="<?= $categoria['Categoria_Largo'] ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Ancho</label>
                        <input class="form-control" name="ancho"
                               type="number" step="0.01" min="0"
                               value="<?= $categoria['Categoria_Ancho'] ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Peso</label>
                        <input class="form-control" name="peso"
                               type="number" step="0.01" min="0"
                               value="<?= $categoria['Categoria_Peso'] ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label>Piezas</label>
                        <input class="form-control" name="piezas"
                               type="number" min="1" step="1"
                               value="<?= $categoria['Categoria_Piezas'] ?>" required>
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


<!-- Modal para Eliminar Categoría (Diseño adaptado de Tienda) -->
<div class="modal fade" id="delete-categoria-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Categoría?</h4>
                <p class="mb-30 text-muted">Esta acción no se puede deshacer.</p>
                
                <form method="POST" action="index.php?c=categoria&a=eliminar">
                    <input type="hidden" name="id" id="delete_categoria_id">
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



        <div class="footer-wrap pd-20 mb-20 card-box">
            RapiExpress © 2025 - Sistema de Gestión de Paquetes                
        </div>
    </div>
</div>
</body>
</html>