<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsListUsers;
use Core\ConfigView;

class ListUsers
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
        $listUsers = new AdmsListUsers();
        $listUsers->listUsers();

        if ($listUsers->getResult()) {
            $this->data['listUsers'] = $listUsers->getResultBd();
        } else {
            $this->data['listUsers'] = [];
        }

        $loadView = new ConfigView("adms/Views/Users/ListUsers", $this->data);
        $loadView->loadView();
    }
}
