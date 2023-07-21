<?php

namespace App\adms\Models\Helper;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

/**
 * Classe genérica para validar a senha
 */
class AdmsValPassword
{
    private string $password;
    private bool $result;

    /**
     * Retorna true quando executar com sucesso
     *
     * @return boolean
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    public function validatePassword(string $password): void
    {
        $this->password = $password;

        if (stristr($this->password, "'")) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Caracter( ' ) utilizado na senha inválido!</p>";
            $this->result =  false;
        } else {
            if (stristr($this->password, " ")) {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Proibido utilizar espaço em branco na senha!</p>";
                $this->result =  false;
            } else {
                $this->valExtensionPassword();
            }
        }
    }

    private function valExtensionPassword(): void
    {
        if (strlen($this->password) < 6) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: A senha deve conter no mínimo 6 caracteres!</p>";
            $this->result =  false;
        } else {
            $this->valValuePassword();
        }
    }

    private function valValuePassword(): void
    {
        if (preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9-@#$%;*]{6,}$/', $this->password)) {
            $this->result =  true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: A senha deve conter letras e números!</p>";
            $this->result =  false;
        }
    }
}
