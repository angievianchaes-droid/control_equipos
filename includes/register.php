<?php
// includes/register.php
session_start();
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/login.php');
    exit;
}

$id = $_POST['id_tecnico'] ?? null;
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$especialidad = trim($_POST['especialidad'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo = filter_var($_POST['correo'] ?? '', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';
$rol = $_POST['rol'] ?? 'tecnico';

if (!$id || !$nombre || !$apellido || !$correo || !$password) {
    $_SESSION['error'] = 'Completa todos los campos obligatorios.';
    header('Location: ../public/login.php');
    exit;
}

try {
    // verificar que el correo no exista
    $stmt = $pdo->prepare("SELECT id_tecnico FROM tecnicos WHERE correo = :correo LIMIT 1");
    $stmt->execute([':correo' => $correo]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = 'El correo ya está registrado.';
        header('Location: ../public/login.php');
        exit;
    }

    // insertar nuevo usuario con password hasheado
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO tecnicos 
        (id_tecnico, nombre, apellido, especialidad, telefono, correo, password, rol)
        VALUES (:id, :nombre, :apellido, :especialidad, :telefono, :correo, :password, :rol)");

    $stmt->execute([
        ':id' => $id,
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':especialidad' => $especialidad,
        ':telefono' => $telefono,
        ':correo' => $correo,
        ':password' => $hash,
        ':rol' => $rol
    ]);

    $_SESSION['success'] = 'Cuenta creada correctamente. Ya puedes iniciar sesión.';
    header('Location: ../public/login.php');
    exit;

} catch (Exception $e) {
    error_log($e->getMessage());
    $_SESSION['error'] = 'Error en el servidor. Intenta más tarde.';
    header('Location: ../public/login.php');
    exit;
}
