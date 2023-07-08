<?php

namespace App\adms\Models;

use App\adms\Models\Helper\AdmsConn;
use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\Helper\AdmsValEmptyField;
use App\adms\Models\Helper\AdmsValPassword;

/**
 * Confirmar chave atualizar senha, cadastrar nova senha
 */
class AdmsUpdatePassword
{
    //Recebe a chave pra confirmar o e-mail
    private string $key;
    //retorna o resultado true ou false para requisição
    private bool $result;
    //recebe o email do remetente
    private string $fromEmail;
    //Recebe o primeiro nome do usuário
    private string $firstName;
    //Recebe os registro do banco de dados
    private array|null $resultBd;
    //Recebe os valores que devem ser salvos no banco de dados
    private array $dataSave;
    //Recebe os dados do formulário
    private array|null $data;

    /**
     * Retorna true quando executar o processo com sucesso
     *
     * @return boolean
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Receber a chave, verificar se é valida no banco de dados
     * @return void
     */
    public function valKey(string $key): bool
    {
        $this->key = $key;
        $viewKeyUpPass = new \App\adms\Models\helper\AdmsRead();
        $viewKeyUpPass->fullRead(
            "SELECT id
                                FROM adms_users
                                WHERE recover_password=:recover_password
                                LIMIT :limit",
            "recover_password={$this->key}&limit=1"
        );

        $this->resultBd = $viewKeyUpPass->getResult();

        if ($this->resultBd) {
            $this->result = true;
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link inválido, solicite novo link <a href='" . URLADM . "recover-password/index'>clique aqui</a>!</p>";
            $this->result = false;
            return false;
        }
    }

    public function editPassword(array $data = null): void
    {
        $this->data = $data;
        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->valIput();
        } else {
            $this->result = false;
        }
    }

    private function valIput(): void
    {
        $valPassword = new AdmsValPassword();
        $valPassword->validatePassword($this->data['password']);

        if ($valPassword->getResult()) {

            if ($this->valKey($this->data['key'])) {
                $this->updatePassword();
            } else {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    private function updatePassword(): void
    {
        $this->dataSave['recover_password'] = null;
        $this->dataSave['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->dataSave['modified'] = date("Y-m-d H:i:s");

        $upPassword = new AdmsUpdate();
        $upPassword->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($upPassword->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Senha atualizada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Senha não atualizada, tentenovamente!</p>";
            $this->result = false;
        }
    }
}
