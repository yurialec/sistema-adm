<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsDashboard;
use Core\ConfigView;

/**
 * Controller da página Dashboard
 * @author Yuri <yuri.alec@hotmail.com>
 */
class Dashboard
{
    /**
     * @var array|string|null $data Recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data = null;

    /**
     * Metodo index
     *
     * @return void
     */
    public function index(): void
    {
        $countUsers = new AdmsDashboard();
        $countUsers->countUsers();

        if ($countUsers->getResult()) {
            $this->data['countUsers'] = $countUsers->getResultBd();
        } else {
            $this->data['countUsers'] = false;
        }

        $this->data['sidebarActive'] = "dashboard";

        $loadView = new ConfigView("adms/Views/Dashboard/Dashboard", $this->data);
        $loadView->loadView();
    }
}
