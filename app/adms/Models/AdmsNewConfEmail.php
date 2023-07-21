<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsConn;
use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\Helper\AdmsValEmptyField;

/**
 * Solicitar novo link para confirmar o e-mail
 */
class AdmsNewConfEmail extends AdmsConn
{
    //Recebe os dados do formulário
    private array|null $data;
    //Recebe o primeiro nome do usuário
    private string $firstName;
    //Recebe os dados do conteúdo do e-mail
    private array $emailData;
    //retorna o resultado true ou false para requisição
    private bool $result;
    //Recebe os registro do banco de dados
    private array $resultBd;
    //recebe o email do remetente
    //URL com o endereço para o usuário confirmar o e-mail
    private string $url;
    //recebe o email do remetente
    private string $fromEmail;

    private array $dataSave;

    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Receber a chave, verificar se é valida no banco de dados
     * @return void
     */
    public function newConfEmail(array|null $data = null): void
    {
        $this->data = $data;
        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->valUser();
        } else {
            $this->result = false;
        }
    }

    private function valUser(): void
    {
        $newConfEmail = new AdmsRead();
        $newConfEmail->fullRead(
            "SELECT id, name, email, conf_email
                                    FROM adms_users
                                    WHERE email=:email
                                    LIMIT :limit",
            "email={$this->data['email']}&limit=1"
        );
        $this->resultBd = $newConfEmail->getResult();

        if ($this->resultBd) {
            $this->valConfEmail();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail não cadastrado!</p>";
            $this->result = false;
        }
    }

    private function valConfEmail(): void
    {
        if (empty($this->resultBd[0]['conf_email']) or ($this->resultBd[0]['conf_email'] == NULL)) {
            $this->dataSave['conf_email'] = password_hash(date("Y-m-d H:m:s") . $this->resultBd[0]['id'], PASSWORD_DEFAULT);

            $updateNewConfEmail = new AdmsUpdate();
            $updateNewConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

            if ($updateNewConfEmail->getResult()) {
                $this->resultBd[0]['conf_email'] = $this->dataSave['conf_email'];
                $this->sendEmail();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link não enviado, tente novamente!</p>";
                $this->result = false;
            }

            $this->result = false;
        } else {
            $this->sendEmail();
        }
    }

    private function sendEmail(): void
    {
        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();
        $this->emailHTML();
        $this->emailText();
        $sendEmail->sendEmail($this->emailData, 2);
        if ($sendEmail->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Novo link enviado com sucesso. Acesse a sua caixa de e-mail para confimar o e-mail!</p>";
            $this->result = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Link não enviado, tente novamente ou entre em contato com o e-mail {$this->fromEmail}!</p>";
            $this->result = false;
        }
    }

    private function emailHTML(): void
    {
        $name = explode(" ", $this->resultBd[0]['name']);
        $this->firstName = $name[0];

        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->firstName;
        $this->emailData['subject'] = "Confirma sua conta";
        $this->url = URLADM . "conf-email/index?key=" . $this->resultBd[0]['conf_email'];

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso site!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}'>{$this->url}</a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";
    }

    private function emailText(): void
    {
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso site!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: \n\n";
        $this->emailData['contentText'] .=  $this->url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";
    }
}
