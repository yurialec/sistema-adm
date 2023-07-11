<?php

namespace Core;

/**
 * Carregar as páginas da view
 */
class ConfigView
{
    public function __construct(private string $nameView, private string|null|array $data)
    {
    }

    /**
     * Carrega a VIEW login
     * Verificar se o arquivo existe, e carregar caso exista, não existindo apresenta mensagem de erro
     *
     * @return void
     */
    public function loadViewLogin(): void
    {
        if (file_exists('app/' . $this->nameView . '.php')) {
            include 'app/adms/Views/Include/Head.php';
            include 'app/' . $this->nameView . '.php';
            include 'app/adms/Views/Include/Footer.php';
        } else {
            die("Erro 005: Por favor tente novamente. Caso o problema persista, entre
                em contato com o administrador " . EMAILADM);
        }
    }

    public function loadView(): void
    {
        if (file_exists('app/' . $this->nameView . '.php')) {
            include 'app/adms/Views/Include/Head.php';
            include 'app/adms/Views/Include/Menu.php';
            include 'app/' . $this->nameView . '.php';
            include 'app/adms/Views/Include/Footer.php';
        } else {
            die("Erro 002: Por favor tente novamente. Caso o problema persista, entre
                em contato com o administrador " . EMAILADM);
        }
    }
}
