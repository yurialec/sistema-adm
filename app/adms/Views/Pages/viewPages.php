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
            <span class="title-content">Detalhes da Página</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-pages/index' class='btn-info'>Listar</a> ";
                if (!empty($this->data['viewPg'])) {
                    echo "<a href='" . URLADM . "edit-page/index/" . $this->data['viewPg'][0]['id'] . "' class='btn-warning'>Editar</a> ";
                    echo "<a href='" . URLADM . "delete-page/index/" . $this->data['viewPg'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")' class='btn-danger'>Apagar</a> ";
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
            if (!empty($this->data['viewPg'])) {
                extract($this->data['viewPg'][0]);
            ?>

                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Controller: </span>
                    <span class="view-adm-info"><?php echo $controller; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Metodo: </span>
                    <span class="view-adm-info"><?php echo $metodo; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Menu Controller: </span>
                    <span class="view-adm-info"><?php echo $menu_controller; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Menu Metodo: </span>
                    <span class="view-adm-info"><?php echo $menu_metodo; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome da Página: </span>
                    <span class="view-adm-info"><?php echo $name_page; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Página Publica: </span>
                    <span class="view-adm-info">
                        <?php
                        if ($publish == 2) {
                            echo "Sim";
                        } else {
                            echo "Não";
                        }
                        ?>
                    </span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Ícone: </span>
                    <span class="view-adm-info">
                        <?php echo "<i class='" . $icon . "'></i> - " . $icon; ?>
                    </span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Observação: </span>
                    <span class="view-adm-info"><?php echo $obs; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Situação: </span>
                    <span class="view-adm-info">
                        <?php echo "<span style='color: $color_name'>$situation_name</span>"; ?>
                    </span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Tipo de Página: </span>
                    <span class="view-adm-info">
                        <?php echo $type_pg . " - " . $type_pg_name; ?>
                    </span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Grupo de Página: </span>
                    <span class="view-adm-info"><?php echo $group_pg; ?></span>
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