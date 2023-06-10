<?php

namespace Core;

abstract class Config
{
    protected function configAdm()
    {
        define('URL', 'http://localhost/projetos/');
        define('URLADM', 'http://localhost/projetos/adm/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        define('CONTROLLERERRO', 'Erro');
    }
}
