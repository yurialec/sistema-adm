<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;

class AdmsViewSitsUsers
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array|null $resultBd;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /** Retorna true caso tenha sucesso @return boolean */
    public function getResult(): bool
    {
        return $this->result;
    }

    /** Retorna os registros do banco de dados @return array|null */
    public function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewSituation(int $id): void
    {
        $this->id = $id;
        $viewSituation = new AdmsRead();
        $viewSituation->fullRead(
            "SELECT adms_sits_users.id, adms_sits_users.name, adms_colors.color,
                    adms_sits_users.created, adms_sits_users.modified 
            FROM adms_sits_users
            INNER JOIN adms_colors
            ON adms_colors.id = adms_sits_users.adms_color
            WHERE adms_sits_users.id=:id
            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewSituation->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Situação não encontrada!<p>";
            $this->result = false;
        }
    }
}
