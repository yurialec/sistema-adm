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
            <span class="title-content">Listar Páginas</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['add_page']) {
                    echo "<a href='" . URLADM . "add-page/index' class='btn-success'>Cadastrar</a> ";
                }

                if ($this->data['button']['sync_pages_levels']) {
                    echo "<a href='" . URLADM . "sync-pages-levels/index' class='btn-warning'>Sincronizar</a>";
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
        <table class="table-list">
            <thead class="list-head">
                <tr>
                    <th class="list-head-content">ID</th>
                    <th class="list-head-content">Nome</th>
                    <th class="list-head-content">Tipo de Página</th>
                    <th class="list-head-content">Situação</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listPages'] as $pages) {
                    extract($pages);
                ?>
                    <tr>
                        <td class="list-body-content"><?= $id ?></td>
                        <td class="list-body-content"><?= $name_page ?></td>
                        <td class="list-body-content"><?= $type_pg ?> - <?= $name_type_pg ?></td>
                        <td class="list-body-content"><span style="color: <?php echo $color_name ?>;"><?= $situation_pg_name ?></span></td>
                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php
                                    if ($this->data['button']['view_page']) {
                                        echo "<a href='" . URLADM . "view-page/index/$id'>Visualizar</a>";
                                    }

                                    if ($this->data['button']['edit_page']) {
                                        echo "<a href='" . URLADM . "edit-page/index/$id'>Editar</a>";
                                    }

                                    if ($this->data['button']['delete_page']) {
                                        echo "<a href='" . URLADM . "delete-page/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <?php echo $this->data['pagination']; ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->