<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditConfEmail;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página editar Cores
 * @author Yuri <yuri.alec@hotmail.com>
 */
class EditConfEmail
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

        if ((!empty($id)) and (empty($this->dataForm['SendEditConfEMail']))) {
            $this->id = (int) $id;

            $viewConfEmail = new AdmsEditConfEmail();
            $viewConfEmail->viewConfEmail($this->id);

            if ($viewConfEmail->getResult()) {
                $this->data['form'] = $viewConfEmail->getResultBd();
                $this->viewEditConfEMail();
            } else {
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editConfEmail();
        }
    }

    private function viewEditConfEMail()
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
            'edit_conf_email_password' => [
                'menu_controller' => 'edit-conf-email-password',
                'menu_metodo' => 'index'
            ],
            'delete_conf_email' => [
                'menu_controller' => 'delete-conf-email',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/ConfEmail/EditConfEmail", $this->data);
        $loadView->loadView();
    }

    private function editConfEmail(): void
    {
        if (!empty($this->dataForm['SendEditConfEMail'])) {
            unset($this->dataForm['SendEditConfEMail']);

            $editColor = new AdmsEditConfEmail();
            $editColor->updateConfEmail($this->dataForm);

            if ($editColor->getResult()) {
                $urlRedirect = URLADM . "view-conf-email/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditConfEMail();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Configuração não encontrada</p>";
            $urlRedirect = URLADM . "list-conf-email/index";
            header("Location: $urlRedirect");
        }
    }
}
