<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditAcessLevel;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página editar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditAccessLevel
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditAccessLevel']))) {
            $this->id = (int) $id;

            $viewAcessLevel = new AdmsEditAcessLevel();
            $viewAcessLevel->ViewAcessLevel($this->id);

            if ($viewAcessLevel->getResult()) {
                $this->data['form'] = $viewAcessLevel->getResultBd();
                $this->viewEditAccessLevel();
            } else {
                $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editAccessLevel();
        }
    }

    private function viewEditAccessLevel()
    {
        $button = [
            'list_access_levels' => [
                'menu_controller' => 'list-access-levels',
                'menu_metodo' => 'index'
            ],
            'view_access_level' => [
                'menu_controller' => 'view-access-level',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);
        
        $loadView = new ConfigView("adms/Views/AccessLevels/EditAccessLevel", $this->data);
        $loadView->loadView();
    }

    private function editAccessLevel(): void
    {
        if (!empty($this->dataForm['SendEditAccessLevel'])) {
            unset($this->dataForm['SendEditAccessLevel']);
            
            $editAccessLevel = new AdmsEditAcessLevel();
            $editAccessLevel->update($this->dataForm);

            if ($editAccessLevel->getResult()) {
                $urlRedirect = URLADM . "list-access-levels/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditAccessLevel();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Nível de Acesso não encontado</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }
}
