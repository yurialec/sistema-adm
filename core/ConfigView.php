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

    public function loadView(): void
    {
        if (file_exists('app/' . $this->nameView . '.php')) {
            include 'app/adms/Views/Include/head.php';
            include 'app/' . $this->nameView . '.php';
            include 'app/adms/Views/Include/footer.php';
        } else {
            die("Erro 002: Por favor tente novamente. Caso o problema persista, entre
                em contato com o administrador " . EMAILADM);
        }
    }
}
