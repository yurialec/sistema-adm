<?php

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

echo "<h2>Listar Situações</h2>";

echo "<a href='" . URLADM . "add-sits-users/index'>Cadastrar nova situação</a><br><br>";

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}

foreach ($this->data['listSitsUsers'] as $situation) {
    extract($situation);
    echo "ID: $id <br>";
    echo "Nome: <span style='color: $color;'>$name</span><br>";
    echo "<a href='" . URLADM . "view-sits-users/index/$id'>Visualizar</a><br>";
    echo "<a href='" . URLADM . "edit-sits-users/index/$id'>Editar</a><br>";
    echo "<a href='" . URLADM . "delete-sits-users/index/$id'>Apagar</a>";
    echo "<hr>";
}
