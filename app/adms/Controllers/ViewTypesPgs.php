<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsViewTypesPgs;
use Core\ConfigView;

/**
 * Controller da página visualizar Tipos de paginas
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ViewTypesPgs
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Visualizar Tipos de paginas
     *
     * @return void
     */
    public function index(string|int|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;

            $viewTypesPgs = new AdmsViewTypesPgs();
            $viewTypesPgs->viewTypesPgs($this->id);

            if ($viewTypesPgs->getResult()) {
                $this->data['viewTypesPgs'] = $viewTypesPgs->getResultBd();
                $this->viewTypesPgs();
            } else {
                $urlRedirect = URLADM . "list-types-pgs/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Tipo de página não encontrado!</p>";
            $urlRedirect = URLADM . "list-types-pgs/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Carregar View
     *
     * @return void
     */
    public function viewTypesPgs(): void
    {
        $loadView = new ConfigView("adms/Views/TypesPages/viewTypesPages", $this->data);
        $loadView->loadView();
    }
}
