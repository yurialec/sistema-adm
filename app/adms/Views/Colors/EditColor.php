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
<h1>Editar Cor</h1>
<?php

echo "<a href='" . URLADM . "list-colors/index'>Listar cores</a><br>";
if (isset($valorForm['id'])) {
    echo "<a href=' " . URLADM . "view-color/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-user">
    <input type="hidden" name="id" id="id" value="<?php isset($valorForm['id']) ? printf($valorForm['id']) : null ?>">
    <label><span style="color: #f00;">*</span>Nome:</label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>" required>
    <br><br>
    <label><span style="color: #f00;">*</span>Cor:</label>
    <input type="text" name="color" id="color" placeholder="Digite a cor em hexadecimal" value="<?php isset($valorForm['color']) ? printf($valorForm['color']) : null ?>" required>
    <br><br>

    <span style="color: #f00;">* Campo Óbrigatório</span><br><br>

    <button type="submit" name="SendEditColor" value="Salvar">Salvar</button>
</form>