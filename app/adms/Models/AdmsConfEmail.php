<?php

namespace App\adms\Models;

use App\adms\Models\Helper\AdmsConn;
use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;

/**
 * Confirmar o cadastro do usuário
 */
class AdmsConfEmail extends AdmsConn
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
    private array $resultBd;
    //Recebe os valores que devem ser salvos no banco de dados
    private array $dataSave;

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
    public function confEmail(string $key): void
    {
        $this->key = $key;

        if (!empty($this->key)) {
            $viewKeyConfEmail = new AdmsRead();
            $viewKeyConfEmail->fullRead("SELECT id
                                            FROM adms_users
                                            WHERE conf_email =:conf_email
                                            LIMIT :limit", "conf_email={$this->key}&limit=1");
            $this->resultBd = $viewKeyConfEmail->getResult();

            if ($this->resultBd) {
                $this->updateSitUser();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link Inválido!</p>";
                $this->result = false;
                echo "<p style='color: #f00;'>Erro: Link Inválido!</p>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link Inválido!</p>";
            $this->result = false;
        }
    }

    /**
     * Atualizar situação do usuário
     *
     * @return void
     */
    private function updateSitUser(): void
    {
        $this->dataSave['conf_email'] = null;
        $this->dataSave['adms_sits_user_id'] = 1;

        $updateConfEmail = new AdmsUpdate();
        $updateConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($updateConfEmail->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>E-mail ativado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link Inválido!</p>";
            $this->result = false;
        }

        $this->result = false;
    }
}
