<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsDeleteGroupPage;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Controller da página apagar grupos de página
 * @author Yuri <yuri.alec@hotmail.com>
 */
class DeleteGroupPage
{
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Apagar grupos de página
     *
     * @return void
     */
    public function index(string|int|null $id): void
    {
        if ((!empty($id))) {
            $this->id = (int) $id;
            $deleteGroupPage = new AdmsDeleteGroupPage();
            $deleteGroupPage->delete($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Grupo de Página não encontrada</p>";
        }

        $urlRedirect = URLADM . "list-groups-pages/index";
        header("Location: $urlRedirect");
    }
}
