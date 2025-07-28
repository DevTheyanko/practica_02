<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>RapiExpress</title>
		<link rel="icon" href="assets\img\logo-rapi.ico" type="image/x-icon">



		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

			<?php include 'src\views\layout\barras.php'; ?>

		
		 
	</head>
	<body>
		 

		
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			
				
					<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4>Empleados</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="index.php?c=dashboard&a=index">RapiExpress</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Empleados
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
							
		
	
<div class="card-box mb-30">    
    <div class="pd-30">
    <h4 class="text-blue h4">Gestión de Usuarios</h4>
    <?php include 'src\views\layout\notificaciones.php'; ?>
    <div class="pull-right">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#usuarioModal">
            <i class="fa fa-user-plus"></i> Agregar Usuario
        </button>
    </div>
</div>

<div class="pb-30">
    <table class="data-table table stripe hover nowrap" id="usuariosTable">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Usuario</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Sucursal</th>
                <th>Cargo</th>
                <th class="datatable-nosort">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['Cedula_Identidad']) ?></td>
                <td><?= htmlspecialchars($usuario['Username']) ?></td>
                <td><?= htmlspecialchars($usuario['Nombres_Usuario'] . ' ' . $usuario['Apellidos_Usuario']) ?></td>
                <td><?= htmlspecialchars($usuario['Correo_Usuario']) ?></td>
                <td><?= htmlspecialchars($usuario['Telefono_Usuario']) ?></td>
                <td><?= htmlspecialchars($usuario['Sucursal_Nombre']) ?></td>
                <td><?= htmlspecialchars($usuario['Cargo_Nombre']) ?></td>
                <td>
                    <div class="dropdown">
                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="dw dw-more"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-usuario-modal-<?= $usuario['ID_Usuario'] ?>">
                                <i class="dw dw-eye"></i> Ver Detalles
                            </a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-usuario-modal-<?= $usuario['ID_Usuario'] ?>">
                                <i class="dw dw-edit2"></i> Editar
                            </a>
                            <?php if ($usuario['Username'] !== $_SESSION['usuario']): ?>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-usuario-modal" 
                               onclick="document.getElementById('delete_usuario_id').value = <?= $usuario['ID_Usuario'] ?>;">
                                <i class="dw dw-delete-3"></i> Eliminar
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

    
</div>
<!-- Modal para agregar usuario -->
<div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="usuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form method="POST" action="index.php?c=usuario&a=registrar" novalidate>
        <div class="modal-header">
          <h5 class="modal-title" id="usuarioModalLabel">Registrar Nuevo Usuario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <!-- Cédula de Identidad -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="Cedula_Identidad">Cédula de Identidad</label>
                <input type="text" pattern="\d{6,23}" title="Debe contener entre 6 y 15 dígitos" class="form-control" id="Cedula_Identidad" name="Cedula_Identidad" required maxlength="23">
              </div>
            </div>

            <!-- Username -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="Username">Nombre de Usuario</label>
                <input type="text" pattern="^[a-zA-Z0-9]{4,}$" title="Mínimo 4 caracteres, solo letras y números" class="form-control" id="Username" name="Username" required maxlength="50">
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Nombres -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="Nombres_Usuario">Nombres</label>
                <input type="text" pattern="^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]+$" title="Solo letras" class="form-control" id="Nombres_Usuario" name="Nombres_Usuario" required maxlength="20">
              </div>
            </div>

            <!-- Apellidos -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="Apellidos_Usuario">Apellidos</label>
                <input type="text" pattern="^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]+$" title="Solo letras" class="form-control" id="Apellidos_Usuario" name="Apellidos_Usuario" required maxlength="20"> 
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Correo Electrónico -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="Correo_Usuario">Correo Electrónico</label>
                <input type="email" class="form-control" id="Correo_Usuario" name="Correo_Usuario" required maxlength="100" >
              </div>
            </div>

            <!-- Teléfono -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="Telefono_Usuario">Teléfono</label>
                <input type="tel" class="form-control" id="Telefono_Usuario" name="Telefono_Usuario" maxlength="20" pattern="\d{7,15}" title="Debe contener entre 7 y 15 dígitos numéricos">
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Dirección -->
            <div class="col-md-12">
              <div class="form-group">
                <label for="Direccion_Usuario">Dirección</label>
                <input type="text" class="form-control" id="Direccion_Usuario" name="Direccion_Usuario">
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Sucursal -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="Sucursal_Nombre">Sucursal</label>
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

            <!-- Cargo -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="ID_Cargo">Cargo</label>
                <select class="form-control" id="ID_Cargo" name="ID_Cargo" required>
                  <option value="">Seleccione un cargo</option>
                  <?php foreach ($cargos as $cargo): ?>
                    <option value="<?= $cargo['ID_Cargo'] ?>">
                      <?= htmlspecialchars($cargo['Cargo_Nombre']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Contraseña -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="Password">Contraseña</label>
                <div class="input-group custom mb-4">
                  <input name="Password" type="password" class="form-control form-control-lg" id="Password" placeholder="Contraseña"
                         pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$"
                         title="Mínimo 6 caracteres, al menos una letra y un número" required>
                  <div class="input-group-append custom toggle-password" style="cursor: pointer;">
                    <span class="input-group-text"><i class="fa fa-eye"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Registrar Usuario</button>
        </div>
      </form>
    </div>
  </div>
</div>




<!-- Modal para ver a detalle usuario -->

<?php foreach ($usuarios as $usuario): ?>
<div class="modal fade bs-example-modal-lg" id="view-usuario-modal-<?= $usuario['ID_Usuario'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalles del Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Documento</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['Cedula_Identidad']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['Username']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombres</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['Nombres_Usuario']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['Apellidos_Usuario']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($usuario['Correo_Usuario']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['Telefono_Usuario']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sucursal</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['Sucursal_Nombre'] ?? $usuario['ID_Sucursal']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cargo</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['Cargo_Nombre'] ?? $usuario['ID_Cargo']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Registro</label>
                            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($usuario['Fecha_Registro'])) ?>" readonly>
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

<!-- Modal para editar usuario -->
<?php foreach ($usuarios as $usuario): ?>
<div class="modal fade" id="edit-usuario-modal-<?= $usuario['ID_Usuario'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form method="POST" action="index.php?c=usuario&a=editar">
                <div class="modal-body">
                    <input type="hidden" name="ID_Usuario" value="<?= $usuario['ID_Usuario'] ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="Cedula_Identidad_<?= $usuario['ID_Usuario'] ?>">Cédula de Identidad</label>
                            <input type="text" class="form-control" name="Cedula_Identidad" id="Cedula_Identidad_<?= $usuario['ID_Usuario'] ?>"
                                value="<?= htmlspecialchars($usuario['Cedula_Identidad']) ?>"
                                pattern="^\d{6,23}$"
                                title="La cédula debe contener entre 6 y 23 dígitos."
                                required maxlength="23">
                        </div>
                        <div class="col-md-6">
                            <label for="Username_<?= $usuario['ID_Usuario'] ?>">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="Username" id="Username_<?= $usuario['ID_Usuario'] ?>"
                                value="<?= htmlspecialchars($usuario['Username']) ?>"
                                pattern="^[a-zA-Z0-9_]{3,20}$"
                                title="El nombre de usuario debe tener entre 3 y 20 caracteres y solo puede contener letras, números y guiones bajos."
                                required maxlength="20">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="Nombres_Usuario_<?= $usuario['ID_Usuario'] ?>">Nombres</label>
                            <input type="text" class="form-control" name="Nombres_Usuario" id="Nombres_Usuario_<?= $usuario['ID_Usuario'] ?>"
                                value="<?= htmlspecialchars($usuario['Nombres_Usuario']) ?>"
                                pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$"
                                title="Los nombres solo pueden contener letras y espacios."
                                required maxlength="50">
                        </div>
                        <div class="col-md-6">
                            <label for="Apellidos_Usuario_<?= $usuario['ID_Usuario'] ?>">Apellidos</label>
                            <input type="text" class="form-control" name="Apellidos_Usuario" id="Apellidos_Usuario_<?= $usuario['ID_Usuario'] ?>"
                                value="<?= htmlspecialchars($usuario['Apellidos_Usuario']) ?>"
                                pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$"
                                title="Los apellidos solo pueden contener letras y espacios."
                                required maxlength="20">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="Correo_Usuario_<?= $usuario['ID_Usuario'] ?>">Correo Electrónico</label>
                            <input type="email" class="form-control" name="Correo_Usuario" id="Correo_Usuario_<?= $usuario['ID_Usuario'] ?>"
                                value="<?= htmlspecialchars($usuario['Correo_Usuario']) ?>"
                                title="Debe ingresar un correo electrónico válido."
                                required maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label for="Telefono_Usuario_<?= $usuario['ID_Usuario'] ?>">Teléfono</label>
                            <input type="tel" class="form-control" name="Telefono_Usuario" id="Telefono_Usuario_<?= $usuario['ID_Usuario'] ?>"
                                value="<?= htmlspecialchars($usuario['Telefono_Usuario']) ?>"
                                pattern="^\d{7,15}$"
                                title="El número de teléfono debe contener solo dígitos (7 a 15 caracteres)."
                                required maxlength="20">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="ID_Sucursal_<?= $usuario['ID_Usuario'] ?>">Sucursal</label>
                            <select class="form-control" name="ID_Sucursal" id="ID_Sucursal_<?= $usuario['ID_Usuario'] ?>" required>
                                <option value="">Seleccione una sucursal</option>
                                <?php foreach ($sucursales as $sucursal): ?>
                                    <option value="<?= $sucursal['ID_Sucursal'] ?>"
                                        <?= $sucursal['Sucursal_Nombre'] == $usuario['Sucursal_Nombre'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sucursal['Sucursal_Nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="ID_Cargo_<?= $usuario['ID_Usuario'] ?>">Cargo</label>
                            <select class="form-control" name="ID_Cargo" id="ID_Cargo_<?= $usuario['ID_Usuario'] ?>" required>
                                <option value="">Seleccione un cargo</option>
                                <?php foreach ($cargos as $cargo): ?>
                                    <option value="<?= $cargo['ID_Cargo'] ?>"
                                        <?= $cargo['Cargo_Nombre'] == $usuario['Cargo_Nombre'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cargo['Cargo_Nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="Direccion_Usuario_<?= $usuario['ID_Usuario'] ?>">Dirección</label>
                            <input type="text" class="form-control" name="Direccion_Usuario" id="Direccion_Usuario_<?= $usuario['ID_Usuario'] ?>"
                                value="<?= htmlspecialchars($usuario['Direccion_Usuario']) ?>"
                                 maxlength="255" pattern="^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,\-()_]{1,100}$"
                                title="Solo letras, números y caracteres (,.-()_) son permitidos. Máximo 100 caracteres.">
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



<!-- Modal para Eliminar Usuario -->
<div class="modal fade" id="delete-usuario-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                <h4 class="mb-20 font-weight-bold text-danger">¿Eliminar Usuario?</h4>
                <p class="mb-30 text-muted">Esta acción no se puede deshacer. <br>¿Está seguro que desea eliminar este usuario?</p>

                <form method="POST" action="index.php?c=usuario&a=eliminar">
                    <input type="hidden" name="ID_Usuario" id="delete_usuario_id">
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
