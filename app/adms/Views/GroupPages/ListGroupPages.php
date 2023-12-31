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
            <span class="title-content">Listar Grupos de Páginas</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "add-group-page/index' class='btn-success'>Cadastrar</a>";
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
                foreach ($this->data['listGroupsPages'] as $typePgs) {
                    extract($typePgs);
                ?>
                    <tr>
                        <td class="list-body-content"><?php echo $id; ?></td>
                        <td class="list-body-content"><?php echo $name; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $order_group_pg; ?></td>
                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php
                                    echo "<a href='" . URLADM . "order-group-page/index/$id?pag=" . $this->data['pag'] . "'><i class='fa-solid fa-arrow-up-short-wide'></i> Ordem</a>";
                                    echo "<a href='" . URLADM . "view-group-page/index/$id'><i class='fa-regular fa-eye'></i> Visualizar</a>";
                                    echo "<a href='" . URLADM . "edit-group-page/index/$id'><i class='fa-regular fa-pen-to-square'></i> Editar</a>";
                                    echo "<a href='" . URLADM . "delete-group-page/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'><i class='fa-regular fa-trash-can'></i> Apagar</a>";
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