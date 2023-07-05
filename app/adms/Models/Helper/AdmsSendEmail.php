<?php

namespace App\adms\Models\Helper;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Classe genérica para enviar e-mail
 */
class AdmsSendEmail
{
    // receber as informações do conteudo do e-mail
    private array $data;
    //recebe true quando for executado com suecesso
    private bool $result;
    //Receber credenciais do email
    private array $dataInfoEmail;
    //recebe o email do remetente
    private string $fromEmail = EMAILADM;
    //Recebe os registro do banco de dados
    private $resultDb;
    //Recebe o id do e-mail que será utilizado
    private int $optionConfEmail;

    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Retorna o email do remetente
     *
     * @return void
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function sendEmail(array $data, int $optinConfEmail): void
    {
        $this->optionConfEmail = $optinConfEmail;
        $this->data = $data;

        $this->infoPhpMailer();
    }

    private function infoPhpMailer(): void
    {
        $confEmail = new AdmsRead();
        $confEmail->fullRead("SELECT title, name, email, host, username, password, smtp, port
                                FROM adms_confs_emails WHERE id =:id LIMIT :limit", "id={$this->optionConfEmail}&limit=1");

        $this->resultDb = $confEmail->getResult();
        if ($this->resultDb) {

            $this->dataInfoEmail['host'] = $this->resultDb[0]['host'];
            $this->dataInfoEmail['fromEmail'] = $this->resultDb[0]['email'];
            $this->fromEmail = $this->dataInfoEmail['fromEmail'];
            $this->dataInfoEmail['fromName'] = $this->resultDb[0]['name'];
            $this->dataInfoEmail['userName'] = $this->resultDb[0]['username'];
            $this->dataInfoEmail['password'] = $this->resultDb[0]['password'];
            $this->dataInfoEmail['smtp'] = $this->resultDb[0]['smtp'];
            $this->dataInfoEmail['port'] = $this->resultDb[0]['port'];

            $this->sendEmailPhpMailer();
        } else {
            $this->result = false;
        }
    }

    private function sendEmailPhpMailer(): void
    {
        $mail = new PHPMailer(true);

        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = $this->dataInfoEmail['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->dataInfoEmail['userName'];
            $mail->Password   = $this->dataInfoEmail['password'];
            $mail->SMTPSecure = $this->dataInfoEmail['smtp'];
            $mail->Port       = $this->dataInfoEmail['port'];

            $mail->setFrom($this->dataInfoEmail['fromEmail'], $this->dataInfoEmail['fromName']);
            $mail->addAddress($this->data['toEmail'], $this->data['toName']);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $this->data['subject'];
            $mail->Body    = $this->data['contentHtml'];
            $mail->AltBody = $this->data['contentText'];

            $mail->send();

            $this->result = true;
        } catch (Exception $err) {
            $this->result = false;
        }
    }
}
