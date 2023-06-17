<?php

namespace App\adms\Controllers;

use Core\ConfigView;

/**
 * Controller da página login
 * @author Yuri <yuri.alec@hotmail.com>
 */
class Login
{
    /**
     * @var array|string|null $data Recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data;

    /**
     * Metodo Login
     *
     * @return void
     */
    public function index(): void
    {
        echo "Pagina de Login<br>";

        $this->data = null;

        $loadView = new ConfigView("adms/Views/Login/Login", $this->data);
        $loadView->loadView();
    }
}
