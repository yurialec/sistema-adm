<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsAddTypePage;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página cadastrar novo Usuário
 * @author Yuri <yuri.alec@hotmail.com>
 */
class AddTypePg
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

        if (!empty($this->dataForm['SendAddTypePage'])) {
            unset($this->dataForm['SendAddTypePage']);

            $createTypePage = new AdmsAddTypePage();
            $createTypePage->create($this->dataForm);

            if ($createTypePage->getResult()) {
                $urlRedirect = URLADM . "list-types-pgs/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddTypePage();
            }
        } else {
            $this->viewAddTypePage();
        }
    }

    private function viewAddTypePage()
    {
        $button = [
            'list_types_pgs' => [
                'menu_controller' => 'list-types-pgs',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);
        
        $loadView = new ConfigView("adms/Views/TypesPages/AddTypePage", $this->data);
        $loadView->loadView();
    }
}
