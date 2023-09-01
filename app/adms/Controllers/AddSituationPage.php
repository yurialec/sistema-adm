<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsAddSituationPage;
use Core\ConfigView;

/**
 * Controller da página cadastrar novo situação da página
 * @author Yuri <yuri.alec@hotmail.com>
 */
class AddSituationPage
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

        if (!empty($this->dataForm['SendAddSitsPg'])) {
            unset($this->dataForm['SendAddSitsPg']);
            $createSitsPg = new AdmsAddSituationPage();
            $createSitsPg->create($this->dataForm);

            if ($createSitsPg->getResult()) {
                $urlRedirect = URLADM . "list-situation-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddSitsPg();
            }
        } else {
            $this->viewAddSitsPg();
        }
    }

    private function viewAddSitsPg()
    {
        $listSelect = new AdmsAddSituationPage();
        $this->data['select'] = $listSelect->listSelect();

        $loadView = new ConfigView("adms/Views/SituationPages/AddSituation", $this->data);
        $loadView->loadView();
    }
}
