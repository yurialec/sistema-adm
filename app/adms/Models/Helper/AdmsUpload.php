<?php

namespace App\adms\Models\Helper;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Classe generica para upload
 */
class AdmsUpload
{
    /** DIretorio onde sera salvo @var string */
    private string $directory;
    /** nome do arquvo @var string */
    private string $tmpName;
    /** Undocumented variable @var string */
    private string $name;
    /** Retorna true ou false  @var boolean */
    private bool $result;

    /** Caso o processo seja executado com sucesso, retorna true @return boolean */
    public function getResult(): bool
    {
        return $this->result;
    }

    public function upload(string $directory, string $tmpName, string $name): void
    {
        $this->directory = $directory;
        $this->tmpName = $tmpName;
        $this->name = $name;

        if ($this->valDirectory()) {
            $this->uploadFile();
        } else {
            $this->result = false;
        }
    }

    private function valDirectory(): bool
    {
        if ((!file_exists($this->directory)) and (!is_dir($this->directory))) {
            mkdir($this->directory, 0755);
            if ((!file_exists($this->directory)) and (!is_dir($this->directory))) {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    private function uploadFile(): void
    {
        if (move_uploaded_file($this->tmpName, $this->directory . $this->name)) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }
}
