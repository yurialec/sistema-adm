<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsViewProfile;
use Core\ConfigView;

/**
 * Controller da página visualizar perfil
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ViewProfile
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data;

    /**
     * Metodo Visualizar Usuários
     *
     * @return void
     */
    public function index(): void
    {
        $viewProfile = new AdmsViewProfile();
        $viewProfile->viewProfile();
        
        if ($viewProfile->getResult()) {
            $this->data['viewProfile'] = $viewProfile->getResultBd();
            $this->loadViewProfile();
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Carregar View
     *
     * @return void
     */
    public function loadViewProfile(): void
    {
        $loadView = new ConfigView("adms/Views/Users/viewProfile", $this->data);
        $loadView->loadView();
    }
}
