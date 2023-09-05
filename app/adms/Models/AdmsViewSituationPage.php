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

    public function view(int $id): void
    {
        $this->id = $id;
        $viewSitsPg = new AdmsRead();
        $viewSitsPg->fullRead(
            "SELECT ap.id, ap.controller, ap.metodo, ap.menu_controller,
                    ap.menu_metodo, ap.name_page, ap.publish, ap.icon,
                    ap.obs, ap.created, ap.modified,
                    asp.name AS situation_name,
                    ac.color AS color_name,
                    atp.name AS type_pg_name,
                    atp.type AS type_pg,
                    agp.name AS group_pg
                    FROM adms_pages AS ap
                    INNER JOIN adms_sits_pgs AS asp
                    ON asp.id = ap.adms_sits_pgs_id
                        INNER JOIN adms_colors AS ac
                        ON ac.id = asp.adms_color_id
                    INNER JOIN adms_types_pgs AS atp
                    ON atp.id = ap.adms_types_pgs_id
                    INNER JOIN adms_groups_pgs AS agp
                    ON agp.id = ap.adms_groups_pgs_id
                    WHERE ap.id=:id
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
