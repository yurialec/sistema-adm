<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsPagination;
use App\adms\Models\Helper\AdmsRead;

class AdmsListUsers
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

    public function listUsers(int $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new AdmsPagination(URLADM . 'list-users/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(usr.id) AS num_result FROM adms_users usr");
        $this->resultPg = $pagination->getResult();

        $listUsers = new AdmsRead();
        $listUsers->fullRead(
            "SELECT usr.id, usr.name, usr.email, usr.adms_sits_user_id,
                                situation.name AS situation_name,
                                color.color AS color_name
                                FROM adms_users AS usr
                                INNER JOIN adms_sits_users AS situation
                                ON situation.id =  usr.adms_sits_user_id
                                INNER JOIN adms_colors AS color
                                ON color.id = situation.adms_color_id
                                ORDER BY usr.id DESC
                                LIMIT :limit OFFSET :offset",
            "limit={$this->limitResult}&offset={$pagination->getOffset()}"
        );

        $this->resultBd = $listUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhum resultado encontrado!<p>";
            $this->result = false;
        }
    }
}
