<?php
require_once "config.php";

function getAllEquipos() {
    global $pdo;
    $stmt = $pdo->query("SELECT e.id_equipo, e.id_usuario, e.codigo_interno, e.marca, e.modelo, e.fecha_ingreso, e.estado, e.observaciones, u.nombre, u.apellido 
                         FROM equipos e 
                         JOIN usuarios u ON e.id_usuario = u.id_usuario");
    return $stmt->fetchAll();
}

function getEquipoById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM equipos WHERE id_equipo = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function addEquipo($data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO equipos (id_usuario, codigo_interno, marca, modelo, fecha_ingreso, estado, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
        $data['id_usuario'],
        $data['codigo_interno'],
        $data['marca'],
        $data['modelo'],
        $data['fecha_ingreso'],
        $data['estado'],
        $data['observaciones']
    ]);
}

function updateEquipo($id, $data) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE equipos SET id_usuario = ?, codigo_interno = ?, marca = ?, modelo = ?, fecha_ingreso = ?, estado = ?, observaciones = ? WHERE id_equipo = ?");
    return $stmt->execute([
        $data['id_usuario'],
        $data['codigo_interno'],
        $data['marca'],
        $data['modelo'],
        $data['fecha_ingreso'],
        $data['estado'],
        $data['observaciones'],
        $id
    ]);
}

function deleteEquipo($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM equipos WHERE id_equipo = ?");
    return $stmt->execute([$id]);
}
