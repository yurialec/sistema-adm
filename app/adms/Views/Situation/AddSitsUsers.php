<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

?>
<h1>Cadastrar Situação</h1>
<?php
if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-add-user">
    <label><span style="color: #f00;">*</span>Nome: </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome da situação" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>">
    <br><br>

    <label><span style="color: #f00;">*</span>Cor: </label>
    <select name="adms_color_id" id="adms_color_id">
        <option value="">Selecione</option>
        <?php
        foreach ($this->data['select']['color'] as $color) :
            extract($color);
            if ((isset($valorForm['adms_color_id'])) and ($valorForm['adms_color_id'] == $id_color)) {
                echo "<option value='$id_color' selected>$name_color</option>";
            } else {
                echo "<option value='$id_color'>$name_color</option>";
            }
        endforeach
        ?>
    </select>
    <br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>
    <button type="submit" name="SendAddSitsUser" value="Cadastrar">Cadastrar</button>
</form>