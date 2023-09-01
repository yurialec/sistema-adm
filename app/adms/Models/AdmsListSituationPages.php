<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsPagination;
use App\adms\Models\Helper\AdmsRead;

class AdmsListSituationPages
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

    public function listSitsPgs(int $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new AdmsPagination(URLADM . 'list-situation-pages/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(asp.id) AS num_result FROM adms_sits_pgs asp");
        $this->resultPg = $pagination->getResult();

        $listSitsPgs = new AdmsRead();
        $listSitsPgs->fullRead(
            "SELECT adms_sits_pgs.id, adms_sits_pgs.name, adms_colors.color as color_name
                        FROM adms_sits_pgs
                        INNER JOIN adms_colors
                        ON adms_colors.id = adms_sits_pgs.adms_color_id
                        ORDER BY id DESC
                                LIMIT :limit OFFSET :offset",
            "limit={$this->limitResult}&offset={$pagination->getOffset()}"
        );

        $this->resultBd = $listSitsPgs->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhum resultado encontrado!<p>";
            $this->result = false;
        }
    }
}
