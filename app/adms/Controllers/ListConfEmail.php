<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListConfEmails;
use Core\ConfigView;

class ListConfEmail
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

        $listConfEmail = new AdmsListConfEmails();
        $listConfEmail->listConfEmail($this->page);

        if ($listConfEmail->getResult()) {
            $this->data['listConfEmail'] = $listConfEmail->getResultBd();
            $this->data['pagination'] = $listConfEmail->getResultPg();
        } else {
            $this->data['listConfEmail'] = [];
        }

        $loadView = new ConfigView("adms/Views/ConfEmail/ListConfEmail", $this->data);
        $loadView->loadView();
    }
}
