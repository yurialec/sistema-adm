<?php

namespace App\adms\Models;

use App\adms\Models\Helper\AdmsRead;

/**
 * Visualizar perfil do usuário
 */
class AdmsViewProfile
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

    public function viewProfile(): void
    {
        $viewUser = new AdmsRead();
        $viewUser->fullRead(
            "SELECT name, email, nick_name, created_at, modified
            FROM adms_users
            WHERE id=:id
            LIMIT :limit",
            "id=" . $_SESSION['user_id'] . "&limit=1"
        );

        $this->resultBd = $viewUser->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Perfil não encontrado!<p>";
            $this->result = false;
        }
    }
}
