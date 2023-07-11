<?php

namespace App\adms\Controllers;

use Core\ConfigView;

/**
 * Controller da página erro
 * @author Yuri <yuri.alec@hotmail.com>
 */
class Erro
{
    /**
     * @var array|string|null $data Recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data;

    /**
     * Metodo index
     *
     * @return void
     */
    public function index(): void
    {
        echo "Pagina de Erro<br>";

        $this->data = "<p style='color: #f00;'>Página não encontrada</p>";

        $loadView = new ConfigView("adms/Views/Erro/Erro", $this->data);
        $loadView->loadViewLogin();
    }
}
