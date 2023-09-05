<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsPagination;
use App\adms\Models\Helper\AdmsRead;

class AdmsListPages
{
    //Recebe true quando executar com sucesso
    private bool $result;
    //Recebe os registro do banco de dados
    private array|null $resultBd;
    //Recebe o número da página
    private int $page;
    //Recebe a quantidade de resgistro que deve retornar do banco de dados 
    private int $limitResult = 15;
    //Recebe a paginação
    private string|null $resultPg;

    public function getResult(): bool
    {
        return $this->result;
    }

    public function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function getResultPg(): string|null
    {
        return $this->resultPg;
    }

    public function list(int $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new AdmsPagination(URLADM . 'list-pages/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(pg.id) AS num_result FROM adms_pages pg");
        $this->resultPg = $pagination->getResult();

        $listPgs = new AdmsRead();
        $listPgs->fullRead(
            "SELECT pg.id, pg.name_page,
                    atp.type AS type_pg,
                    atp.name AS name_type_pg,
                    asp.name AS situation_pg_name,
                    ac.color AS color_name
                    FROM adms_pages as pg
                    INNER JOIN adms_types_pgs AS atp
                    ON atp.id = pg.adms_types_pgs_id
                    INNER JOIN adms_sits_pgs AS asp
                    ON asp.id = pg.adms_sits_pgs_id
                        INNER JOIN adms_colors AS ac
                        ON asp.adms_color_id = ac.id
                    ORDER BY id DESC
                    LIMIT :limit OFFSET :offset",
            "limit={$this->limitResult}&offset={$pagination->getOffset()}"
        );

        $this->resultBd = $listPgs->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhum resultado encontrado!<p>";
            $this->result = false;
        }
    }
}
