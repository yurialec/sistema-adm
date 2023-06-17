<?php

namespace App\adms\Controllers;

use Core\ConfigView;

/**
 * Controller da página visualizar usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ViewUsers
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
        $this->data = [];

        $loadView = new ConfigView("adms/Views/Users/viewUser", $this->data);
        $loadView->loadView();
    }
}
