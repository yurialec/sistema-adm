<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditUsersPassword;
use Core\ConfigView;

/**
 * Controller da página editar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditUsersPassword
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
    public function index(string|int|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditUserPass']))) {
            $this->id = (int) $id;

            $viewUserPass = new AdmsEditUsersPassword();
            $viewUserPass->ViewUser($this->id);

            if ($viewUserPass->getResult()) {
                $this->data['form'] = $viewUserPass->getResultBd();
                $this->viewEditUserPass();
            } else {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editUserPass();
        }
    }

    private function viewEditUserPass()
    {
        $loadView = new ConfigView("adms/Views/Users/EditUserPass", $this->data);
        $loadView->loadView();
    }

    private function editUserPass(): void
    {
        if (!empty($this->dataForm['SendEditUserPass'])) {
            unset($this->dataForm['SendEditUserPass']);

            $editUserPass = new AdmsEditUsersPassword();
            $editUserPass->updateUserPass($this->dataForm);

            if ($editUserPass->getResult()) {
                $urlRedirect = URLADM . "view-users/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditUserPass();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
