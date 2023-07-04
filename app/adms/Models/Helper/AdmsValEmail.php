<?php

namespace App\adms\Models\Helper;

class AdmsValEmail
{
    private string $email;
    private bool $result;

    public function getResult(): bool
    {
        return $this->result;
    }

    public function validateEmail(string $email): void
    {
        $this->email = $email;

        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro! E-mail inválido.</p>";
            $this->result = false;
        }
    }
}
