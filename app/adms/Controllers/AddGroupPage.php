<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsAddGroupPage;
use Core\ConfigView;

/**
 * Controller da página cadastrar novo Usuário
 * @author Yuri <yuri.alec@hotmail.com>
 */
class AddGroupPage
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

        if (!empty($this->dataForm['SendAddGroupPage'])) {
            unset($this->dataForm['SendAddGroupPage']);

            $createGroupPage = new AdmsAddGroupPage();
            $createGroupPage->create($this->dataForm);

            if ($createGroupPage->getResult()) {
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddGroupPage();
            }
        } else {
            $this->viewAddGroupPage();
        }
    }

    private function viewAddGroupPage()
    {
        $loadView = new ConfigView("adms/Views/GroupPages/AddGroupPage", $this->data);
        $loadView->loadView();
    }
}
