<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsSyncPagesLevels;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Controller SyncPagesLevels
 * @author Yuri <yuri.alec@hotmail.com>
 */
class SyncPagesLevels
{
    /**
     * Metodo SyncPagesLevels
     * Instanciar a classe responsavel em sincronizar o nicel de acesso e as paginas
     * @return void
     */
    public function index(): void
    {
        $syncPageLevels = new AdmsSyncPagesLevels();
        $syncPageLevels->syncPagesLevels();

        $urlRedirect = URLADM . "list-access-levels/index";
        header("Location: $urlRedirect");
    }
}
