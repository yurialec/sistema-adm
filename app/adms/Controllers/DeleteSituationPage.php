<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsDeleteSituationPage;

/**
 * Controller da página apagar situação da página
 * @author Yuri <yuri.alec@hotmail.com>
 */
class DeleteSituationPage
{
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Apaga usuário
     *
     * @return void
     */
    public function index(string|int|null $id): void
    {
        if ((!empty($id))) {
            $this->id = (int) $id;
            $deleteSitsPg = new AdmsDeleteSituationPage();
            $deleteSitsPg->delete($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Situação da Página não encontrada</p>";
        }

        $urlRedirect = URLADM . "list-situation-pages/index";
        header("Location: $urlRedirect");
    }
}
