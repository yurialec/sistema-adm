<?php

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

echo "VIEW - Dashboard<br>";
echo "Bem vindo " . "<strong>" . $_SESSION['user_name'] . "</strong>" . "<br>";
