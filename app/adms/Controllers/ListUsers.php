<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListUsers;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

class ListUsers
{
    /**
     * @var array|string|null $data Recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data;

    /**
     * @var int|string|null $page o número da página que o usuário está
     */
    private int|string|null $page;

    /**
     * Metodo Visualizar Usuários
     *
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $listUsers = new AdmsListUsers();
        $listUsers->listUsers($this->page);

        if ($listUsers->getResult()) {
            $this->data['listUsers'] = $listUsers->getResultBd();
            $this->data['pagination'] = $listUsers->getResultPg();
        } else {
            $this->data['listUsers'] = [];
        }

        $button = [
            'add_users' => [
                'menu_controller' => 'add-users',
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
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $this->data['sidebarActive'] = "list-users";

        $loadView = new ConfigView("adms/Views/Users/ListUsers", $this->data);
        $loadView->loadView();
    }
}
