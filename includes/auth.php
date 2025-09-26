<?php
// includes/auth.php
session_start();
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/login.php');
    exit;
}

$correo = filter_var($_POST['correo'] ?? '', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';

if (!$correo || !$password) {
    $_SESSION['error'] = 'Correo o contraseña inválidos.';
    header('Location: ../public/login.php');
    exit;
}

try {
    // Incluimos también especialidad y telefono
    $stmt = $pdo->prepare("SELECT id_tecnico, nombre, apellido, correo, password, rol, especialidad, telefono 
                           FROM tecnicos 
                           WHERE correo = :correo 
                           LIMIT 1");
    $stmt->execute([':correo' => $correo]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error'] = 'Credenciales incorrectas.';
        header('Location: ../public/login.php');
        exit;
    }

    if (!isset($user['password']) || empty($user['password'])) {
        $_SESSION['error'] = 'Cuenta sin contraseña. Contacte al administrador.';
        header('Location: ../public/login.php');
        exit;
    }

    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Credenciales incorrectas.';
        header('Location: ../public/login.php');
        exit;
    }

    // login OK: generar sesión segura
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id_tecnico'],
        'nombre' => $user['nombre'],
        'apellido' => $user['apellido'],
        'correo' => $user['correo'],
        'rol' => $user['rol'],
        'especialidad' => $user['especialidad'],
        'telefono' => $user['telefono']
    ];

    // Redirigir según rol (el admin verá la vista completa)
    header('Location: ../public/dashboard.php');
    exit;

} catch (Exception $e) {
    // En producción, no mostrar errores detallados
    error_log($e->getMessage());
    $_SESSION['error'] = 'Error en el servidor. Intenta más tarde.';
    header('Location: ../public/login.php');
    exit;
}
