<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsNewConfEmail;
use Core\ConfigView;

/**
 * Controller para receber novo link para confirmar e-mail
 * http://localhost/projetos/adm/new-conf-email/index
 * @author Yuri <yuri.alec@hotmail.com>
 */
class NewConfEmail
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

        if (!empty($this->dataForm['SendNewConfEmail'])) {
            unset($this->dataForm['SendNewConfEmail']);
            $newConfEmail = new AdmsNewConfEmail();
            $newConfEmail->newConfEmail($this->dataForm);

            if ($newConfEmail->getResult()) {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewNewConfEmail();
            }
        } else {
            $this->viewNewConfEmail();
        }
    }

    private function viewNewConfEmail(): void
    {
        $loadView = new ConfigView("Adms/Views/Login/NewConfEmail", $this->data);
        $loadView->loadViewLogin();
    }
}
