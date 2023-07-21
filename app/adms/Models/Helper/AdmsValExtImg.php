<?php

namespace App\adms\Models\Helper;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**Validar a extencao da imagem*/
class AdmsValExtImg
{
    /** Tipo de MIME @var string */
    private string $mimeType;
    /** Retorna true caso a operacao seja executada com sucesso @var boolean */
    private bool $result;

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    /** Validar a extensap da imagem @param string $mimeType @return void */
    public function validateExtImg(string $mimeType): void
    {
        $this->mimeType = $mimeType;

        switch ($this->mimeType) {
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->result = true;
                break;
            case 'image/png':
            case 'image/x-png':
                $this->result = true;
                break;
            default:
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecinar imagem JPEG pu PNG!</p>";
                $this->result = false;
        }
    }
}
