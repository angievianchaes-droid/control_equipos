<?php
session_start();

require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/equipos_functions.php";
require_once __DIR__ . "/../includes/usuarios_functions.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard - <?= ucfirst($user['rol']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="bg-light">
<div class="d-flex">
    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-3 vh-100 sidebar">
        <h4 class="text-center mb-4">Panel <?= ucfirst($user['rol']) ?></h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="dashboard.php" class="nav-link text-white">
                    <i class="bi bi-house-door"></i> Home
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="dashboard.php?page=equipos" class="nav-link text-white">
                    <i class="bi bi-pc"></i> Equipos
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="dashboard.php?page=usuarios" class="nav-link text-white">
                    <i class="bi bi-person"></i> Usuarios
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="dashboard.php?page=mantenimientos" class="nav-link text-white">
                    <i class="bi bi-tools"></i> Mantenimientos
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="logout.php" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1 p-4">
        <?php if (!isset($_GET['page'])): ?>
            <!-- TARJETA INTERACTIVA -->
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front card shadow border-0 text-center p-4">
                                <img src="../assets/img/logo.png" alt="Perfil" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;">
                                <h4 class="fw-bold">Bienvenido, <?= htmlspecialchars($user['nombre']) ?> 👋</h4>
                                <p class="text-muted">
                                    Rol: <span class="badge bg-primary"><?= ucfirst($user['rol']) ?></span>
                                </p>
                                <small class="text-secondary">Haz clic en la tarjeta para ver tu información</small>
                            </div>
                            <div class="flip-card-back card shadow border-0 p-4 text-start">
                                <h5 class="fw-bold mb-3">📋 Hoja de Vida</h5>
                                <p><strong>Nombre:</strong> <?= htmlspecialchars($user['nombre'] . " " . $user['apellido']) ?></p>
                                <p><strong>Especialidad:</strong> <?= !empty($user['especialidad']) ? htmlspecialchars($user['especialidad']) : 'No registrada' ?></p>
                                <p><strong>Correo:</strong> <?= htmlspecialchars($user['correo']) ?></p>
                                <p><strong>Teléfono:</strong> <?= !empty($user['telefono']) ? htmlspecialchars($user['telefono']) : 'No registrado' ?></p>
                                <p class="text-muted"><small>Última actualización: <?= date("d/m/Y") ?></small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <?php
            $page = $_GET['page'];
            switch ($page) {
                case 'equipos':
                    if (isset($_GET['action'])) {
                        $action = $_GET['action'];
                        switch ($action) {
                            case 'add':
                                include __DIR__ . "/equipos/add.php";
                                break;
                            case 'edit':
                                include __DIR__ . "/equipos/edit.php";
                                break;
                            case 'delete':
                                include __DIR__ . "/equipos/delete.php";
                                break;
                            default:
                                include __DIR__ . "/equipos/index.php";
                        }
                    } else {
                        include __DIR__ . "/equipos/index.php";
                    }
                    break;

                case 'usuarios':
                    if (isset($_GET['action'])) {
                        $action = $_GET['action'];
                        switch ($action) {
                            case 'add':
                                include __DIR__ . "/usuarios/add.php";
                                break;
                            case 'edit':
                                include __DIR__ . "/usuarios/edit.php";
                                break;
                            case 'delete':
                                include __DIR__ . "/usuarios/delete.php";
                                break;
                            default:
                                include __DIR__ . "/usuarios/index.php";
                        }
                    } else {
                        include __DIR__ . "/usuarios/index.php";
                    }
                    break;

                case 'mantenimientos':
                    include __DIR__ . "/mantenimientos/index.php";
                    break;

                default:
                    echo "<div class='alert alert-warning'>Página no encontrada</div>";
            }
            ?>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
