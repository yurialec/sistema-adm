<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListTypesPgs;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

class ListTypesPgs
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
     * Metodo Visualizar tipode de pagina
     *
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $listTypePgs = new AdmsListTypesPgs();
        $listTypePgs->listTypesPgs($this->page);

        if ($listTypePgs->getResult()) {
            $this->data['listTypePgs'] = $listTypePgs->getResultBd();
            $this->data['pagination'] = $listTypePgs->getResultPg();
        } else {
            $this->data['listTypePgs'] = [];
        }

        $this->data['pag'] = $this->page;
        $this->data['sidebarActive'] = "list-types-pgs";

        $button = [
            'add_type_pg' => [
                'menu_controller' => 'add-type-pg',
                'menu_metodo' => 'index'
            ],
            'order_type_pgs' => [
                'menu_controller' => 'order-type-pgs',
                'menu_metodo' => 'index'
            ],
            'view_types_pgs' => [
                'menu_controller' => 'view-types-pgs',
                'menu_metodo' => 'index'
            ],
            'edit_types_pgs' => [
                'menu_controller' => 'edit-types-pgs',
                'menu_metodo' => 'index'
            ],
            'delete_types_pgs' => [
                'menu_controller' => 'delete-types-pgs',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/TypesPages/ListTypesPages", $this->data);
        $loadView->loadView();
    }
}
