<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsAddUsers;
use App\adms\Models\Helper\AdmsButton;
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
        $listSelect = new AdmsAddUsers();
        $this->data['select'] = $listSelect->listSelect();

        $button = [
            'list_users' => [
                'menu_controller' => 'list-users',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/Users/AddUser", $this->data);
        $loadView->loadView();
    }
}
