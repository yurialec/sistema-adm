<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsCreate;
use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsValEmail;
use App\adms\Models\Helper\AdmsValEmptyField;

class AdmsAddSitsUsers
{
    /** Recebe as informações do formulário @var array|null */
    private array|null $data;
    /** Recebe true quando executar o processo com sucesso @var boolean */
    private bool $result;

    private array $listRecordAdd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    public function getResult()
    {
        return $this->result;
    }

    public function create(array $data = null)
    {
        $this->data = $data;

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    private function add(): void
    {
        $this->data['created'] = date("Y-m-d H:i:s");

        $createSitUser = new \App\adms\Models\helper\AdmsCreate();
        $createSitUser->exeCreate("adms_sits_users", $this->data);

        if ($createSitUser->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Situação cadastrada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Situação não cadastrada com sucesso!</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array
    {
        $list = new AdmsRead();
        $list->fullRead("SELECT id as id_color, name as name_color FROM adms_colors ORDER BY name ASC");
        $records['color'] = $list->getResult();

        $this->listRecordAdd = ['color' => $records['color']];

        return $this->listRecordAdd;
    }
}
