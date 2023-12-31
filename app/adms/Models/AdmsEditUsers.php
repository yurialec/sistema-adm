<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\Helper\AdmsValEmail;
use App\adms\Models\Helper\AdmsValEmailSingle;
use App\adms\Models\Helper\AdmsValEmptyField;
use App\adms\Models\Helper\AdmsValUserSingle;

/**
 * Editar usuário no banco de dados
 */
class AdmsEditUsers
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array $resultBd;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;
    //Recebe os dados
    private array|null $data;
    //Rcebe os campos que serão removidos da validação
    private array|null $dataExitVal;
    //
    private array $listRecordEdit;

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
            "SELECT usr.id, usr.name, usr.email, usr.nick_name,
            usr.user, usr.image, usr.adms_sits_user_id, usr.adms_access_level_id
            FROM adms_users as usr
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

    public function updateUser(array $data = null): void
    {
        $this->data = $data;
        $this->dataExitVal['nick_name'] = $this->data['nick_name'];
        unset($this->data['nick_name']);

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->valInput();
            $this->result = true;
        } else {
            $this->result = false;
        }
    }

    private function valInput(): void
    {
        $valEMail = new AdmsValEmail();
        $valEMail->validateEmail($this->data['email']);

        $valEmailSingle = new AdmsValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email'], true, $this->data['id']);

        $valUserSingle = new AdmsValUserSingle();
        $valUserSingle->validateUserSingle($this->data['user'], true, $this->data['id']);

        if (($valEMail->getResult()) and ($valEmailSingle->getResult()) and ($valUserSingle->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['nick_name'] = $this->dataExitVal['nick_name'];

        $updateUser = new AdmsUpdate();

        $updateUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updateUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Usuário atualizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não atualizado com sucesso!</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array
    {
        $list = new AdmsRead();

        $list->fullRead("SELECT id as id_sit, name as name_sit FROM adms_sits_users ORDER BY name ASC");
        $records['sit'] = $list->getResult();

        $list->fullRead("SELECT id as id_level, name as name_level
                            FROM adms_access_levels
                            WHERE order_levels >:order_levels
                            ORDER BY name ASC", "order_levels=" . $_SESSION['order_levels']);
        $records['level'] = $list->getResult();

        $this->listRecordEdit = [
            'sit' => $records['sit'],
            'level' => $records['level']
        ];

        return $this->listRecordEdit;
    }
}
