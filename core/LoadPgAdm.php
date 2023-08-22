<?php

namespace Core;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Verificar se existe a classe
 * Carregar a CONTROLLER
 * @author Yuri <yuri.alec@hotmail.com>
 */

class LoadPgAdm
{
    /** @var string $urlController Recebe da URL o nome da controller */
    private string $urlController;
    /** @var string $urlMetodo Recebe da URL o nome do método */
    private string $urlMetodo;
    /** @var string $urlParamentro Recebe da URL o parâmetro */
    private string $urlParameter;
    /** @var string $classLoad Controller que deve ser carregada */
    private string $classLoad;
    /** @var string $urlSlugController Recebe o controller tratada */
    private string $urlSlugController;
    /** @var string $urlSlugMetodo Recebe o metodo tratado */
    private string $urlSlugMetodo;
    /** @var array $listPgPublic */
    private array $listPgPublic;
    /** @var array $listPgPrivate */
    private array $listPgPrivate;

    public function loadingPage(string|null $urlController, string|null $urlMetodo, string|null $urlParameter): void
    {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParameter = $urlParameter;

        $this->pgPublic();

        if (class_exists($this->classLoad)) {
            $this->loadMetodo();
        } else {
            die("Erro 003: Por favor tente novamente. Caso o problema persista, entre
                em contato com o administrador " . EMAILADM);
        }
    }

    private function loadMetodo(): void
    {
        $classLoad = new $this->classLoad();
        if (method_exists($classLoad, $this->urlMetodo)) {
            $classLoad->{$this->urlMetodo}($this->urlParameter);
        } else {
            die("Erro 004: Por favor tente novamente. Caso o problema persista, entre
                em contato com o administrador " . EMAILADM);
        }
    }

    /**
     * Metodo que verifica se a página é publica
     *
     * @return void
     */
    private function pgPublic(): void
    {
        $this->listPgPublic = [
            "Login", "Erro", "Logout", "NewUser",
            "ConfEmail", "NewConfEmail", "RecoverPassword", "UpdatePassword"
        ];

        if (in_array($this->urlController, $this->listPgPublic)) {
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
            $this->urlController;
        } else {
            $this->pgPrivate();
        }
    }

    private function pgPrivate(): void
    {
        $this->listPgPrivate = [
            "Dashboard", "ListUsers", "ViewUsers", "AddUsers",
            "EditUsers", "EditUsersPassword", "EditUsersImage",
            "DeleteUsers", "ViewProfile", "EditProfile", "EditProfilePassword",
            "EditProfileImage", "ListSitsUsers", "ViewSitsUsers",
            "EditSitsUsers", "DeleteSitsUsers", "AddSitsUsers", "ListColors",
            "ViewColor", "EditColor", "DeleteColor", "AddColor",
            "ListConfEmail", "ViewConfEmail", "EditConfEmail", "DeleteConfEmail",
            "EditConfEmailPassword", "AddConfEmail", "ListAccessLevels", "ViewAccessLevel",
            "EditAccessLevel", "EditAccessLevel", "DeleteAccessLevel", "AddAccessLevel",
            "OrderAccessLevel", "ListTypesPgs", "ViewTypesPgs", "EditTypesPgs", "AddTypePg",
            "OrderTypePgs", "DeleteTypesPgs", "ListGroupsPages", "ViewGroupPage",
            "EditGroupPage", "DeleteGroupPage", "AddGroupPage", "OrderGroupPage"
        ];

        if (in_array($this->urlController, $this->listPgPrivate)) {
            $this->verifyLogin();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Página não encontrada</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function verifyLogin(): void
    {
        if ((isset($_SESSION['user_id'])) and (isset($_SESSION['user_name'])) and (isset($_SESSION['user_email']))) {
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Para acessar a página, realize o login</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Converter o valor obtido da URL "view-users" e converter no formato da classe "ViewUsers".
     * Utilizado as funções para converter tudo para minúsculo, converter o traço pelo espaço, converter cada letra da primeira palavra para maiúsculo, retirar os espaços em branco
     *
     * @param string $slugController Nome da classe
     * @return string Retorna a controller "view-users" convertido para o nome da Classe "ViewUsers"
     */
    private function slugController($slugController): string
    {
        $this->urlSlugController = $slugController;
        // Converter para minusculo
        $this->urlSlugController = strtolower($this->urlSlugController);
        // Converter o traco para espaco em braco
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        // Converter a primeira letra de cada palavra para maiusculo
        $this->urlSlugController = ucwords($this->urlSlugController);
        // Retirar espaco em branco  
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);
        return $this->urlSlugController;
    }

    /**
     * Tratar o método
     * Instanciar o método que trata a controller
     * Converter a primeira letra para minusculo
     *
     * @param string $urlSlugMetodo
     * @return string
     */
    private function slugMetodo($urlSlugMetodo): string
    {
        $this->urlSlugMetodo = $this->slugController($urlSlugMetodo);
        //Converter para minusculo a primeira letra
        $this->urlSlugMetodo = lcfirst($this->urlSlugMetodo);
        return $this->urlSlugMetodo;
    }
}
