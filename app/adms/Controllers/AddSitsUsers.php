<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsAddSitsUsers;
use Core\ConfigView;

/**
 * Controller da página cadastrar nova situação
 * @author Yuri <yuri.alec@hotmail.com>
 */
class AddSitsUsers
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

        if (!empty($this->dataForm['SendAddSitsUser'])) {
            unset($this->dataForm['SendAddSitsUser']);
            $createUser = new AdmsAddSitsUsers();
            $createUser->create($this->dataForm);

            if ($createUser->getResult()) {
                $urlRedirect = URLADM . "list-sits-users/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddSitsUser();
            }
        } else {
            $this->viewAddSitsUser();
        }
    }

    private function viewAddSitsUser()
    {
        $listSelect = new AdmsAddSitsUsers();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new ConfigView("adms/Views/Situation/AddSitsUsers", $this->data);
        $loadView->loadView();
    }
}
