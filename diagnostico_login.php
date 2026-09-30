<?php
require __DIR__ . '/mini_sistema/database/connect_postgres.php';
if (!isset($conexao)) exit(1);
$stmt = $conexao->query("SELECT column_name, data_type, character_maximum_length FROM information_schema.columns WHERE table_name = 'usuarios'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
$stmt = $conexao->query("SELECT COUNT(*) AS total, MIN(length(senha)) AS menor_senha, MAX(length(senha)) AS maior_senha FROM usuarios");
print_r($stmt->fetch(PDO::FETCH_ASSOC));
$stmt = $conexao->query("SELECT COUNT(*) AS grupos_duplicados FROM (SELECT email FROM usuarios GROUP BY email HAVING COUNT(*) > 1) duplicados");
print_r($stmt->fetch(PDO::FETCH_ASSOC));
$stmt = $conexao->query('SELECT id, email, senha FROM usuarios ORDER BY id');
$grupos = [];

