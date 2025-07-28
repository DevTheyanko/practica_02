<!DOCTYPE html>
<html>
	<head>		
		<meta charset="utf-8" />
		<title>RapiExpress </title>
		<link rel="icon" href="assets\img\logo-rapi.ico" type="image/x-icon">		
		<meta name="viewport"content="width=device-width, initial-scale=1, maximum-scale=1"/>	
        
        	
          
	
	</head>
	<body >	
         
      	

		<?php include 'src\views\layout\barras.php'; ?>
		
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="xs-pd-20-10 pd-ltr-20">
				<div class="title pb-20">
					<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4>Sucursales</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="index.php?c=dashboard&a=index">RapiExpress</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Sucursales
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<h2 class="h3 mb-0">Sucursales</h2>
				</div>
				
		


    <div class="card-box mb-30">
    <div class="pd-30">
        <h4 class="text-blue h4">Lista de Sucursales</h4>
        <?php include 'src\views\layout\notificaciones.php'; ?>

        <div class="pull-right">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sucursalModal">
                <i class="fa fa-building"></i> Agregar Sucursal
            </button>
        </div>
    </div>
    <div class="pb-30">
        <table class="data-table table stripe hover nowrap" id="sucursalesTable">
            <thead>
                <tr>
                    
                    <th>RIF</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th class="datatable-nosort">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sucursales as $sucursal): ?>
                <tr>
                    
                    <td><?= htmlspecialchars($sucursal['RIF_Sucursal']) ?></td>
                    <td><?= htmlspecialchars($sucursal['Sucursal_Nombre']) ?></td>
                    <td><?= htmlspecialchars($sucursal['Sucursal_Direccion']) ?></td>
                    <td><?= htmlspecialchars($sucursal['Sucursal_Telefono']) ?></td>
                    <td><?= htmlspecialchars($sucursal['Sucursal_Correo']) ?></td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" data-toggle="dropdown">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-sucursal-modal-<?= $sucursal['ID_Sucursal'] ?>">
                                    <i class="dw dw-eye"></i> Ver Detalles
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-sucursal-modal-<?= $sucursal['ID_Sucursal'] ?>">
                                    <i class="dw dw-edit2"></i> Editar
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-sucursal-modal" 
                                   onclick="setDeleteId(<?= $sucursal['ID_Sucursal'] ?>)">
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

<!-- Modal Agregar Sucursal -->
<div class="modal fade" id="sucursalModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="index.php?c=sucursal&a=registrar">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Nueva Sucursal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- RIF -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">RIF</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="RIF_Sucursal"
                                   pattern="^[JGVEP]-\d{8}-\d$"
                                   title="Formato válido: J-12345678-9"
                                   maxlength="23" required>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="Sucursal_Nombre"
                                   pattern="^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()_]+$"
                                   title="Solo letras, números y caracteres válidos (,.-())"
                                   maxlength="20" required>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dirección</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="Sucursal_Direccion"
                                   pattern="^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()_]+$"
                                   title="Solo letras, números y caracteres válidos (,.-())"
                                   maxlength="100" required>
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Teléfono</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="Sucursal_Telefono"
                                   pattern="^\d{7,20}$"
                                   title="Solo números, entre 7 y 20 dígitos"
                                   maxlength="20" required>
                        </div>
                    </div>

                    <!-- Correo -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Correo</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="Sucursal_Correo"
                                   maxlength="100" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Sucursal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($sucursales as $suc): ?>
<!-- Modal Ver Detalles -->
<div class="modal fade" id="view-sucursal-modal-<?= $suc['ID_Sucursal'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalles de la Sucursal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                    $campos = [
                        'RIF' => $suc['RIF_Sucursal'],
                        'ID' => $suc['ID_Sucursal'],
                        'Nombre' => $suc['Sucursal_Nombre'],
                        'Dirección' => $suc['Sucursal_Direccion'],
                        'Teléfono' => $suc['Sucursal_Telefono'],
                        'Correo' => $suc['Sucursal_Correo']
                    ];
                    foreach ($campos as $label => $valor):
                ?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"><?= $label ?></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="<?= htmlspecialchars($valor) ?>" readonly>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="edit-sucursal-modal-<?= $suc['ID_Sucursal'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="index.php?c=sucursal&a=editar">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Sucursal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="ID_Sucursal" value="<?= $suc['ID_Sucursal'] ?>">

                    <!-- Nombre -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="Sucursal_Nombre"
                                   value="<?= htmlspecialchars($suc['Sucursal_Nombre']) ?>"
                                   pattern="^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()_]+$"
                                   title="Solo letras, números y caracteres válidos (,.-())"
                                   maxlength="20" required>
                        </div>
                    </div>

                    <!-- RIF -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">RIF</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="RIF_Sucursal"
                                   value="<?= htmlspecialchars($suc['RIF_Sucursal']) ?>"
                                   pattern="^[JGVEP]-\d{8}-\d$"
                                   title="Formato válido: J-12345678-9"
                                   maxlength="23" required>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="form-group row"
                        <label class="col-sm-3 col-form-label">Dirección</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="Sucursal_Direccion"
                                   value="<?= htmlspecialchars($suc['Sucursal_Direccion']) ?>"
                                   pattern="^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()_]+$"
                                   title="Solo letras, números y caracteres permitidos (,.-())"
                                   maxlength="100" required>
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Teléfono</label>
                        <div class="col-sm-9">
                            <input type="tel" class="form-control" name="Sucursal_Telefono"
                                   value="<?= htmlspecialchars($suc['Sucursal_Telefono']) ?>"
                                   pattern="^\d{7,20}$"
                                   title="Solo números, entre 7 y 20 dígitos"
                                   maxlength="20" required>
                        </div>
                    </div>

                    <!-- Correo -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Correo</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="Sucursal_Correo"
                                   value="<?= htmlspecialchars($suc['Sucursal_Correo']) ?>"
                                   maxlength="100" required>
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


<!-- Modal para Eliminar Sucursal (Diseño adaptado del de Tienda) -->
<div class="modal fade" id="delete-sucursal-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Sucursal?</h4>
                <p class="mb-30 text-muted">Esta acción no se puede deshacer.<br>¿Está seguro que desea eliminar esta sucursal?</p>

                <form method="POST" action="index.php?c=sucursal&a=eliminar">
                    <input type="hidden" name="ID_Sucursal" id="delete_sucursal_id">
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
    document.getElementById('delete_sucursal_id').value = id;
}
</script>



<div class="footer-wrap pd-20 mb-20 card-box">
    RapiExpress © 2025 - Sistema de Gestión de Paquetes                
</div>
			</div>
		</div>
        

       

	</body>
</html>