<?php

namespace App\adms\Controllers;

use Core\ConfigView;

/**
 * Controller da página login
 * @author Yuri <yuri.alec@hotmail.com>
 */
class Login
{
    /**
     * @var array|string|null $data Recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data = [];

    /**
     * $dataForm recebe os dados do formulário
     *
     * @var array
     */
    private array|null $dataForm;

    /**
     * Metodo Login
     *
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendLogin'])) {
            $this->data['form'] = $this->dataForm; 
        }

        $loadView = new ConfigView("adms/Views/Login/Login", $this->data);
        $loadView->loadView();
    }
}
