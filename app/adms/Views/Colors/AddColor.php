<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<h1>Cadastrar Cor</h1>
<?php
if (isset($_SESSION['msg'])) {
    printf($_SESSION['msg']);
    unset($_SESSION['msg']);
}
?>

<span id="msg"></span>

<form method="POST" action="" id="form-add-color">
    <label><span style="color: #f00;">*</span>Nome: </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome da cor" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>">
    <br><br>
    <label><span style="color: #f00;">*</span>Selecione a cor: </label>
    <input type="color" name="color" id="color" value="<?php isset($valorForm['color']) ? printf($valorForm['color']) : null ?>">
    <br><br>
    <span style="color: #f00;">* Campo Obrigatório</span><br><br>
    <button type="submit" name="SendAddColor" value="Cadastrar">Cadastrar</button>
</form>