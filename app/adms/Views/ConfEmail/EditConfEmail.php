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
<h1>Editar Configuração de E-mail</h1>
<?php

echo "<a href='" . URLADM . "list-conf-email/index'>Configurações de E-mail</a><br>";
if (isset($valorForm['id'])) {
    echo "<a href=' " . URLADM . "view-conf-email/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-conf-email">
    <input type="hidden" name="id" id="id" value="<?php isset($valorForm['id']) ? printf($valorForm['id']) : null ?>">

    <label><span style="color: #f00;">*</span>Título:</label>
    <input type="text" name="title" id="title" value="<?php isset($valorForm['title']) ? printf($valorForm['title']) : null ?>" required>
    <br><br>

    <label><span style="color: #f00;">*</span>Nome:</label>
    <input type="text" name="name" id="name" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>" required>
    <br><br>

    <label><span style="color: #f00;">*</span>Email:</label>
    <input type="text" name="email" id="email" value="<?php isset($valorForm['email']) ? printf($valorForm['email']) : null ?>" required>
    <br><br>

    <label><span style="color: #f00;">*</span>Host:</label>
    <input type="text" name="host" id="host" value="<?php isset($valorForm['host']) ? printf($valorForm['host']) : null ?>" required>
    <br><br>

    <label><span style="color: #f00;">*</span>Username:</label>
    <input type="text" name="username" id="username" value="<?php isset($valorForm['username']) ? printf($valorForm['username']) : null ?>" required>
    <br><br>

    <label><span style="color: #f00;">*</span>SMTP:</label>
    <input type="text" name="smtp" id="smtp" value="<?php isset($valorForm['smtp']) ? printf($valorForm['smtp']) : null ?>" required>
    <br><br>

    <label><span style="color: #f00;">*</span>Port:</label>
    <input type="text" name="port" id="port" value="<?php isset($valorForm['port']) ? printf($valorForm['port']) : null ?>">
    <br><br>

    <span style="color: #f00;">* Campo Óbrigatório</span><br><br>

    <button type="submit" name="SendEditConfEMail" value="Salvar">Salvar</button>
</form>