<?php

namespace App\adms\Models\Helper;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Classe genérica para exibir botoes
 */
class AdmsButton
{
    /** Registros do banco de dados @var array|null */
    private array|null $result;
    /** Recebe o array de dados @var array|null */
    private array|null $data;

    /**
     * @return array Retorna o array de dados
     */
    function getResult(): array|null
    {
        return $this->result;
    }

    public function buttonPermission(array|null $data): array|null
    {
        $this->data = $data;

        foreach ($this->data as $key => $button) {
            extract($button);

            $viewButton = new AdmsRead;
            $viewButton->fullRead(
                "SELECT pag.id
                            FROM adms_pages pag
                            INNER JOIN adms_levels_pages AS lev_pag ON lev_pag.adms_page_id=pag.id
                            WHERE pag.menu_controller =:menu_controller
                            AND pag.menu_metodo =:menu_metodo
                            AND lev_pag.permission = 1
                            AND lev_pag.adms_access_level_id =:adms_access_level_id
                            LIMIT :limit",
                "menu_controller=$menu_controller&menu_metodo=$menu_metodo&adms_access_level_id=" . $_SESSION['adms_access_level_id'] . "&limit=1"
            );

            if ($viewButton->getResult()) {
                $this->result[$key] = true;
            } else {
                $this->result[$key] = false;
            }
        }

        return $this->result;
    }
}
