<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

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
