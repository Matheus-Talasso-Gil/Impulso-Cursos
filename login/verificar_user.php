<?php
if (session_status() === PHP_SESSION_NONE) session_start(); // garante que a sessão possa ser verificada
if (!isset($_SESSION['id'])) { header('Location: /mini_sistema/login/login.php'); exit(); } // redireciona visitantes não autenticados