<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsDeleteConfEmail;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}


/**
 * Controller da página apagar Cores
 * @author Yuri <yuri.alec@hotmail.com>
 */
class DeleteConfEmail
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
        if ((!empty($id))) {
            $this->id = (int) $id;
            $deleteConfEmail = new AdmsDeleteConfEmail();
            $deleteConfEmail->deleteConfEMail($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Configuração não encontrada</p>";
        }

        $urlRedirect = URLADM . "list-conf-email/index";
        header("Location: $urlRedirect");
    }
}
