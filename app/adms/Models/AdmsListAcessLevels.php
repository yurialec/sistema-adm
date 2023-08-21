<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsPagination;
use App\adms\Models\Helper\AdmsRead;

class AdmsListAcessLevels
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

    public function listAcessLevels(int $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new AdmsPagination(URLADM . 'list-access-levels/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(level.id) AS num_result FROM adms_access_levels level");
        $this->resultPg = $pagination->getResult();

        $listLevels = new AdmsRead();
        $listLevels->fullRead(
            "SELECT id, name, order_levels
                                FROM adms_access_levels
                                WHERE order_levels >:order_levels
                                ORDER BY order_levels ASC
                                LIMIT :limit OFFSET :offset",
            "order_levels=" . $_SESSION['order_levels'] . "&limit={$this->limitResult}&offset={$pagination->getOffset()}"
        );

        $this->resultBd = $listLevels->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhum resultado encontrado!<p>";
            $this->result = false;
        }
    }
}
