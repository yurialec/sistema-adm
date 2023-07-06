<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<h1>Novo Link</h1>
<?php
if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-new-conf-email">
    <label>Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite seu e-mail" value="<?php isset($valorForm['email']) ? printf($valorForm['email']) : null ?>" required>
    <br><br>
    <button type="submit" name="SendNewConfEmail" value="Enviar">Enviar</button>
</form>
<br>
<p><a href="<?php echo URLADM ?>">Clique Aqui </a>para acessar</p>