<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<h1>Cadastrar Usuário</h1>
<?php
if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-add-user">
    <label>Nome: </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>">
    <br><br>
    <label>Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite seu melhor e-mail" value="<?php isset($valorForm['email']) ? printf($valorForm['email']) : null ?>">
    <br><br>
    <label>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário para acessar o adm" onkeyup="passwordStrength()" autocomplete="on" value="<?php isset($valorForm['user']) ? printf($valorForm['user']) : null ?>">
    <br><br>
    <label>Senha: </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>">
    <span id="msgViewStrength"><br><br></span>
    <br><br>
    <button type="submit" name="SendAddUser" value="Cadastrar">Cadastrar</button>
</form>