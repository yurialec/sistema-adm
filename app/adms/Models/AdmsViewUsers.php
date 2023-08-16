<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;

class AdmsViewUsers
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

    public function ViewUser(int $id): void
    {
        $this->id = $id;
        $viewUser = new AdmsRead();
        $viewUser->fullRead(
            "SELECT usr.id, usr.name AS name_usr, usr.email, usr.nick_name,
                    usr.user, usr.image, usr.created_at, usr.modified,
            sit.name AS name_sit,
            color.color
            FROM adms_users AS usr
            INNER JOIN adms_sits_users AS sit ON sit.id =  usr.adms_sits_user_id
            INNER JOIN adms_colors AS color ON color.id = sit.adms_color
            WHERE usr.id=:id
            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Usuário não encontrado!<p>";
            $this->result = false;
        }
    }
}
