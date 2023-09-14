<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsCreate;
use App\adms\Models\Helper\AdmsRead;

/**
 * Instanciar a classe responsavel em sincronizar o nicel de acesso e as paginas
 */
class AdmsSyncPagesLevels
{
    /** Recebe as informacoes que devem ser salvas no banco de dados @var array|null */
    private array|null $dataLevelPage;

    //Recebe true quando executar com sucesso
    private bool $result = false;

    //Recebe os registro do banco de dados
    private array $resultBd;

    //Retorna os niveis de acesso do banco de dados
    private array $resultBdLevels;

    //Retorna as paginas do banco de dados
    private array $resultBdPages;

    //Retorna as paginas do banco de dados
    private array $resultBdLevelPage;

    //Retorna as paginas do banco de dados
    private array $resultBdLastOrder;

    /** Recebe o id do nível de acesso @var integer|null */
    private string|int|null $levelId;

    /** Recebe o tipo de permissao (publica ou privada) @var integer|null */
    private string|int|null $publish;

    /** Recebe o id da pagina @var integer|null */
    private string|int|null $pageId;

    /** Retorna true caso tenha sucesso @return boolean */
    public function getResult(): bool
    {
        return $this->result;
    }

    /** Retorna os registros do banco de dados @return array|null */
    public function getResultBd(): array|null
    {
        return $this->resultBdLevels;
    }

    /**
     * Recuperar os níveis de acesso no BD
     *
     * @return void
     */
    public function syncPagesLevels(): void
    {
        $listLevels = new AdmsRead();
        $listLevels->fullRead("SELECT id FROM adms_access_levels");

        $this->resultBdLevels = $listLevels->getResult();

        if ($this->resultBdLevels) {
            $this->listPages();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nível de Acesso não encontrado!<p>";
            $this->result = false;
        }
    }

    /**
     * Recuperar as páginas no BD
     *
     * @return void
     */
    private function listPages(): void
    {
        $listPages = new AdmsRead();
        $listPages->fullRead("SELECT id, publish FROM adms_pages");

        $this->resultBdPages = $listPages->getResult();

        if ($this->resultBdPages) {
            $this->readLevels();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma Página encontrada!<p>";
            $this->result = false;
        }
    }

    /**
     * Ler os niveis de acesso
     *
     * @return void
     */
    private function readLevels(): void
    {
        foreach ($this->resultBdLevels as $level) {
            extract($level);
            $this->levelId = $id;
            $this->readPages();
        }
    }

    /**
     * Ler as paginas
     *
     * @return void
     */
    private function readPages(): void
    {
        foreach ($this->resultBdPages as $page) {
            // var_dump($page);
            extract($page);
            // echo "ID da página: $id <br>";
            $this->pageId = $id;
            $this->publish = $publish;
            $this->seacrhLevelPage();
        }
    }

    private function seacrhLevelPage(): void
    {
        $listLevelPage = new AdmsRead();
        $listLevelPage->fullRead(
            "SELECT id
                FROM adms_levels_pages
                WHERE adms_access_level_id =:adms_access_level_id
                AND adms_page_id =:adms_page_id",
            "adms_access_level_id={$this->levelId}&adms_page_id={$this->pageId}"
        );

        $this->resultBdLevelPage = $listLevelPage->getResult();

        if ($this->resultBdLevelPage) {
            $_SESSION['msg'] = "<p class='alert-success'>Todas as permissões estão sincronizadas!<p>";
            $this->result = true;
        } else {
            $this->addLevelPermission();
        }
    }

    /**
     * Cadastrar na tabbela "adms_levels_pages"
     *
     * @return void
     */
    private function addLevelPermission(): void
    {
        $this->searchLastOrder();
        $this->dataLevelPage['permission'] = (($this->levelId == 1) or ($this->publish == 1)) ? 1 : 2;
        $this->dataLevelPage['order_level_page'] = $this->resultBdLastOrder[0]['order_level_page'] + 1;
        $this->dataLevelPage['adms_access_level_id'] = $this->levelId;
        $this->dataLevelPage['adms_page_id'] = $this->pageId;
        $this->dataLevelPage['created'] = date("Y-m-d H:i:s");

        $addAccessLevel = new AdmsCreate;
        $addAccessLevel->exeCreate("adms_levels_pages", $this->dataLevelPage);

        if ($addAccessLevel->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Permissões sincronizadas com sucesso!<p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Não foi possível realizar sincronização!<p>";
            $this->result = false;
        }
    }

    /**
     * Verificar se ha pagina esta cadastrada para o nivel de acesso na tabela "adms_levels_pages"
     *
     * @return void
     */
    private function searchLastOrder(): void
    {
        $viewLastOrder = new AdmsRead();
        $viewLastOrder->fullRead(
            "SELECT order_level_page, adms_access_level_id
                                    FROM adms_levels_pages
                                    WHERE adms_access_level_id =:adms_access_level_id
                                    ORDER BY order_level_page DESC
                                    LIMIT :limit",
            "adms_access_level_id={$this->levelId}&limit=1"
        );

        $this->resultBdLastOrder = $viewLastOrder->getResult();

        if (!$this->resultBdLastOrder) {
            $this->resultBdLastOrder[0]['order_level_page'] = 0;
        }
    }
}
