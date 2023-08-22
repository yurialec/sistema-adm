<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsCreate;
use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsValEmptyField;

class AdmsAddGroupPage
{
    /** Recebe as informações do formulário @var array|null */
    private array|null $data;
    /** Recebe true quando executar o processo com sucesso @var boolean */
    private bool $result;
    /** Recebe registros do banco de dados @var array */
    private array $resultBd;

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
        if ($this->viewLastGroupPage()) {
            $this->data['created'] = date("Y-m-d H:i:s");

            $createTypePg = new AdmsCreate();
            $createTypePg->exeCreate("adms_groups_pgs", $this->data);

            if ($createTypePg->getResult()) {
                $_SESSION['msg'] = "<p style='color: #008000;'>Grupo de Página cadastrada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao cadastrar Grupo de Página!</p>";
                $this->result = false;
            }
        }
    }

    private function viewLastGroupPage()
    {
        $viewLastGroupPage = new AdmsRead();
        $viewLastGroupPage->fullRead("SELECT order_group_pg FROM adms_groups_pgs ORDER BY order_group_pg DESC LIMIT 1");

        $this->resultBd = $viewLastGroupPage->getResult();

        if ($this->resultBd) {
            $this->data['order_group_pg'] = $this->resultBd[0]['order_group_pg'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao cadastrar Tipo de Página!</div>";
            return false;
        }
    }
}
