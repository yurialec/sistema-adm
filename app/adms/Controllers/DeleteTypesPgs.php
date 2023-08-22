<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsDeleteTypePage;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Controller da página apagar tipos de página
 * @author Yuri <yuri.alec@hotmail.com>
 */
class DeleteTypesPgs
{
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Apaga tipos de página
     *
     * @return void
     */
    public function index(string|int|null $id): void
    {
        if ((!empty($id))) {
            $this->id = (int) $id;
            $deleteTypePage = new AdmsDeleteTypePage();
            $deleteTypePage->delete($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: DTipo de Página não encontrada</p>";
        }

        $urlRedirect = URLADM . "list-types-pgs/index";
        header("Location: $urlRedirect");
    }
}
