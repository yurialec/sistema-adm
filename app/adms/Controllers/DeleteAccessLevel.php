<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsDeleteAccessLevel;
use App\adms\Models\AdmsDeleteUsers;

/**
 * Controller da página apagar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class DeleteAccessLevel
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
            $deleteAccessLevel = new AdmsDeleteAccessLevel();
            $deleteAccessLevel->delete($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Nível de Acesso não encontrado</p>";
        }

        $urlRedirect = URLADM . "list-access-levels/index";
        header("Location: $urlRedirect");
    }
}
