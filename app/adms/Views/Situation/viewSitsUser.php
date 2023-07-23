<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

echo "<h2>Detalhes da situação</h2>";

echo "<a href='" . URLADM . "list-sits-users/index'>Listar situações</a><br>";
if (!empty($this->data['viewSitsUser'])) {
    echo "<a href=' " . URLADM . "edit-sits-users/index/" . $this->data['viewSitsUser'][0]['id'] . "'>Editar</a><br>";
    echo "<a href=' " . URLADM . "delete-sits-users/index/" . $this->data['viewSitsUser'][0]['id'] . "'>Excluir</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewSitsUser'])) {
    extract($this->data['viewSitsUser'][0]);
    echo "ID: $id <br>";
    echo "Nome: <span style='color: $color ;'>$name</span><br>";
    echo "Criação: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    !empty($modified) ? print_r("Editado: " . date('d/m/Y H:i:s', strtotime($modified))) : print_r("Editado: ");
}
