<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsViewGroupsPages;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página visualizar Tipos de paginas
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ViewGroupPage
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Visualizar Tipos de paginas
     *
     * @return void
     */
    public function index(string|int|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;

            $viewGroupsPages = new AdmsViewGroupsPages();
            $viewGroupsPages->viewGroupsPages($this->id);

            if ($viewGroupsPages->getResult()) {
                $this->data['viewGroupsPages'] = $viewGroupsPages->getResultBd();
                $this->viewTypesPgs();
            } else {
                $urlRedirect = URLADM . "list-groups-pgs/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Grupo de página não encontrado!</p>";
            $urlRedirect = URLADM . "list-groups-pgs/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Carregar View
     *
     * @return void
     */
    public function viewTypesPgs(): void
    {
        $button = [
            'view_group_page' => [
                'menu_controller' => 'view-group-page',
                'menu_metodo' => 'index'
            ],
            'edit_group_page' => [
                'menu_controller' => 'edit-group-page',
                'menu_metodo' => 'index'
            ],
            'delete_group_page' => [
                'menu_controller' => 'delete-group-page',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/GroupPages/viewGroupPages", $this->data);
        $loadView->loadView();
    }
}
