<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditColor;
use Core\ConfigView;

/**
 * Controller da página editar Cores
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditColor
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditColor']))) {
            $this->id = (int) $id;

            $viewColor = new AdmsEditColor();
            $viewColor->ViewColor($this->id);

            if ($viewColor->getResult()) {
                $this->data['form'] = $viewColor->getResultBd();
                $this->viewEditColor();
            } else {
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editColor();
        }
    }

    private function viewEditColor()
    {
        $loadView = new ConfigView("adms/Views/Colors/EditColor", $this->data);
        $loadView->loadView();
    }

    private function editColor(): void
    {
        if (!empty($this->dataForm['SendEditColor'])) {
            unset($this->dataForm['SendEditColor']);

            $editColor = new AdmsEditColor();
            $editColor->updateColor($this->dataForm);

            if ($editColor->getResult()) {
                $urlRedirect = URLADM . "view-color/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditColor();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
