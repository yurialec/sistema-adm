<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Detalhes do Usuário</span>
            <div class="top-list-right">
                <?php

                if ($this->data['button']['list_users']) {
                    echo "<a href='" . URLADM . "list-users/index' class='btn-info'>Listar</a> ";
                }

                if (!empty($this->data['viewUser'])) {

                    if ($this->data['button']['edit_users']) {
                        echo "<a href='" . URLADM . "edit-users/index/" . $this->data['viewUser'][0]['id'] . "' class='btn-warning'>Editar</a> ";
                    }

                    if ($this->data['button']['edit_users_password']) {
                        echo "<a href='" . URLADM . "edit-users-password/index/" . $this->data['viewUser'][0]['id'] . "' class='btn-warning'>Editar Senha</a> ";
                    }

                    if ($this->data['button']['edit_users_image']) {
                        echo "<a href='" . URLADM . "edit-users-image/index/" . $this->data['viewUser'][0]['id'] . "' class='btn-warning'>Editar Imagem</a> ";
                    }

                    if ($this->data['button']['delete_users']) {
                        echo "<a href='" . URLADM . "delete-users/index/" . $this->data['viewUser'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")' class='btn-danger'>Apagar</a> ";
                    }
                }
                ?>
            </div>
        </div>

        <div class="content-adm-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>

        <div class="content-adm">
            <?php
            if (!empty($this->data['viewUser'])) {
                extract($this->data['viewUser'][0]);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">Foto: </span>
                    <span class="view-adm-info">
                        <?php
                        if ((!empty($image)) and (file_exists("app/adms/assets/image/users/$id/$image"))) {
                            echo "<img src='" . URLADM . "app/adms/assets/image/users/$id/$image' width='100' height='100'><br><br>";
                        } else {
                            echo "<img src='" . URLADM . "app/adms/assets/image/users/icon_user.png' width='100' height='100'><br><br>";
                        }
                        ?>
                    </span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome: </span>
                    <span class="view-adm-info"><?php echo $name_usr; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Apelido: </span>
                    <span class="view-adm-info"><?php echo $nick_name; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">E-mail: </span>
                    <span class="view-adm-info"><?php echo $email; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Usuário: </span>
                    <span class="view-adm-info"><?php echo $user; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Situação do Usuário: </span>
                    <span class="view-adm-info">
                        <?php echo "<span style='color: $color;'>$name_sit</span>"; ?>
                    </span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nível de acesso: </span>
                    <span class="view-adm-info"><?php echo $name_level; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cadastrado: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($created_at)); ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Editado: </span>
                    <span class="view-adm-info">
                        <?php
                        if (!empty($modified)) {
                            echo date('d/m/Y H:i:s', strtotime($modified));
                        } ?>
                    </span>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->