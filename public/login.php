<?php
// public/login.php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Iniciar sesión - Mantenimiento equipos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
              <img src="../assets/img/logo.png" alt="Logo" style="height:56px;" class="me-3">
              <div>
                <h4 class="mb-0">Control de Mantenimientos</h4>
                <small class="text-muted">Inicia sesión o regístrate</small>
              </div>
            </div>

            <!-- LOGIN FORM -->
            <form id="loginForm" action="../includes/auth.php" method="post" novalidate>
              <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required placeholder="tu@correo.com">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Contraseña">
              </div>
              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Entrar</button>
              </div>
            </form>

            <!-- ENLACE A REGISTRO -->
            <p class="small text-muted mb-0">
              ¿No tienes cuenta?
              <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Regístrate aquí</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL REGISTRO -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="../includes/register.php" method="post" novalidate>
          <div class="modal-header">
            <h5 class="modal-title" id="registerModalLabel">Crear cuenta de Técnico</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body row g-3">
            <div class="col-md-6">
              <label class="form-label">ID Técnico</label>
              <input type="number" name="id_tecnico" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Apellido</label>
              <input type="text" name="apellido" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Especialidad</label>
              <input type="text" name="especialidad" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Teléfono</label>
              <input type="text" name="telefono" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Correo</label>
              <input type="email" name="correo" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Contraseña</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Rol</label>
              <select name="rol" class="form-select">
                <option value="tecnico">Técnico</option>
                <option value="admin">Administrador</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
