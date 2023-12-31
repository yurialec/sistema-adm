<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsLogin;
use Core\ConfigView;

/**
 * Controller da página login
 * @author Yuri <yuri.alec@hotmail.com>
 */
class Login
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
     * Metodo Login
     *
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendLogin'])) {
            $valLogin = new AdmsLogin();
            $valLogin->login($this->dataForm);

            if ($valLogin->getResult()) {
                $urlRedirect = URLADM . "dashboard/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
            }
        }

        $loadView = new ConfigView("adms/Views/Login/Login", $this->data);
        $loadView->loadViewLogin();
    }
}
