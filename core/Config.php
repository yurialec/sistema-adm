<?php

namespace Core;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Variáveis Globais
 */
abstract class Config
{
    protected function configAdm()
    {
        define('URL', 'http://localhost/projetos/');
        define('URLADM', 'http://localhost/projetos/adm/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        define('CONTROLLERERRO', 'Login');

        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '');
        define('DBNAME', 'adm');
        define('PORT', '3306');

        define('EMAILADM', 'yuri.alec@hotmail.com');
    }
}
