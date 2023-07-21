<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsEditProfile;
use Core\ConfigView;

/**
 * Controller da página editar perfil do usuário
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditProfile
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

        if (!empty($this->dataForm['SendEditProfile'])) {
            $this->editProfile();
        } else {
            $viewProfile = new AdmsEditProfile();
            $viewProfile->viewProfile();

            if ($viewProfile->getResult()) {
                $this->data['form'] = $viewProfile->getResultBd();
                $this->viewEditProfile();
            } else {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }
        }
    }

    private function viewEditProfile(): void
    {
        $loadView = new ConfigView("adms/Views/Users/EditProfile", $this->data);
        $loadView->loadView();
    }

    private function editProfile(): void
    {
        if (!empty($this->dataForm['SendEditProfile'])) {
            unset($this->dataForm['SendEditProfile']);
            $editProfile = new AdmsEditProfile();
            $editProfile->updateProfile($this->dataForm);

            if ($editProfile->getResult()) {
                $urlRedirect = URLADM . "view-profile/index/";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditProfile();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Perfil não encontrado</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
