<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;

class AdmsListUsers
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

    public function listUsers(): void
    {
        $listUsers = new AdmsRead();
        $listUsers->fullRead("SELECT id, name, email FROM adms_users ORDER BY id DESC");

        $this->resultBd = $listUsers->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nenhum resultado encontrado!<p>";
            $this->result = false;
        }
    }
}
