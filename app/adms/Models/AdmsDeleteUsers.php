<?php

namespace App\adms\Models;

use App\adms\Models\Helper\AdmsDelete;
use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\Helper\AdmsValEmail;
use App\adms\Models\Helper\AdmsValEmailSingle;
use App\adms\Models\Helper\AdmsValEmptyField;
use App\adms\Models\Helper\AdmsValUserSingle;

/**
 * Editar usuário no banco de dados
 */
class AdmsDeleteUsers
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

    public function deleteUser(int $id): void
    {
        $this->id = (int) $id;

        if ($this->ViewUser()) {
            $deleteUser = new AdmsDelete();
            $deleteUser->exeDelete("adms_users", "WHERE id=:id", "id={$this->id}");

            if ($deleteUser->getResult()) {
                $this->deleteImg();
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

    private function ViewUser(): bool
    {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead(
            "SELECT id, image
                            FROM adms_users                           
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
            return false;
        }
    }

    private function deleteImg(): void
    {
        if ((!empty($this->resultBd[0]['image'])) or ($this->resultBd[0]['image'] != null)) {
            $this->delDirectory = "app/adms/assets/image/users/" . $this->resultBd[0]['id'] . "/";
            $this->delImage = $this->delDirectory . "/" . $this->resultBd[0]['image'];

            if (file_exists($this->delImage)) {
                unlink($this->delImage);
            }

            if (file_exists($this->delDirectory)) {
                rmdir($this->delDirectory);
            }
        }
    }
}
