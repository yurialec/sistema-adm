<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListSitsUsers;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

class ListSitsUsers
{
    /**
     * @var array|string|null $data Recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data;

    /**
     * Metodo Visualizar Usuários
     *
     * @return void
     */
    public function index(): void
    {
        $listSitsUsers = new AdmsListSitsUsers();
        $listSitsUsers->listSitsUsers();

        if ($listSitsUsers->getResult()) {
            $this->data['listSitsUsers'] = $listSitsUsers->getResultBd();
            $this->data['pagination'] = $listSitsUsers->getResultPg();
        } else {
            $this->data['listSitsUsers'] = [];
        }

        $this->data['sidebarActive'] = "list-sits-users";

        $button = [
            'add_sits_users' => [
                'menu_controller' => 'add-sits-users',
                'menu_metodo' => 'index'
            ],
            'view_sits_users' => [
                'menu_controller' => 'view-sits-users',
                'menu_metodo' => 'index'
            ],
            'edit_sits_users' => [
                'menu_controller' => 'edit-sits-users',
                'menu_metodo' => 'index'
            ],
            'delete_sits_users' => [
                'menu_controller' => 'delete-sits-users',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/Situation/ListSitsUsers", $this->data);
        $loadView->loadView();
    }
}
