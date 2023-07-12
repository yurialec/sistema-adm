<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsAddUsers;
use Core\ConfigView;

/**
 * Controller da página cadastrar novo Usuário
 * @author Yuri <yuri.alec@hotmail.com>
 */
class AddUsers
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

        if (!empty($this->dataForm['SendAddUser'])) {
            unset($this->dataForm['SendAddUser']);
            $createUser = new AdmsAddUsers();
            $createUser->create($this->dataForm);

            if ($createUser->getResult()) {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddUser();
            }
        } else {
            $this->viewAddUser();
        }
    }

    private function viewAddUser()
    {
        $loadView = new ConfigView("adms/Views/Users/AddUser", $this->data);
        $loadView->loadView();
    }
}