<?php
require_once "config.php";

function getAllUsuarios() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM usuarios ORDER BY fecha_registro DESC");
    return $stmt->fetchAll();
}

function getUsuarioById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function addUsuario($data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO usuarios (id_usuario, nombre, apellido, correo, telefono) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$data['id_usuario'], $data['nombre'], $data['apellido'], $data['correo'], $data['telefono']]);
}

function updateUsuario($id, $data) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, telefono = ? WHERE id_usuario = ?");
    return $stmt->execute([$data['nombre'], $data['apellido'], $data['correo'], $data['telefono'], $id]);
}

function deleteUsuario($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    return $stmt->execute([$id]);
}
