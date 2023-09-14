<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\Helper\AdmsValEmail;
use App\adms\Models\Helper\AdmsValEmailSingle;
use App\adms\Models\Helper\AdmsValEmptyField;
use App\adms\Models\Helper\AdmsValUserSingle;

/**
 * Editar usuário no banco de dados
 */
class AdmsEditPage
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array $resultBd;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;
    //Recebe os dados
    private array|null $data;
    //Rcebe os campos que serão removidos da validação
    private array|null $dataExitVal;
    //
    private array $listRecordEdit;

    /** Retorna true caso tenha sucesso @return boolean */
    public function getResult(): bool
    {
        return $this->result;
    }

    /** Retorna os registros do banco de dados @return array|null */
    public function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function view(int $id): void
    {
        $this->id = $id;

        $viewPage = new AdmsRead();
        $viewPage->fullRead(
            "SELECT ap.id, ap.controller, ap.metodo, ap.menu_controller, ap.menu_metodo,
                    ap.name_page, ap.publish, ap.icon, ap.obs,
                    ap.adms_sits_pgs_id, ap.adms_types_pgs_id, ap.adms_groups_pgs_id,
                    asp.name AS situation_pg_name,
                    atp.name AS type_pg_name,
                    agp.name AS group_pg_name
            FROM adms_pages AS ap
            LEFT JOIN adms_sits_pgs AS asp
            ON asp.id = ap.adms_sits_pgs_id
            LEFT JOIN adms_types_pgs AS atp
            ON atp.id = ap.adms_types_pgs_id
            LEFT JOIN adms_groups_pgs AS agp
            ON agp.id = ap.adms_groups_pgs_id
            WHERE ap.id=:id
            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewPage->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Página não encontrado!<p>";
            $this->result = false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $this->dataExitVal['icon'] = $this->data['icon'];
        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['icon'], $this->data['obs']);

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->edit();
            $this->result = true;
        } else {
            $this->result = false;
        }
    }

    private function edit(): void
    {
        $this->data['icon'] = $this->dataExitVal['icon'];
        $this->data['obs'] = $this->dataExitVal['obs'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $updatePage = new AdmsUpdate();

        $updatePage->exeUpdate("adms_pages", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updatePage->getResult()) {
            $_SESSION['msg'] = "<p style='color: #008000;'>Registro atualizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao atualizar registro</p>";
            $this->result = false;
        }
    }

    public function listSelect(): array
    {
        $list = new AdmsRead();

        $list->fullRead("SELECT id AS id_sit_pg, name AS name_sit_pg FROM adms_sits_pgs ORDER BY name ASC");
        $records['situation'] = $list->getResult();

        $list->fullRead("SELECT id id_type, type, name name_type FROM adms_types_pgs ORDER BY name ASC");
        $records['type_page'] = $list->getResult();

        $list->fullRead("SELECT id id_group, name name_group FROM adms_groups_pgs ORDER BY name ASC");
        $records['group_page'] = $list->getResult();

        $this->listRecordEdit = ['situation' => $records['situation'], 'type_page' => $records['type_page'], 'group_page' => $records['group_page']];

        return $this->listRecordEdit;
    }
}
