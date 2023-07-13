<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}

?>
<h1>Editar Senha</h1>
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

<form method="POST" action="" id="form-edit-user-pass">
    <input type="hidden" name="id" id="id" value="<?php isset($valorForm['id']) ? printf($valorForm['id']) : null ?>">
    <label><span style="color: #f00;">*</span>Nova Senha:</label>
    <input type="password" name="password" id="password" onkeyup="passwordStrength()" autocomplete="on" placeholder="Digite sua nova senha" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>" required>
    <span id="msgViewStrength"><br><br></span>
    <br><br>
    <span style="color: #f00;">* Campo Óbrigatório</span><br><br>

    <button type="submit" name="SendEditUserPass" value="Salvar">Salvar</button>
</form>