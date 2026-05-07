<?php
$pdo = new PDO("mysql:host=localhost;dbname=banco_sistema_atc;charset=utf8mb4", "root", "");


$nom = "Dei";
$email = "dei@gmail.com";
$password = "12345678";
$rol = "usuario";


$hash = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO b_usuario (usu_nom, usu_email, usu_pass, usu_rol) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nom, $email, $hash, $rol]);

echo "usuario creado";