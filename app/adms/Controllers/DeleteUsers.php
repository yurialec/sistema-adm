<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsDeleteUsers;
use App\adms\Models\AdmsEditUsers;
use Core\ConfigView;

/**
 * Controller da página apagar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class DeleteUsers
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
            $deleteUser = new AdmsDeleteUsers();
            $deleteUser->deleteUser($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado</p>";
        }

        $urlRedirect = URLADM . "list-users/index";
        header("Location: $urlRedirect");
    }
}
