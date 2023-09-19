<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListPermission;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

class ListPermission
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
     * Recebe o número do id do número de acesso
     *
     * @var integer
     */
    private int $level;

    /**
     * Metodo listar Permissoes Usuários
     *
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        $this->level = filter_input(INPUT_GET, 'level', FILTER_SANITIZE_NUMBER_INT);

        $this->page = (int) $page ? $page : 1;

        $listPermission = new AdmsListPermission();
        $listPermission->listPermission($this->page, $this->level);

        if ($listPermission->getResult()) {
            $this->data['listPermission'] = $listPermission->getResultBd();
            $this->data['viewAccessLevel'] = $listPermission->getResultBdLevel();
            $this->data['pagination'] = $listPermission->getResultPg();
            $this->data['pag'] = $this->page;
            $this->viewPermission();
        } else {
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Carregar View
     *
     * @return void
     */
    public function viewPermission(): void
    {
        $this->data['sidebarActive'] = "list-access-levels";

        $button = [
            'list_access_levels' => [
                'menu_controller' => 'list-access-levels',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/Permissions/ListPermission", $this->data);
        $loadView->loadView();
    }
}
