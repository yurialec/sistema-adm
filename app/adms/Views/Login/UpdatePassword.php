<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<h1>Nova Senha</h1>
<?php
if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-login">
    <label>Senha: </label>
    <input type="password" name="password" id="password" placeholder="Digite a nova senha" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>">
    <br><br>
    <button type="submit" name="SendUpPass" value="Salvar">Salvar</button>
</form>
<br>
<p><a href="<?php echo URLADM ?>">Clique Aqui </a>para acessar</p>