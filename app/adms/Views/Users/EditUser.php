<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}

?>
<h1>Editar Usuário</h1>
<?php

echo "<a href='" . URLADM . "list-users/index'>Listar usuários</a><br>";
if (isset($valorForm['id'])) {
    echo "<a href=' " . URLADM . "view-users/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-add-user">
    <input type="hidden" name="id" id="id" value="<?php isset($valorForm['id']) ? printf($valorForm['id']) : null ?>">
    <label>Nome: </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>">
    <br><br>
    <label>Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite seu melhor e-mail" value="<?php isset($valorForm['email']) ? printf($valorForm['email']) : null ?>">
    <br><br>
    <label>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário para acessar o adm" onkeyup="passwordStrength()" autocomplete="on" value="<?php isset($valorForm['user']) ? printf($valorForm['user']) : null ?>">
    <br><br>
    <label>Apelido: </label>
    <input type="text" name="nick_name" id="nick_name" placeholder="Digite o apelido" onkeyup="passwordStrength()" autocomplete="on" value="<?php isset($valorForm['nick_name']) ? printf($valorForm['nick_name']) : null ?>">
    <br><br>
    <button type="submit" name="SendEditUser" value="Salvar">Salvar</button>
</form>