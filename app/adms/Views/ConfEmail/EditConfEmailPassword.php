<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}

?>
<h1>Editar senha da configuração do E-mail</h1>
<?php

// echo "<a href='" . URLADM . "view-profile/index'>Perfil</a><br><br>";

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-profile-pass">
    <input type="hidden" name="id" id="id" value="<?php isset($valorForm['id']) ? printf($valorForm['id']) : null ?>">
    <label><span style="color: #f00;">*</span>Nova Senha:</label>
    <input type="password" name="password" id="password" onkeyup="passwordStrength()" autocomplete="on" placeholder="Digite sua nova senha" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>" required>
    <span id="msgViewStrength"><br><br></span>
    <br><br>
    <span style="color: #f00;">* Campo Óbrigatório</span><br><br>

    <button type="submit" name="SendEditConfEmailPass" value="Salvar">Salvar</button>
</form>