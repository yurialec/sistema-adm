<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListAcessLevels;
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

        $loadView = new ConfigView("adms/Views/AccessLevels/ListAccessLevels", $this->data);
        $loadView->loadView();
    }
}
