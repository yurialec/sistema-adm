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
    <label><span style="color: #f00;">*</span>Nome: </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>">
    <br><br>
    <label><span style="color: #f00;">*</span>Email: </label>
    <input type="email" name="email" id="email" placeholder="Digite seu melhor e-mail" value="<?php isset($valorForm['email']) ? printf($valorForm['email']) : null ?>">
    <br><br>
    <label><span style="color: #f00;">*</span>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário para acessar o adm" autocomplete="on" value="<?php isset($valorForm['user']) ? printf($valorForm['user']) : null ?>">
    <br><br>

    <label><span style="color: #f00;">*</span>Situação: </label>
    <select name="adms_sits_user_id" id="adms_sits_user_id">
        <option value="">Selecione</option>
        <?php
        foreach ($this->data['select']['sit'] as $sit) :
            extract($sit);
            if ((isset($valorForm['adms_sits_user_id'])) and ($valorForm['adms_sits_user_id'] == $id_sit)) {
                echo "<option value='$id_sit' selected>$name_sit</option>";
            } else {
                echo "<option value='$id_sit'>$name_sit</option>";
            }
        endforeach
        ?>
    </select>
    <br><br>
    
    <label><span style="color: #f00;">*</span>Senha: </label>
    <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>">
    <span id="msgViewStrength"><br><br></span>
    <br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>
    <button type="submit" name="SendAddUser" value="Cadastrar">Cadastrar</button>
</form>