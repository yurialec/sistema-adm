<?php

if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

echo "<h2>Listar E-mail</h2>";

echo "<a href='" . URLADM . "add-conf-email/index'>Cadastrar novo E-amil</a><br><br>";

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}

foreach ($this->data['listConfEmail'] as $confEmail) {
    extract($confEmail);
    echo "ID: $id <br>";
    echo "Título: $title <br>";
    echo "Nome: $name <br>";
    echo "E-mail: $email <br>";
    
    echo "<a href='" . URLADM . "view-conf-email/index/$id'>Visualizar</a><br>";
    echo "<a href='" . URLADM . "edit-conf-email/index/$id'>Editar</a><br>";
    echo "<a href='" . URLADM . "delete-conf-email/index/$id'>Apagar</a>";
    echo "<hr>";
}

echo $this->data['pagination'];
