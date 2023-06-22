<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<h1>Área Restrita</h1>
<form method="POST" action="">
    <label>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o susuário" value="<?php isset($valorForm['user']) ? printf($valorForm['user']) : null ?>">
    <br><br>

    <label>Senha: </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>">
    <br><br>

    <input type="submit" name="SendLogin" value="Acessar">
</form>