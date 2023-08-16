<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;

/** Página inicial do sistema administrativo */
class AdmsDashboard
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array $resultBd;

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

    public function countUsers(): void
    {
        $countUsers = new AdmsRead();
        $countUsers->fullRead("SELECT COUNT(id) as qnt_users FROM adms_users");

        $this->resultBd = $countUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $this->result = false;
        }
    }
}
