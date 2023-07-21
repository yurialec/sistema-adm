<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

echo "<h2>Detalhes do usuário</h2>";

echo "<a href='" . URLADM . "list-users/index'>Listar usuários</a><br>";
if (!empty($this->data['viewUser'])) {
    echo "<a href=' " . URLADM . "edit-users/index/" . $this->data['viewUser'][0]['id'] . "'>Editar</a><br>";
    echo "<a href=' " . URLADM . "edit-users-password/index/" . $this->data['viewUser'][0]['id'] . "'>Editar Senha</a><br>";
    echo "<a href=' " . URLADM . "edit-users-image/index/" . $this->data['viewUser'][0]['id'] . "'>Editar Imagem</a><br>";
    echo "<a href=' " . URLADM . "delete-users/index/" . $this->data['viewUser'][0]['id'] . "'>Excluir</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewUser'])) {
    extract($this->data['viewUser'][0]);
    ((!empty($image)) and (file_exists("app/adms/assets/image/users/" . $id . "/$image"))) ? print_r("<img src='" . URLADM . "app/adms/assets/image/users/" . $id . " /$image' width='100' height='100' ><br><br>") : print_r("<img src='" . URLADM . "app/adms/assets/image/users/icon_user.png' width='100' height='100' ><br><br>");
    echo "ID: $id <br>";
    echo "Nome: $name_usr <br>";
    echo "E-mail: $email <br>";
    echo "Apelido: $nick_name <br>";
    echo "User: $user <br>";
    echo "Situação do Usuário: <span style='color: $color ;'>$name_sit</span><br>";
    echo "Criação: " . date('d/m/Y H:i:s', strtotime($created_at)) . " <br>";
    !empty($modified) ? print_r("Editado: " . date('d/m/Y H:i:s', strtotime($modified))) : print_r("Editado: ");
}
