<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsViewSituationPage;
use Core\ConfigView;

/**
 * Controller da página visualizar situação da página
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ViewSituationPage
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Visualizar situação da página
     *
     * @return void
     */
    public function index(string|int|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;
            $viewSitsPg = new AdmsViewSituationPage();
            $viewSitsPg->viewSitsPg($this->id);

            if ($viewSitsPg->getResult()) {
                $this->data['viewSitsPg'] = $viewSitsPg->getResultBd();
                $this->viewUser();
            } else {
                $urlRedirect = URLADM . "list-situation-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Situação da Página não encontrada</p>";
            $urlRedirect = URLADM . "list-situation-pages/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Carregar View
     *
     * @return void
     */
    public function viewUser(): void
    {
        $loadView = new ConfigView("adms/Views/SituationPages/viewSituationPages", $this->data);
        $loadView->loadView();
    }
}
