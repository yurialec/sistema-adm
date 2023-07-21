<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsEditProfileImage;
use Core\ConfigView;

/**
 * Controller da página editar imagem do perfil
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditProfileImage
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

        if (!empty($this->dataForm['SendEditProfImg'])) {
            $this->editProfImage();
        } else {

            $viewProfImg = new AdmsEditProfileImage();
            $viewProfImg->viewProfile();

            if ($viewProfImg->getResult()) {
                $this->data['form'] = $viewProfImg->getResultBd();
                $this->viewEditProfileImg();
            } else {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }
        }
    }

    private function viewEditProfileImg(): void
    {
        $loadView = new ConfigView("adms/Views/Users/EditProfileImg", $this->data);
        $loadView->loadView();
    }

    private function editProfImage(): void
    {
        if (!empty($this->dataForm['SendEditProfImg'])) {
            unset($this->dataForm['SendEditProfImg']);

            $this->dataForm['new_image'] = $_FILES['new_image'] ? $_FILES['new_image'] : null;

            $editProfileImg = new AdmsEditProfileImage();
            $editProfileImg->update($this->dataForm);

            if ($editProfileImg->getResult()) {
                $urlRedirect = URLADM . "view-profile/index/";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditProfileImg();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Perfil não encontrado</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
