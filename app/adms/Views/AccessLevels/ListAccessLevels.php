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
            <span class="title-content">Listar Níveis de Acesso</span>
            <div class="top-list-right">
                <?php

                if ($this->data['button']['add_access_level']) {
                    echo "<a href='" . URLADM . "add-access-level/index' class='btn-success'>Cadastrar</a> ";
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
                    <th class="list-head-content table-sm-none">Ordem</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['ListAccessLevels'] as $level) {
                    extract($level);
                ?>
                    <tr>
                        <td class="list-body-content"><?php echo $id; ?></td>
                        <td class="list-body-content"><?php echo $name; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $order_levels; ?></td>
                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php
                                    if ($this->data['button']['view_access_level']) {
                                        echo "<a href='" . URLADM . "view-access-level/index/$id'><i class='fa-solid fa-eye'></i> Visualizar</a>";
                                    }
                                    if ($this->data['button']['edit_access_level']) {
                                        echo "<a href='" . URLADM . "edit-access-level/index/$id'><i class='fa-solid fa-pen-to-square'></i> Editar</a>";
                                    }
                                    if ($this->data['button']['delete_access_level']) {
                                        echo "<a href='" . URLADM . "delete-access-level/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'><i class='fa-regular fa-trash-can'></i> Apagar</a>";
                                    }
                                    if ($this->data['button']['list_permission']) {
                                        echo "<a href='" . URLADM . "list-permission/index/?level=$id'><i class='fa-solid fa-house-lock'></i> Permissão</a>";
                                    }
                                    if ($this->data['button']['order_access_level']) {
                                        echo "<a href='" . URLADM . "order-access-level/index/$id?pag=" . $this->data['pag'] . "'><i class='fa-solid fa-arrow-up-short-wide'></i> Ordem</a>";
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

        <?php $this->data['pagination'] !== [] ? printf($this->data['pagination']) : NULL ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->