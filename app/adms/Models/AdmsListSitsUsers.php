<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;

class AdmsListSitsUsers
{
    //Recebe true quando executar com sucesso
    private bool $result;
    //Recebe os registro do banco de dados
    private array $resultBd;

    public function getResult(): bool
    {
        return $this->result;
    }

    public function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function listSitsUsers(): void
    {
        $listSitsUsers = new AdmsRead();
        $listSitsUsers->fullRead("SELECT adms_sits_users.id, adms_sits_users.name, adms_colors.color
                                    FROM adms_sits_users
                                    INNER JOIN adms_colors
                                    ON adms_colors.id = adms_sits_users.adms_color_id
                                ");

        $this->resultBd = $listSitsUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhum resultado encontrado!<p>";
            $this->result = false;
        }
    }
}
