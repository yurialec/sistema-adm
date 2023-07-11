<?php

namespace App\adms\Models\Helper;

/**
 * Classe genérica para validar o usuário único, somente um cadastro pode utilizar o usuário
 */
class AdmsValUserSingle
{
    private string $user;
    private bool|null $edit;
    private int|null $id;
    private bool $result;
    private array|null $resultBd;

    public function getResult(): bool
    {
        return $this->result;
    }

    public function validateUserSingle(string $user, bool|null $edit = null, int|null $id = null): void
    {
        $this->user = $user;
        $this->edit = $edit;
        $this->id = $id;

        $valUserSingle = new AdmsRead();

        if (($this->edit == true) and (!empty($this->id))) {
            $valUserSingle->fullRead("SELECT id FROM adms_users WHERE user
            =:user id <>:id LIMIT :limit", "user={$this->user}&id={$this->id}&limit=1");
        } else {
            $valUserSingle->fullRead("SELECT id FROM adms_users WHERE user
            =:user LIMIT :limit", "user={$this->user}&limit=1");
        }

        $this->resultBd = $valUserSingle->getResult();

        if (!$this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Este usuário já está sendo utilizado.<p>";
            $this->result = false;
        }
    }
}
