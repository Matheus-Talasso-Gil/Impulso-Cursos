<?php
if (session_status() === PHP_SESSION_NONE) session_start(); // Inicia a sessão somente quando ainda não existe uma ativa.