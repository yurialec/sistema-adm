<?php

namespace App\adms\Controllers;

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

use App\adms\Models\AdmsAddAcessLevel;
use App\adms\Models\Helper\AdmsButton;
use Core\ConfigView;

/**
 * Controller da página cadastrar novo Usuário
 * @author Yuri <yuri.alec@hotmail.com>
 */
class AddAccessLevel
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a view */
    private array|string|null $data = [];

    /** $dataForm recebe os dados do formulário @var array */
    private array|null $dataForm;

    /**
     * Metodo Login
     *
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendAddAccessLevel'])) {
            unset($this->dataForm['SendAddAccessLevel']);

            $createAccessLevel = new AdmsAddAcessLevel();
            $createAccessLevel->create($this->dataForm);

            if ($createAccessLevel->getResult()) {
                $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddAcessLevel();
            }
        } else {
            $this->viewAddAcessLevel();
        }
    }

    private function viewAddAcessLevel()
    {
        $button = [
            'list_access_levels' => [
                'menu_controller' => 'list-access-levels',
                'menu_metodo' => 'index'
            ]
        ];

        $listButtons = new AdmsButton;
        $this->data['button'] = $listButtons->buttonPermission($button);

        $loadView = new ConfigView("adms/Views/AccessLevels/AddAccessLevel", $this->data);
        $loadView->loadView();
    }
}
