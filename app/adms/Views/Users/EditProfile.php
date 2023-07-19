<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}

?>
<h1>Editar Perfil</h1>
<?php

// if (isset($valorForm['id'])) {
//     echo "<a href=' " . URLADM . "view-users/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
// }

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-profile">
    <label><span style="color: #f00;">*</span>Nome:</label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>" required>
    <br><br>
    <label><span style="color: #f00;">*</span>Email:</label>
    <input type="email" name="email" id="email" placeholder="Digite seu melhor e-mail" value="<?php isset($valorForm['email']) ? printf($valorForm['email']) : null ?>" required>
    <br><br>
    <label><span style="color: #f00;">*</span>Usuário:</label>
    <input type="text" name="user" id="user" placeholder="Digite o usuário para acessar o adm" onkeyup="passwordStrength()" autocomplete="on" value="<?php isset($valorForm['user']) ? printf($valorForm['user']) : null ?>" required>
    <br><br>
    <label>Apelido:</label>
    <input type="text" name="nick_name" id="nick_name" placeholder="Digite o apelido" onkeyup="passwordStrength()" autocomplete="on" value="<?php isset($valorForm['nick_name']) ? printf($valorForm['nick_name']) : null ?>">
    <br><br>
    <span style="color: #f00;">* Campo Óbrigatório</span><br><br>
    <button type="submit" name="SendEditProfile" value="Salvar">Salvar</button>
</form>