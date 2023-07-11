<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsUpdatePassword;
use Core\ConfigView;

/**
 * Controller da página editar senha
 * @author Yuri <yuri.alec@hotmail.com>
 */
class UpdatePassword
{
    /** @var string|null $key Recebe os dados da chave para confirmar o cadastro */
    private string|null $key;

    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data = [];

    /** $dataForm recebe os dados do formulário  @var array */
    private array|null $dataForm;

    /** Metodo index @return void */
    public function index(): void
    {
        /** Recebe a chave pela url */
        $this->key = filter_input(INPUT_GET, "key", FILTER_DEFAULT);

        /** Recebe o valor da nova senha */
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->key) and (empty($this->dataForm['SendUpPass']))) {
            $this->validateKey();
        } else {
            $this->updatePassword();
        }
    }

    /** Caso tenha sucesso ao validar a chave, retorna a view @return void */
    private function validateKey(): void
    {
        $valKey = new AdmsUpdatePassword();
        $valKey->valKey($this->key);

        if ($valKey->getResult()) {
            $this->viewUpdatePassword();
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function updatePassword(): void
    {
        if (!empty($this->dataForm['SendUpPass'])) {
            unset($this->dataForm['SendUpPass']);
            $this->dataForm['key'] = $this->key;
            $upPassword = new AdmsUpdatePassword();
            $upPassword->editPassword($this->dataForm);

            if ($upPassword->getResult()) {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            } else {
                $this->viewUpdatePassword();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Necessário confirmar o e-mail, solicite novo link <a href='" . URLADM . "new-conf-email/index'>Clique aqui</a>!<p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewUpdatePassword(): void
    {
        $loadView = new ConfigView("adms/Views/Login/UpdatePassword", $this->data);
        $loadView->loadViewLogin();
    }
}
