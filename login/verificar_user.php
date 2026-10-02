<?php
if (session_status() === PHP_SESSION_NONE) session_start(); // Garante que a sessão possa ser verificada.
if (!isset($_SESSION['id'])) { header('Location: /mini_sistema/login/login.php'); exit(); } // Redireciona visitantes não autenticados.