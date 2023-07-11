<?php

namespace App\adms\Controllers;

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
