<?php

namespace App\adms\Models;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\Helper\AdmsRead;
use App\adms\Models\Helper\AdmsSlug;
use App\adms\Models\Helper\AdmsUpdate;
use App\adms\Models\helper\AdmsUploadImgRes;
use App\adms\Models\Helper\AdmsValEmptyField;
use App\adms\Models\Helper\AdmsValExtImg;

/**
 * Editar a imagem do perfil do usuário
 */
class AdmsEditProfileImage
{
    //Recebe true quando executar com sucesso
    private bool $result = false;
    //Recebe os registro do banco de dados
    private array $resultBd;
    //Recebe os dados
    private array|null $data;
    //Rcebe os campos que serao removidos da validacao
    private array|null $dataImage;
    //Recebe o slug da imagem
    private string $nameImg;
    /** Diretorio onde sera salvo a imagem @var string */
    private string $directory;
    //Recebe o endereco da imagem que será excluida
    private string $delImg;

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

    public function viewProfile(): bool
    {
        $viewUser = new AdmsRead();
        $viewUser->fullRead(
            "SELECT id, image
            FROM adms_users
            WHERE id=:id
            LIMIT :limit",
            "id=" . $_SESSION['user_id'] . "&limit=1"
        );

        $this->resultBd = $viewUser->getResult();

        if ($this->resultBd) {
            $this->result = true;
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Perfil não encontrado!<p>";
            $this->result = false;
            return false;
        }
    }

    public function update(array $data = null): void
    {
        $this->data = $data;

        $this->dataImage = $this->data['new_image'];
        unset($this->data['new_image']);

        $valEmptyField = new AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            if (!empty($this->dataImage['name'])) {
                $this->valInput();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /** Verificar se existe o usuário @return void */
    private function valInput(): void
    {
        $valExtImg = new AdmsValExtImg();
        $valExtImg->validateExtImg($this->dataImage['type']);

        if ($this->viewProfile() and ($valExtImg->getResult())) {
            $this->upload();
        } else {
            $this->result = false;
        }
    }

    private function upload(): void
    {
        $slugImg = new AdmsSlug();
        $this->nameImg = $slugImg->slug($this->dataImage['name']);

        $this->directory = "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/";

        $uploadImgResize = new AdmsUploadImgRes();
        $uploadImgResize->upload($this->dataImage, $this->directory, $this->nameImg, 300, 300);

        if ($uploadImgResize->getResult()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    /** Alterar Imagem no banco de dados @return void */
    private function edit(): void
    {
        $this->data['image'] = $this->nameImg;
        $this->data['modified'] = date("Y-m-d H:i:s");

        $updateUser = new AdmsUpdate();
        $updateUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id=" . $_SESSION['user_id']);

        if ($updateUser->getResult()) {
            $_SESSION['user_image'] = $this->nameImg;
            $this->deleteImage();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não atualizado com sucesso!</p>";
            $this->result = false;
        }
    }

    private function deleteImage(): void
    {
        if (((!empty($this->resultBd[0]['image'])) or ($this->resultBd[0]['image'] != null)) and ($this->resultBd[0]['image'] != $this->nameImg)) {
            $this->delImg = "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/" . $this->resultBd[0]['image'];
            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }
        }

        $_SESSION['msg'] = "<p style='color: green;'>Imagem editada com sucesso!</p>";
        $this->result = true;
    }
}
