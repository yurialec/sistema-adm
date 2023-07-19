<?php

echo "<h2>Perfil</h2>";

echo "<a href='" . URLADM . "list-users/index'>Listar usuários</a><br>";
if (!empty($this->data['viewProfile'])) {
    echo "<a href=' " . URLADM . "edit-profile/index/'>Editar</a><br>";
    // echo "<a href=' " . URLADM . "edit-users-password/index/" . $this->data['viewUser'][0]['id'] . "'>Editar Senha</a><br>";
    // echo "<a href=' " . URLADM . "edit-users-image/index/" . $this->data['viewUser'][0]['id'] . "'>Editar Imagem</a><br>";
    // echo "<a href=' " . URLADM . "delete-users/index/" . $this->data['viewUser'][0]['id'] . "'>Excluir</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (!empty($this->data['viewProfile'])) {
    extract($this->data['viewProfile'][0]);

    ((!empty($image)) and (file_exists("app/adms/assets/image/users/" . $_SESSION['user_id'] . "/$image"))) ? print_r("<img src='" . URLADM . "app/adms/assets/image/users/" . $_SESSION['user_id'] . " /$image' width='100' height='100' ><br><br>") : print_r("<img src='" . URLADM . "app/adms/assets/image/users/icon_user.png' width='100' height='100' ><br><br>");

    echo "Nome: $name <br>";
    echo "E-mail: $email <br>";
    echo "Apelido: $nick_name <br>";
    echo "Criação: " . date('d/m/Y H:i:s', strtotime($created_at)) . " <br>";
}
