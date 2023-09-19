<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditGroupPage;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página editar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditGroupPage
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditGroupPage']))) {
            $this->id = (int) $id;

            $viewGroupPage = new AdmsEditGroupPage;
            $viewGroupPage->viewGroupPage($this->id);

            if ($viewGroupPage->getResult()) {
                $this->data['form'] = $viewGroupPage->getResultBd();
                $this->viewEditGroupPage();
            } else {
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->edit();
        }
    }

    private function viewEditGroupPage()
    {
        $button = [
            'list_groups_pages' => [
                'menu_controller' => 'list-groups-pages',
                'menu_metodo' => 'index'
            ],
            'view_page' => [
                'menu_controller' => 'view-page',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/GroupPages/EditGroupPages", $this->data);
        $loadView->loadView();
    }

    private function edit(): void
    {
        if (!empty($this->dataForm['SendEditGroupPage'])) {
            unset($this->dataForm['SendEditGroupPage']);

            $editTypePg = new AdmsEditGroupPage;
            $editTypePg->update($this->dataForm);

            if ($editTypePg->getResult()) {
                $urlRedirect = URLADM . "list-groups-pages/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditGroupPage();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Grupo de Página não encontrada</p>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
