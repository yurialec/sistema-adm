<?php

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

echo "<h2>Listar Usuários</h2>";

echo "<a href='" . URLADM . "add-users/index'>Cadastrar novo usuário</a><br><br>";

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}

foreach ($this->data['listUsers'] as $user) {
    extract($user);
    echo "ID: $id <br>";
    echo "Nome: $name <br>";
    echo "E-mail: $email <br>";
    echo "<a href='" . URLADM . "view-users/index/$id'>Visualizar</a><br>";
    echo "<a href='" . URLADM . "edit-users/index/$id'>Editar</a><br>";
    echo "<a href='" . URLADM . "delete-users/index/$id'>Apagar</a>";
    echo "<hr>";
}
