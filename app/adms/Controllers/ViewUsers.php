<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsViewUsers;
use Core\ConfigView;

/**
 * Controller da página visualizar usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ViewUsers
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Visualizar Usuários
     *
     * @return void
     */
    public function index(string|int|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;
            $viewUser = new AdmsViewUsers();
            $viewUser->ViewUser($this->id);

            if ($viewUser->getResult()) {
                $this->data['viewUser'] = $viewUser->getResultBd();
                $this->viewUser();
            } else {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Carregar View
     *
     * @return void
     */
    public function viewUser(): void
    {
        $loadView = new ConfigView("adms/Views/Users/viewUser", $this->data);
        $loadView->loadView();
    }
}
