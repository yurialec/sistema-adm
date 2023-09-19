<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListAcessLevels;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

class ListAccessLevels
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
     * Metodo Visualizar niveis de acesso
     *
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $listAccessLevels = new AdmsListAcessLevels();
        $listAccessLevels->listAcessLevels($this->page);

        if ($listAccessLevels->getResult()) {
            $this->data['ListAccessLevels'] = $listAccessLevels->getResultBd();
            $this->data['pagination'] = $listAccessLevels->getResultPg();
        } else {
            $this->data['ListAccessLevels'] = [];
            $this->data['pagination'] = [];
        }

        $this->data['pag'] = $this->page;
        $this->data['sidebarActive'] = "list-access-levels";

        $button = [
            'add_access_level' => [
                'menu_controller' => 'add-access-level',
                'menu_metodo' => 'index'
            ],
            'sync_pages_levels' => [
                'menu_controller' => 'sync-pages-levels',
                'menu_metodo' => 'index'
            ],
            'view_access_level' => [
                'menu_controller' => 'view-access-level',
                'menu_metodo' => 'index'
            ],
            'edit_access_level' => [
                'menu_controller' => 'edit-access-level',
                'menu_metodo' => 'index'
            ],
            'delete_access_level' => [
                'menu_controller' => 'delete-access-level',
                'menu_metodo' => 'index'
            ],
            'list_permission' => [
                'menu_controller' => 'list-permission',
                'menu_metodo' => 'index'
            ],
            'order_access_level' => [
                'menu_controller' => 'order-access-level',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/AccessLevels/ListAccessLevels", $this->data);
        $loadView->loadView();
    }
}
