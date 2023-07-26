<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

echo "<h2>Detalhes da cor</h2>";

echo "<a href='" . URLADM . "list-colors/index'>Listar cores</a><br>";
if (!empty($this->data['viewColor'])) {
    echo "<a href=' " . URLADM . "edit-color/index/" . $this->data['viewColor'][0]['id'] . "'>Editar</a><br>";
    echo "<a href=' " . URLADM . "delete-colors/index/" . $this->data['viewColor'][0]['id'] . "'>Excluir</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewColor'])) {
    extract($this->data['viewColor'][0]);
    echo "ID: $id <br>";
    echo "Nome: $name <br>";
    echo "Cor: <span style='color: $color;'>$color</span> <br>";
    echo "Criação: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    !empty($modified) ? print_r("Editado: " . date('d/m/Y H:i:s', strtotime($modified))) : print_r("Editado: ");
}
