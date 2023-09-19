<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsViewConfEmail;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página visualizar Configuração de E-mail
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ViewConfEmail
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data;

    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;

    /**
     * Metodo Visualizar Usuários
     *
     * @return void
     */
    public function index(string|int|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;
            $viewConfEmail = new AdmsViewConfEmail();
            $viewConfEmail->viewConfEmail($this->id);

            if ($viewConfEmail->getResult()) {
                $this->data['viewConfEmail'] = $viewConfEmail->getResultBd();
                $this->viewConfEmail();
            } else {
                $urlRedirect = URLADM . "list-conf-email/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Usuário não encontrado</p>";
            $urlRedirect = URLADM . "list-conf-email/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Carregar View
     *
     * @return void
     */
    public function viewConfEmail(): void
    {
        $button = [
            'list_conf_email' => [
                'menu_controller' => 'list-conf-email',
                'menu_metodo' => 'index'
            ],
            'edit_conf_email' => [
                'menu_controller' => 'edit-conf-email',
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
        
        $loadView = new ConfigView("adms/Views/ConfEmail/ViewConfEmail", $this->data);
        $loadView->loadView();
    }
}
