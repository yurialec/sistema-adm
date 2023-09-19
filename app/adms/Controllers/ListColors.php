<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListColors;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

class ListColors
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

        $listColors = new AdmsListColors();
        $listColors->listColors($this->page);

        if ($listColors->getResult()) {
            $this->data['listColors'] = $listColors->getResultBd();
            $this->data['pagination'] = $listColors->getResultPg();
        } else {
            $this->data['listColors'] = [];
        }

        $this->data['sidebarActive'] = "list-colors";

        $button = [
            'add_color' => [
                'menu_controller' => 'add-color',
                'menu_metodo' => 'index'
            ],
            'view_color' => [
                'menu_controller' => 'view-color',
                'menu_metodo' => 'index'
            ],
            'edit_color' => [
                'menu_controller' => 'edit-color',
                'menu_metodo' => 'index'
            ],
            'delete_color' => [
                'menu_controller' => 'delete-color',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/Colors/listColors", $this->data);
        $loadView->loadView();
    }
}
