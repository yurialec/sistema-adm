<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditTypesPgs;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página editar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditTypesPgs
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditTypePage']))) {
            $this->id = (int) $id;

            $viewTypesPgs = new AdmsEditTypesPgs();
            $viewTypesPgs->ViewTypesPgs($this->id);

            if ($viewTypesPgs->getResult()) {
                $this->data['form'] = $viewTypesPgs->getResultBd();
                $this->viewEditUser();
            } else {
                $urlRedirect = URLADM . "list-types-pgs/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->edit();
        }
    }

    private function viewEditUser()
    {
        $button = [
            'list_types_pgs' => [
                'menu_controller' => 'list-types-pgs',
                'menu_metodo' => 'index'
            ],
            'view_types_pgs' => [
                'menu_controller' => 'view-types-pgs',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);
        
        $loadView = new ConfigView("adms/Views/TypesPages/EditTypesPages", $this->data);
        $loadView->loadView();
    }

    private function edit(): void
    {
        if (!empty($this->dataForm['SendEditTypePage'])) {
            unset($this->dataForm['SendEditTypePage']);

            $editTypePg = new AdmsEditTypesPgs();
            $editTypePg->update($this->dataForm);

            if ($editTypePg->getResult()) {
                $urlRedirect = URLADM . "list-types-pgs/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditUser();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Tipo de Página não encontrada</p>";
            $urlRedirect = URLADM . "list-types-pgs/index";
            header("Location: $urlRedirect");
        }
    }
}
