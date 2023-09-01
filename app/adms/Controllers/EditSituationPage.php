<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditSituationPage;
use Core\ConfigView;

/**
 * Controller da página editar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditSituationPage
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditSituationPage']))) {
            $this->id = (int) $id;

            $viewSituationPage = new AdmsEditSituationPage();
            $viewSituationPage->viewSituationPage($this->id);

            if ($viewSituationPage->getResult()) {
                $this->data['form'] = $viewSituationPage->getResultBd();
                $this->viewEditSitsPg();
            } else {
                $urlRedirect = URLADM . "list-situation-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editSituationPage();
        }
    }

    private function viewEditSitsPg()
    {
        $listSelect = new AdmsEditSituationPage();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new ConfigView("adms/Views/SituationPages/EditSituationPage", $this->data);
        $loadView->loadView();
    }

    private function editSituationPage(): void
    {
        if (!empty($this->dataForm['SendEditSituationPage'])) {
            unset($this->dataForm['SendEditSituationPage']);

            $editSitsPg = new AdmsEditSituationPage();
            $editSitsPg->update($this->dataForm);

            if ($editSitsPg->getResult()) {
                $urlRedirect = URLADM . "view-situation-page/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditSitsPg();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Situação da Página não encontrado</p>";
            $urlRedirect = URLADM . "list-situation-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
