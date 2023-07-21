<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use Core\ConfigView;

/**
 * Página Sair
 * @author Yuri <yuri.alec@hotmail.com>
 */
class Logout
{
    /**
     * Destruir as sessões do usuário logado
     *
     * @return void
     */
    public function index(): void
    {
        unset(
            $_SESSION['user_id'],
            $_SESSION['user_name'],
            $_SESSION['user_nick_name'],
            $_SESSION['user_email'],
            $_SESSION['user_image']
        );
        $_SESSION['msg'] = "<p style='color: #008000;'>Logout realizado com sucesso</p>";
        $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
    }
}
