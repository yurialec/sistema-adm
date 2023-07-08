<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<h1>Área Restrita</h1>
<?php
if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-login">
    <label>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o susuário" value="<?php isset($valorForm['user']) ? printf($valorForm['user']) : null ?>">
    <br><br>
    <label>Senha: </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>">
    <br><br>
    <button type="submit" name="SendLogin" value="Acessar">Acessar</button>
</form>
<br>
<p><a href="<?php echo URLADM ?>new-user/index">Cadastrar</a> - <a href="<?php echo URLADM ?>recover-password/index">Esqueceu a senha?</a></p>