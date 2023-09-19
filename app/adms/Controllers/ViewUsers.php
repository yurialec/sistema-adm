<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsViewUsers;
use App\adms\Models\Helper\AdmsButton;
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
        $button = [
            'list_users' => [
                'menu_controller' => 'list-users',
                'menu_metodo' => 'index'
            ],
            'view_users' => [
                'menu_controller' => 'view-users',
                'menu_metodo' => 'index'
            ],
            'edit_users' => [
                'menu_controller' => 'edit-users',
                'menu_metodo' => 'index'
            ],
            'delete_users' => [
                'menu_controller' => 'delete-users',
                'menu_metodo' => 'index'
            ],
            'edit_users_password' => [
                'menu_controller' => 'edit-users-password',
                'menu_metodo' => 'index'
            ],
            'edit_users_image' => [
                'menu_controller' => 'edit-users-image',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/Users/viewUser", $this->data);
        $loadView->loadView();
    }
}
