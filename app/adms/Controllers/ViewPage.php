<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsViewSituationPage;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página visualizar situação da página
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ViewPage
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Visualizar situação da página
     *
     * @return void
     */
    public function index(string|int|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;
            $viewPg = new AdmsViewSituationPage();
            $viewPg->view($this->id);

            if ($viewPg->getResult()) {
                $this->data['viewPg'] = $viewPg->getResultBd();
                $this->viewPage();
            } else {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Situação da Página não encontrada</p>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Carregar View
     *
     * @return void
     */
    public function viewPage(): void
    {
        $button = [
            'list_pages' => [
                'menu_controller' => 'list-pages',
                'menu_metodo' => 'index'
            ],
            'edit_page' => [
                'menu_controller' => 'edit-page',
                'menu_metodo' => 'index'
            ],
            'delete_page' => [
                'menu_controller' => 'delete-page',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/Pages/viewPages", $this->data);
        $loadView->loadView();
    }
}
