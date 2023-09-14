<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsPagination;
use App\adms\Models\Helper\AdmsRead;

/**
 * Listar as permissoes di nivel de acesso do banco de dados
 */
class AdmsListPermission
{
    //Recebe true quando executar com sucesso
    private bool $result;
    //Recebe os registros do banco de dados
    private array|null $resultBd;
    //Recebe o registro do banco de dados referente ao nível de acesso
    private array|null $resultBdLevel;
    //Recebe o número da página
    private int $page;
    //Recebe a quantidade de resgistro que deve retornar do banco de dados 
    private int $limitResult = 15;
    //Recebe a paginação
    private string|null $resultPg;
    //Recebe o número do id do número de acesso
    private int $level;

    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Retorna os registros do banco de dados
     *
     * @return array|null
     */
    public function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * Retorna o registro do banco de dados referente ao nível de acesso
     *
     * @return array|null
     */
    public function getResultBdLevel(): array|null
    {
        return $this->resultBdLevel;
    }

    public function getResultPg(): string|null
    {
        return $this->resultPg;
    }

    public function listPermission(int $page = null, int $level = null): void
    {
        $this->page = (int) $page ? $page : 1;
        $this->level = (int) $level;

        if ($this->viewAccessLevel()) {

            $pagination = new AdmsPagination(URLADM . 'list-permission/index', "?level={$this->level}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination(
                "SELECT COUNT(id) AS num_result
                                    FROM adms_levels_pages
                                    WHERE adms_access_level_id =:adms_access_level_id",
                "adms_access_level_id={$this->level}"
            );
            $this->resultPg = $pagination->getResult();

            $listPermission = new AdmsRead();
            $listPermission->fullRead(
                "SELECT lev_pag.id, lev_pag.permission, lev_pag.order_level_page, lev_pag.adms_access_level_id, lev_pag.adms_page_id,
                                    pag.name_page
                                    FROM adms_levels_pages AS lev_pag
                                    LEFT JOIN adms_pages AS pag ON pag.id = adms_page_id
                                    WHERE lev_pag.adms_access_level_id =:adms_access_level_id
                                    ORDER BY lev_pag.order_level_page ASC
                                    LIMIT :limit OFFSET :offset",
                "adms_access_level_id={$this->level}&limit={$this->limitResult}&offset={$pagination->getOffset()}"
            );

            $this->resultBd = $listPermission->getResult();

            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma permissão para o nível de acesso encontrado!<p>";
                $this->result = false;
            }
        } else {
            // $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma permissão para o nível de acesso encontrado!<p>";
            $this->result = false;
        }
    }

    private function viewAccessLevel(): bool
    {
        $viewAccessLevel = new AdmsRead();
        $viewAccessLevel->fullRead(
            "SELECT name
                FROM adms_access_levels
                WHERE id=:id
                AND order_levels >:order_levels
                LIMIT :limit",
            "id={$this->level}&order_levels=" . $_SESSION['order_levels'] . "&limit=1"
        );

        $this->resultBdLevel = $viewAccessLevel->getResult();

        if ($this->resultBdLevel) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Nível de acesso não encontrado!<p>";
            return false;
        }
    }
}
