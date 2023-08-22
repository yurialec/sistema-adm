<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

// var_dump($this->data['viewTypesPgs'][0]);

?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Detalhes do Tipo de Página</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-types-pgs/index' class='btn-info'>Listar</a> ";
                if (!empty($this->data['viewTypesPgs'])) {
                    echo "<a href='" . URLADM . "edit-types-pgs/index/" . $this->data['viewTypesPgs'][0]['id'] . "' class='btn-warning'>Editar</a> ";
                    echo "<a href='" . URLADM . "delete-types-pgs/index/" . $this->data['viewTypesPgs'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")' class='btn-danger'>Apagar</a> ";
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
            if (!empty($this->data['viewTypesPgs'])) {
                extract($this->data['viewTypesPgs'][0]);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">Tipo: </span>
                    <span class="view-adm-info"><?php echo $type; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome: </span>
                    <span class="view-adm-info"><?php echo $name; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Ordem: </span>
                    <span class="view-adm-info"><?php echo $order_type_pg; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Observação: </span>
                    <span class="view-adm-info"><?php echo $obs; ?></span>
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