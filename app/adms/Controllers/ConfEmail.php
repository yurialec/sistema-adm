<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsConfEmail;
use Core\ConfigView;

/**
 * Controller para confirmar e-mail
 * @author Yuri <yuri.alec@hotmail.com>
 */
class ConfEmail
{
    /**
     * @var string|null $key Recebe os dados da chave para confirmar o cadastro
     */
    private string|null $key;

    /**
     * @var array|string|null $data Recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data;

    /**
     * Metodo index
     *
     * @return void
     */
    public function index(): void
    {
        $this->key = filter_input(INPUT_GET, "key", FILTER_DEFAULT);

        if (!empty($this->key)) {
            $this->valKey();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! Necessário confirmar o e-mail, solicite novo link <a href='" . URLADM . "new-conf-email/index'>Clique aqui</a>!<p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function valKey(): void
    {
        $confEmail = new AdmsConfEmail();
        $confEmail->confEmail($this->key);

        if ($confEmail->getResult()) {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        } else {
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
