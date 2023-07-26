<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

echo "<h2>Detalhes do E-mail</h2>";

echo "<a href='" . URLADM . "list-conf-email/index'>Configurações de E-mail</a><br>";
if (!empty($this->data['viewConfEmail'])) {
    echo "<a href=' " . URLADM . "edit-conf-email/index/" . $this->data['viewConfEmail'][0]['id'] . "'>Editar</a><br>";
    echo "<a href=' " . URLADM . "edit-conf-email-password/index/" . $this->data['viewConfEmail'][0]['id'] . "'>Editar Senha</a><br>";
    echo "<a href=' " . URLADM . "delete-conf-email/index/" . $this->data['viewConfEmail'][0]['id'] . "' onClick='return confirm(\"Tem Certeza que deseja excluir este registro?\")'>Excluir</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewConfEmail'])) {
    extract($this->data['viewConfEmail'][0]);
    echo "ID: $id <br>";
    echo "Título: $title <br>";
    echo "Nome: $name <br>";
    echo "E-mail: $email <br>";
    echo "Host: $host <br>";
    echo "Username: $username <br>";
    echo "SMTP: $smtp <br>";
    echo "Port: $port <br>";
    echo "Criação: " . date('d/m/Y H:i:s', strtotime($created)) . " <br>";
    !empty($modified) ? print_r("Editado: " . date('d/m/Y H:i:s', strtotime($modified))) : print_r("Editado: ");
}
