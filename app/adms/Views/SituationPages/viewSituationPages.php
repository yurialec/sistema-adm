<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

// var_dump($this->data['viewSitsPg'][0]);

?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Detalhes da Situação da Página</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_situation_pages']) {
                    echo "<a href='" . URLADM . "list-situation-pages/index' class='btn-info'>Listar</a> ";
                }
                if (!empty($this->data['viewSitsPg'])) {
                    if ($this->data['button']['edit_situation_page']) {
                        echo "<a href='" . URLADM . "edit-situation-page/index/" . $this->data['viewSitsPg'][0]['id'] . "' class='btn-warning'>Editar</a> ";
                    }

                    if ($this->data['button']['delete_situation_page']) {
                        echo "<a href='" . URLADM . "delete-situation-page/index/" . $this->data['viewSitsPg'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")' class='btn-danger'>Apagar</a> ";
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
            if (!empty($this->data['viewSitsPg'])) {
                extract($this->data['viewSitsPg'][0]);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome: </span>
                    <span class="view-adm-info"><?php echo $name; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cor: </span>
                    <span class="view-adm-info"><span style="color: <?= $color ?>;"><?php echo $color; ?></span></span>
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