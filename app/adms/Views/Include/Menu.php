<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
?>
<a href="<?php echo URLADM; ?>dashboard/index">Dashboard</a><br>
<a href="<?php echo URLADM; ?>list-users/index">Listar Usuário</a><br>
<a href="<?php echo URLADM; ?>view-profile/index">Perfil</a><br>
<a href="<?php echo URLADM; ?>logout/index">Sair</a><br>