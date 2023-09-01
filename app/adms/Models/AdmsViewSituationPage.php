<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;

class AdmsViewSituationPage
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

    public function viewSitsPg(int $id): void
    {
        $this->id = $id;
        $viewSitsPg = new AdmsRead();
        $viewSitsPg->fullRead(
            "SELECT asp.id, asp.name, asp.created, asp.modified, color.color
                    FROM adms_sits_pgs AS asp
                    INNER JOIN adms_colors AS color
                    ON color.id = asp.adms_color_id
                    WHERE asp.id=:id
                    LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewSitsPg->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Situação da Página não encontrada!<p>";
            $this->result = false;
        }
    }
}
