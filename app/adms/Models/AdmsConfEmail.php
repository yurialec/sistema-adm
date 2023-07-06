<?php

namespace App\adms\Models;

use App\adms\Models\Helper\AdmsConn;
use App\adms\Models\Helper\AdmsRead;

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
        $conf_email = null;
        $adms_sits_user_id = 1;

        $query_activate_user = "UPDATE adms_users
                                SET conf_email=:conf_email,
                                adms_sits_user_id=:adms_sits_user_id,
                                modified=NOW()
                                WHERE id=:id
                                LIMIT 1";

        $activate_email = $this->connectionDb()->prepare($query_activate_user);
        $activate_email->bindParam(':conf_email', $conf_email);
        $activate_email->bindParam(':adms_sits_user_id', $adms_sits_user_id);
        $activate_email->bindParam(':id', $this->resultBd[0]['id']);

        $activate_email->execute();

        if ($activate_email->rowCount() > 0) {
            $_SESSION['msg'] = "<p style='color: #008000;'>E-mail ativado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link Inválido!</p>";
            $this->result = false;
        }
    }
}
