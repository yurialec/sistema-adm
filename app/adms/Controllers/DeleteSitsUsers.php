<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsDeleteSitsUsers;

/**
 * Controller da página apagar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class DeleteSitsUsers
{
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Apaga usuário
     *
     * @return void
     */
    public function index(string|int|null $id): void
    {
        echo "Deleta";
        if ((!empty($id))) {
            $this->id = (int) $id;
            $deleteSitsUser = new AdmsDeleteSitsUsers();
            $deleteSitsUser->deleteSitsUser($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Situação não encontrada</p>";
        }

        $urlRedirect = URLADM . "list-sits-users/index";
        header("Location: $urlRedirect");
    }
}
