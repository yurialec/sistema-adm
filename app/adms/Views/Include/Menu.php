<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

$sidebar_active = "";
if (isset($this->data['sidebarActive'])) {
    $sidebar_active = $this->data['sidebarActive'];
}

$sidebar_active = "";
if (isset($this->data['sidebarActive'])) {
    $sidebar_active = $this->data['sidebarActive'];
}

?>

<!-- Inicio Conteudo -->
<div class="content">
    <!-- Inicio da Sidebar -->
    <div class="sidebar">

        <?php $dashboard = "";
        if ($sidebar_active == "dashboard") {
            $dashboard = "active";
        } ?>
        <a href="<?php echo URLADM; ?>dashboard/index" class="sidebar-nav <?php echo $dashboard; ?>"><i class="icon fa-solid fa-house"></i><span>Dashboard</span></a>

        <?php
        $sidebar_user = "";
        $list_users = "";
        if ($sidebar_active == "list-users") {
            $list_users = "active";
            $sidebar_user = "active";
        } ?>

        <button class="dropdown-btn <?php echo $sidebar_user; ?>">
            <i class="icon fa-solid fa-user"></i><span>Usuário</span><i class="fa-solid fa-caret-down"></i>
        </button>
        <div class="dropdown-container <?php echo $sidebar_user; ?>">
            <a href="<?php echo URLADM; ?>list-users/index" class="sidebar-nav <?php echo $list_users; ?>"><i class="icon fa-solid fa-users"></i><span>Usuários</span></a>
        </div>

        <?php $list_sits_users = "";
        if ($sidebar_active == "list-sits-users") {
            $list_sits_users = "active";
        } ?>
        <a href="<?php echo URLADM; ?>list-sits-users/index" class="sidebar-nav <?php echo $list_sits_users; ?>"><i class="icon fa-solid fa-user-check"></i><span>Situações do Usuário</span></a>

        <?php $list_colors = "";
        if ($sidebar_active == "list-colors") {
            $list_colors = "active";
        } ?>
        <a href="<?php echo URLADM; ?>list-colors/index" class="sidebar-nav <?php echo $list_colors; ?>"><i class="icon fa-solid fa-palette"></i><span>Cores</span></a>

        <?php $list_conf_email = "";
        if ($sidebar_active == "list-conf-email") {
            $list_conf_email = "active";
        } ?>
        <a href="<?php echo URLADM; ?>list-conf-email/index" class="sidebar-nav <?php echo $list_conf_email; ?>"><i class="icon fa-solid fa-envelope"></i><span>Configurações de E-mail</span></a>

        <a href="<?php echo URLADM; ?>logout/index" class="sidebar-nav"><i class="icon fa-solid fa-arrow-right-from-bracket"></i><span>Sair</span></a>

    </div>
    <!-- Fim da Sidebar -->