<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsDelete;
use App\adms\Models\Helper\AdmsRead;

/**
 * Editar usuário no banco de dados
 */
class AdmsDeleteColor
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    /** Recebe o id do registro pela url @var integer|null */
    private string|int|null $id;
    /** Retorna array com os registros do banco de dados @var array */
    private array $resultBd;
    /** Recebe o endereco para excluir o diretorio da imagem @var string */
    private string $delDirectory;
    /** Recebe o endereco para excluir a imagem @var string */
    private string $delImage;

    /** Retorna true caso tenha sucesso @return boolean */
    public function getResult(): bool
    {
        return $this->result;
    }

    public function deleteColor(int $id): void
    {
        $this->id = (int) $id;

        if (($this->viewColor()) and ($this->checkColorUsed())) {
            $deleteUser = new AdmsDelete();
            $deleteUser->exeDelete("adms_colors", "WHERE id=:id", "id={$this->id}");

            if ($deleteUser->getResult()) {
                $_SESSION['msg'] = "<p style='color: #008000;'>Registro excluido com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro ao excluir registro!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    private function ViewColor(): bool
    {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead(
            "SELECT id
                            FROM adms_colors                           
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Cor não encontrada!</p>";
            return false;
        }
    }

    /**
     * Metodo verifica se tem situação cadastrados usando a cor a ser excluida, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteColor
     * @return boolean
     */
    private function checkColorUsed(): bool
    {
        $viewColorUsed = new \App\adms\Models\helper\AdmsRead();
        $viewColorUsed->fullRead("SELECT id FROM adms_sits_users WHERE adms_color_id =:adms_color_id LIMIT :limit", "adms_color_id={$this->id}&limit=1");
        if ($viewColorUsed->getResult()) {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Cor não pode ser apagada, há situação cadastrada com essa cor!</p>";
            return false;
        } else {
            return true;
        }
    }
}
