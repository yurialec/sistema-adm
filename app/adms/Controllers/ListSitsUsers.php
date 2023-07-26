<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListSitsUsers;
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

        $loadView = new ConfigView("adms/Views/Situation/ListSitsUsers", $this->data);
        $loadView->loadView();
    }
}
