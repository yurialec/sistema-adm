<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}

?>
<h1>Editar Imagem</h1>
<?php

echo "<a href='" . URLADM . "list-users/index'>Listar usuários</a><br>";
if (isset($valorForm['id'])) {
    echo "<a href=' " . URLADM . "view-users/index/" . $valorForm['id'] . "'>Visualizar</a><br><br>";
}

if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-edit-user-pass" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" value="<?php printf($valorForm['id']) ?>">
    <label><span style="color: #f00;">*</span>Imagem 300x300:</label>
    <input type="file" name="new_image" id="new_image"><br><br>
    <span style="color: #f00;">* Campo Óbrigatório</span><br><br>
    <button type="submit" name="SendEditImageUser" value="Salvar">Salvar</button>
</form>