<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsEditUsersImage;
use Core\ConfigView;

/**
 * Controller da página editar imagens dos usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditUsersImage
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditImageUser']))) {
            $this->id = (int) $id;

            $viewUser = new AdmsEditUsersImage();
            $viewUser->ViewUser($this->id);

            if ($viewUser->getResult()) {
                $this->data['form'] = $viewUser->getResultBd();
                $this->viewEditUserImage();
            } else {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editUserImage();
        }
    }

    private function viewEditUserImage()
    {
        $loadView = new ConfigView("adms/Views/Users/EditUserImage", $this->data);
        $loadView->loadView();
    }

    private function editUserImage(): void
    {
        if (!empty($this->dataForm['SendEditImageUser'])) {
            unset($this->dataForm['SendEditImageUser']);

            $this->dataForm['new_image'] = $_FILES['new_image'] ? $_FILES['new_image'] : null;

            $editUserImage = new AdmsEditUsersImage();
            $editUserImage->update($this->dataForm);

            if ($editUserImage->getResult()) {
                $urlRedirect = URLADM . "view-users/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditUserImage();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
