<?php

namespace App\adms\Models\Helper;

class AdmsValEmptyField
{
    private array|null $data;
    private bool $result;

    public function getResult()
    {
        return $this->result;
    }

    public  function valField(array $data = null)
    {
        $this->data = $data;

        $this->data = array_map('strip_tags', $this->data);
        $this->data = array_map('trim', $this->data);

        if (in_array('', $this->data)) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário preencher todos os campos.</p>";
            $this->result = false;
        } else {
            $this->result = true;
        }
    }
}
