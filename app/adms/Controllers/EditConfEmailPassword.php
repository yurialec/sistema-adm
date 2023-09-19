<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsEditConfEmailPassword;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página editar Usuários
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditConfEmailPassword
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
    public function index(string|int|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditConfEmailPass']))) {
            $this->id = (int) $id;

            $viewConfEmailPass = new AdmsEditConfEmailPassword();
            $viewConfEmailPass->ViewConfEmail($this->id);

            if ($viewConfEmailPass->getResult()) {
                $this->data['form'] = $viewConfEmailPass->getResultBd();
                $this->viewEditConfEmailPass();
            } else {
                $urlRedirect = URLADM . "list-conf-email/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editConfEmailPass();
        }
    }

    private function viewEditConfEmailPass()
    {
        $button = [
            'list_conf_email' => [
                'menu_controller' => 'list-conf-email',
                'menu_metodo' => 'index'
            ],
            'view_conf_email' => [
                'menu_controller' => 'view-conf-email',
                'menu_metodo' => 'index'
            ],
            'edit_conf_email' => [
                'menu_controller' => 'edit-conf-email',
                'menu_metodo' => 'index'
            ],
            'delete_conf_email' => [
                'menu_controller' => 'delete-conf-email',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/ConfEmail/EditConfEmailPassword", $this->data);
        $loadView->loadView();
    }

    private function editConfEmailPass(): void
    {
        if (!empty($this->dataForm['SendEditConfEmailPass'])) {
            unset($this->dataForm['SendEditConfEmailPass']);

            $editUserPass = new AdmsEditConfEmailPassword();
            $editUserPass->updateConfEmailPass($this->dataForm);

            if ($editUserPass->getResult()) {
                $urlRedirect = URLADM . "view-conf-email/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditConfEmailPass();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Configuração não encontrada</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
