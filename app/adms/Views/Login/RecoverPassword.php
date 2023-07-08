<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<h1>Recuperar Senha</h1>
<?php
if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-recover-pass">
    <label>Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite seu e-mail" value="<?php isset($valorForm['email']) ? printf($valorForm['email']) : null ?>">
    <br><br>
    <button type="submit" name="SendRecoverPass" value="Enviar">Recuperar</button>
</form>
<br>
<p><a href="<?php echo URLADM ?>">Clique Aqui </a>para acessar</p>