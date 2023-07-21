<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<h1>Novo Usuário</h1>
<?php
if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-new-user">
    <label>Nome: </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>" required>
    <br><br>
    <label>Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite seu melhor e-mail" value="<?php isset($valorForm['email']) ? printf($valorForm['email']) : null ?>" required>
    <br><br>
    <label>Senha: </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>" required>
    <span id="msgViewStrength"><br><br></span>
    <br><br>
    <button type="submit" name="SendNewUser" value="Cadastrar">Cadastrar</button>
</form>
<br>
<p><a href="<?php echo URLADM ?>">Clique Aqui </a>para acessar</p>