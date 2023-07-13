<?php
echo "<h2>Detalhes do usuário</h2>";

echo "<a href='" . URLADM . "list-users/index'>Listar usuários</a><br>";
if (!empty($this->data['viewUser'])) {
    echo "<a href=' " . URLADM . "edit-users/index/" . $this->data['viewUser'][0]['id'] . "'>Editar</a><br><br>";
    echo "<a href=' " . URLADM . "edit-users-password/index/" . $this->data['viewUser'][0]['id'] . "'>Editar Senha</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewUser'])) {
    extract($this->data['viewUser'][0]);
    echo "ID: $id <br>";
    echo "Nome: $name_usr <br>";
    echo "E-mail: $email <br>";
    echo "Apelido: $nick_name <br>";
    echo "User: $user <br>";
    echo "Imagem: $image <br>";
    echo "Situação do Usuário: <span style='color: $color ;'>$name_sit</span><br>";
    echo "Criação: " . date('d/m/Y H:i:s', strtotime($created_at)) . " <br>";
    !empty($modified) ? print_r("Editado: " . date('d/m/Y H:i:s', strtotime($modified))) : print_r("Editado: ");
}
