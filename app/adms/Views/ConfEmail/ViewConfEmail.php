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
            <span class="title-content">Detalhes do E-mail</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_conf_email']) {
                    echo "<a href='" . URLADM . "list-conf-email/index' class='btn-info'>Listar</a> ";
                }

                if (!empty($this->data['viewConfEmail'])) {
                    if ($this->data['button']['edit_conf_email']) {
                        echo "<a href='" . URLADM . "edit-conf-email/index/" . $this->data['viewConfEmail'][0]['id'] . "' class='btn-warning'>Editar</a> ";
                    }

                    if ($this->data['button']['edit_conf_email_password']) {
                        echo "<a href='" . URLADM . "edit-conf-email-password/index/" . $this->data['viewConfEmail'][0]['id'] . "' class='btn-warning'>Editar Senha</a> ";
                    }

                    if ($this->data['button']['delete_conf_email']) {
                        echo "<a href='" . URLADM . "delete-conf-email/index/" . $this->data['viewConfEmail'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")' class='btn-danger'>Apagar</a> ";
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
            if (!empty($this->data['viewConfEmail'])) {
                extract($this->data['viewConfEmail'][0]);
            ?>

                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Título: </span>
                    <span class="view-adm-info"><?php echo $title; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome: </span>
                    <span class="view-adm-info"><?php echo $name; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">E-mail: </span>
                    <span class="view-adm-info"><?php echo $email; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Host: </span>
                    <span class="view-adm-info"><?php echo $host; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Usuário: </span>
                    <span class="view-adm-info"><?php echo $username; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">SMTP: </span>
                    <span class="view-adm-info"><?php echo $smtp; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Porta: </span>
                    <span class="view-adm-info"><?php echo $port; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cadastrado: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></span>
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