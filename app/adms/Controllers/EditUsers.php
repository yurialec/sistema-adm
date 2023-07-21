<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsEditUsers;
use Core\ConfigView;

/**
 * Controller da página editar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditUsers
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data = [];

    /** $dataForm recebe os dados do formulário @var array */
    private array|null $dataForm;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Login
     *
     * @return void
     */
    public function index(string|int|null $id): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditUser']))) {
            $this->id = (int) $id;

            $viewUser = new AdmsEditUsers();
            $viewUser->ViewUser($this->id);

            if ($viewUser->getResult()) {
                $this->data['form'] = $viewUser->getResultBd();
                $this->viewEditUser();
            } else {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editUser();
        }
    }

    private function viewEditUser()
    {
        $listSelect = new AdmsEditUsers();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new ConfigView("adms/Views/Users/EditUser", $this->data);
        $loadView->loadView();
    }

    private function editUser(): void
    {
        if (!empty($this->dataForm['SendEditUser'])) {
            unset($this->dataForm['SendEditUser']);
            $editUser = new AdmsEditUsers();
            $editUser->updateUser($this->dataForm);

            if ($editUser->getResult()) {
                $urlRedirect = URLADM . "view-users/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditUser();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
