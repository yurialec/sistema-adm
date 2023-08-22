<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListTypesPgs;
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

        $loadView = new ConfigView("adms/Views/TypesPages/ListTypesPages", $this->data);
        $loadView->loadView();
    }
}
