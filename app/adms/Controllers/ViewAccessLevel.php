<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsViewAccessLevels;
use Core\ConfigView;

/**
 * Controller da página visualizar usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ViewAccessLevel
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Visualizar Usuários
     *
     * @return void
     */
    public function index(string|int|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;
            $viewAccessLevel = new AdmsViewAccessLevels();
            $viewAccessLevel->viewLevel($this->id);

            if ($viewAccessLevel->getResult()) {
                $this->data['viewAccessLevel'] = $viewAccessLevel->getResultBd();
                $this->viewAccessLevel();
            } else {
                $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Nível de acesso não encontrado!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Carregar View
     *
     * @return void
     */
    public function viewAccessLevel(): void
    {
        $loadView = new ConfigView("adms/Views/AccessLevels/ViewAccessLevel", $this->data);
        $loadView->loadView();
    }
}
