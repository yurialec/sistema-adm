<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsCreate;
use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsValEmptyField;

class AdmsAddAcessLevel
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
        if ($this->viewLastAccessLevel()) {
            $this->data['created'] = date("Y-m-d H:i:s");

            $createAccessLevel = new AdmsCreate();
            $createAccessLevel->exeCreate("adms_access_levels", $this->data);

            if ($createAccessLevel->getResult()) {
                $_SESSION['msg'] = "<p style='color: #008000;'>Nível de Acesso cadastrado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao cadastrar Nível de Acesso!</p>";
                $this->result = false;
            }
        }
    }

    private function viewLastAccessLevel()
    {
        $viewLastAccessLevel = new AdmsRead();
        $viewLastAccessLevel->fullRead("SELECT order_levels FROM adms_access_levels ORDER BY order_levels DESC LIMIT 1");

        $this->resultBd = $viewLastAccessLevel->getResult();

        if ($this->resultBd) {
            $this->data['order_levels'] = $this->resultBd[0]['order_levels'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao cadastrar Nível de acesso</div>";
            return false;
        }
    }
}
