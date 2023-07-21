<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsEditProfilePassword;
use Core\ConfigView;

/**
 * Controller da página editar senha perfil
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditProfilePassword
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data = [];

    /** $dataForm recebe os dados do formulário @var array */
    private array|null $dataForm;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendEditProfPass'])) {
            $this->editProfilePass();
        } else {
            $viewProfilePass = new AdmsEditProfilePassword();
            $viewProfilePass->viewProfile();

            if ($viewProfilePass->getResult()) {
                $this->data['form'] = $viewProfilePass->getResultBd();
                $this->viewEditProPass();
            } else {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }
        }
    }

    private function viewEditProPass(): void
    {
        $loadView = new ConfigView("adms/Views/Users/EditProfilePassword", $this->data);
        $loadView->loadView();
    }

    private function editProfilePass(): void
    {
        if (!empty($this->dataForm['SendEditProfPass'])) {
            unset($this->dataForm['SendEditProfPass']);
            $editProfilePass = new AdmsEditProfilePassword();
            $editProfilePass->updateProfilePass($this->dataForm);

            if ($editProfilePass->getResult()) {
                $urlRedirect = URLADM . "view-profile/index/";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditProPass();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Perfil não encontrado</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
