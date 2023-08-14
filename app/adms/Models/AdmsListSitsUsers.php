<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsPagination;
use App\adms\Models\Helper\AdmsRead;

class AdmsListSitsUsers
{
    //Recebe true quando executar com sucesso
    private bool $result;
    //Recebe os registro do banco de dados
    private array $resultBd;
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

    public function listSitsUsers(int $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination  = new AdmsPagination(URLADM . 'list-sits-users/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(sit.id) AS num_result FROM adms_sits_users sit");
        $this->resultPg = $pagination->getResult();

        $listSitsUsers = new AdmsRead();
        $listSitsUsers->fullRead(
            "SELECT adms_sits_users.id, adms_sits_users.name, adms_colors.color
                                    FROM adms_sits_users
                                    INNER JOIN adms_colors
                                    ON adms_colors.id = adms_sits_users.adms_color
                                    LIMIT :limit OFFSET :offset",
            "limit={$this->limitResult}&offset={$pagination->getOffset()}"
        );

        $this->resultBd = $listSitsUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhum resultado encontrado!<p>";
            $this->result = false;
        }
    }
}
