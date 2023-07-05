<?php

namespace App\adms\Models;

use App\adms\Models\Helper\AdmsConn;
use App\adms\Models\Helper\AdmsCreate;
use App\adms\Models\Helper\AdmsSendEmail;
use App\adms\Models\Helper\AdmsValEmail;
use App\adms\Models\Helper\AdmsValEmailSingle;
use App\adms\Models\Helper\AdmsValEmptyField;
use App\adms\Models\Helper\AdmsValPassword;
use App\adms\Models\Helper\AdmsValUserSingleLogin;

class AdmsNewUser extends AdmsConn
{
    private array|null $data;
    private $result;
    //recebe o email do remetente
    private string $fromEmail;
    //Recebe o primeiro nome do usuário
    private string $firstName;
    //Recebe os dados do conteúdo do e-mail
    private array $emailData;
    //URL com o endereço para o usuário confirmar o e-mail
    private string $url;

    public function getResult()
    {
        return $this->result;
    }

    public  function create(array $data = null)
    {
        $this->data = $data;

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->vaInput();
        } else {
            $this->result = false;
        }
    }

    private function vaInput(): void
    {
        $valEMail = new AdmsValEmail();
        $valEMail->validateEmail($this->data['email']);

        $valEmailSingle = new AdmsValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email']);

        $valPassowrd = new AdmsValPassword();
        $valPassowrd->validatePassword($this->data['password']);

        $valUserSingleLogin = new AdmsValUserSingleLogin();
        $valUserSingleLogin->validateUserSingleLogin($this->data['email']);

        if (($valEMail->getResult()) and ($valEmailSingle->getResult()) and ($valPassowrd->getResult()) and ($valUserSingleLogin->getResult())) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    private function add(): void
    {
        $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
        $this->data['user'] = $this->data['email'];
        $this->data['conf_email'] = password_hash($this->data['password'] . date("Y-m-d H:m:s"), PASSWORD_DEFAULT);
        $this->data['created_at'] = date("Y-m-d H:m:s");

        $createUser = new AdmsCreate();
        $createUser->exeCreate("adms_users", $this->data);

        if ($createUser->getResult()) {
            $this->sendEmail();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao cadastrar usurário!</p>";
            $this->result = false;
        }
    }

    private function sendEmail(): void
    {
        $this->contentEmailHtml();
        $this->contentEmailText();

        $sendEmail = new AdmsSendEmail();
        $sendEmail->sendEmail($this->emailData, 2);

        if ($sendEmail->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Usuário cadastrado com sucesso. Acesse sua caixa de e-mail para confirmar o e-mail!</p>";
            $this->result = true;
        } else {
            $this->fromEmail = $sendEmail->getFromEmail();
            $_SESSION['msg'] = "<p style='color: #f00;'>Usuário cadastrado com sucesso.
                Houve um erro ao enviar e-mail de confirmação, entre em contato com {$this->fromEmail} para mais informações.</p>";
            $this->result = true;
        }
    }

    private function contentEmailHtml(): void
    {
        $name = explode(" ", $this->data['name']);
        $this->firstName = $name[0];

        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->data['name'];
        $this->emailData['subject'] = "Confirmar sua conta";
        $this->url = URLADM . "conf-email/index?key=" . $this->data['conf_email'];

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso site!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}'>{$this->url}</a>url<br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa XXX.<br>Você está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";
    }

    private function contentEmailText(): void
    {
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso site!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicanco no link abaixo: \n\n";
        $this->emailData['contentText'] .= $this->url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa XXX.\nVocê está recebendo porque está cadastrado no banco de dados da empresa XXX. Nenhum e-mail enviado pela empresa XXX tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";
    }
}
