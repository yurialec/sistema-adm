<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsDeleteColor;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}


/**
 * Controller da página apagar Cores
 * @author Yuri <yuri.alec@hotmail.com>
 */
class DeleteColor
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
            $deleteColor = new AdmsDeleteColor();
            $deleteColor->deleteColor($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Cor não encontrada</p>";
        }

        $urlRedirect = URLADM . "list-colors/index";
        header("Location: $urlRedirect");
    }
}
