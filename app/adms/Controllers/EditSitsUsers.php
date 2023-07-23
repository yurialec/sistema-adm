<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsEditSitsUsers;
use Core\ConfigView;

/**
 * Controller da página editar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditSitsUsers
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditSitsUser']))) {
            $this->id = (int) $id;

            $viewSitsUser = new AdmsEditSitsUsers();
            $viewSitsUser->ViewSitsUser($this->id);

            if ($viewSitsUser->getResult()) {
                $this->data['form'] = $viewSitsUser->getResultBd();
                $this->viewEditSitsUser();
            } else {
                $urlRedirect = URLADM . "list-sits-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editSitsUser();
        }
    }

    private function viewEditSitsUser()
    {
        $listSelect = new AdmsEditSitsUsers();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new ConfigView("adms/Views/Situation/EditSitsUser", $this->data);
        $loadView->loadView();
    }

    private function editSitsUser(): void
    {
        if (!empty($this->dataForm['SendEditSitsUser'])) {
            unset($this->dataForm['SendEditSitsUser']);

            $editSitsUser = new AdmsEditSitsUsers();
            $editSitsUser->updateSitsUser($this->dataForm);

            if ($editSitsUser->getResult()) {
                $urlRedirect = URLADM . "view-sits-users/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditSitsUser();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Situação não encontradaASDASD</p>";
            $urlRedirect = URLADM . "list-sits-users/index";
            header("Location: $urlRedirect");
        }
    }
}
