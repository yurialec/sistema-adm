<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\ColorsAdmsAddColor;
use Core\ConfigView;

/**
 * Controller da página cadastrar novo Usuário
 * @author Yuri <yuri.alec@hotmail.com>
 */
class AddColor
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

        if (!empty($this->dataForm['SendAddColor'])) {
            unset($this->dataForm['SendAddColor']);
            $createColor = new AdmsAddColor();
            $createColor->create($this->dataForm);

            if ($createColor->getResult()) {
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddUser();
            }
        } else {
            $this->viewAddUser();
        }
    }

    private function viewAddUser()
    {
        $loadView = new ConfigView("adms/Views/Colors/AddColor", $this->data);
        $loadView->loadView();
    }
}
