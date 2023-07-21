<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsRecoverPassword;
use Core\ConfigView;

/**
 * Controller da página recuperar
 * @author Yuri <yuri.alec@hotmail.com>
 */
class RecoverPassword
{
    /**
     * @var array|string|null $data Recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data = [];

    /**
     * $dataForm recebe os dados do formulário
     *
     * @var array
     */
    private array|null $dataForm;

    /**
     * Metodo index
     *
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendRecoverPass'])) {
            unset($this->dataForm['SendRecoverPass']);

            $recoverPass = new AdmsRecoverPassword();
            $recoverPass->recoverPassword($this->dataForm);

            if ($recoverPass->getResult()) {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewRecoverPass();
            }
        } else {
            $this->viewRecoverPass();
        }
    }

    private function viewRecoverPass(): void
    {
        $loadView = new ConfigView("adms/Views/login/RecoverPassword", $this->data);
        $loadView->loadViewLogin();
    }
}
