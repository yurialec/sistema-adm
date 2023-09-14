<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditPage;
use Core\ConfigView;

/**
 * Controller da página editar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditPage
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
        
        if ((!empty($id)) and (empty($this->dataForm['SendEditPage']))) {
            $this->id = (int) $id;

            $viewPage = new AdmsEditPage();
            $viewPage->view($this->id);

            if ($viewPage->getResult()) {
                $this->data['form'] = $viewPage->getResultBd();
                $this->viewEditPg();
            } else {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editSituationPage();
        }
    }

    private function viewEditPg(): void
    {
        $listSelect = new AdmsEditPage();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new ConfigView("adms/Views/Pages/EditPage", $this->data);
        $loadView->loadView();
    }

    private function editSituationPage(): void
    {
        if (!empty($this->dataForm['SendEditPage'])) {
            unset($this->dataForm['SendEditPage']);

            $editSitsPg = new AdmsEditPage();
            $editSitsPg->update($this->dataForm);

            if ($editSitsPg->getResult()) {
                $urlRedirect = URLADM . "view-page/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditPg();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Página não encontrado</p>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
