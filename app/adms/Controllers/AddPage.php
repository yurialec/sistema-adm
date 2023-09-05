<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsAddPage;
use Core\ConfigView;

/**
 * Controller da página cadastrar nova página
 * @author Yuri <yuri.alec@hotmail.com>
 */
class AddPage
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

        if (!empty($this->dataForm['SendAddPage'])) {
            unset($this->dataForm['SendAddPage']);
            $createPg = new AdmsAddPage();
            $createPg->create($this->dataForm);

            if ($createPg->getResult()) {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddPg();
            }
        } else {
            $this->viewAddPg();
        }
    }

    private function viewAddPg()
    {
        $listSelect = new AdmsAddPage();
        $this->data['select'] = $listSelect->listSelect();

        $this->data['sidebarActive'] = "list-pages";

        $loadView = new ConfigView("adms/Views/Pages/AddPage", $this->data);
        $loadView->loadView();
    }
}
