<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsNewUser;
use Core\ConfigView;

/**
 * Controller da página novo Usuário
 * @author Yuri <yuri.alec@hotmail.com>
 */
class NewUser
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

        if (!empty($this->dataForm['SendNewUser'])) {
            unset($this->dataForm['SendNewUser']);
            $createNewUser = new AdmsNewUser();
            $createNewUser->create($this->dataForm);

            if ($createNewUser->getResult()) {
                $urlRedirect = URLADM;
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->ViewNewUser();
            }
        } else {
            $this->ViewNewUser();
        }
    }

    private function ViewNewUser()
    {
        $loadView = new ConfigView("adms/Views/Login/NewUser", $this->data);
        $loadView->loadViewLogin();
    }
}
