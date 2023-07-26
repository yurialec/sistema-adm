<?php

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

echo "<h2>Listar Cores</h2>";

echo "<a href='" . URLADM . "add-color/index'>Cadastrar nova cor</a><br><br>";

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}

foreach ($this->data['listColors'] as $color) {
    extract($color);
    echo "ID: $id <br>";
    echo "Nome: <span style='color: $color;'>$name</span> <br>";
    echo "<a href='" . URLADM . "view-color/index/$id'>Visualizar</a><br>";
    echo "<a href='" . URLADM . "edit-color/index/$id'>Editar</a><br>";
    echo "<a href='" . URLADM . "delete-color/index/$id' onClick='return confirm(\"Tem Certeza que deseja excluir este registro?\")'>Apagar</a>";
    echo "<hr>";
}

echo $this->data['pagination'];
