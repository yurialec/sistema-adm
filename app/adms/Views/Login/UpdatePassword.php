<?php
if (!defined('G9C8O7N6N5T4I')) {
    header("Location: /");
    die("Erro: Página não encontrada!");
}
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<div class="container-login">
    <div class="wrapper-login">
        <div class="title">
            <span>Nova Senha</span>
        </div>

        <div class="msg-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo "<span id='msg'> " . $_SESSION['msg'] . "</span>";
                unset($_SESSION['msg']);
            } else {
                echo "<span id='msg'></span>";
            }
            ?>
        </div>

        <form method="POST" action="" id="form-update-password" class="form-login">
            <div class="row">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" onkeyup="passwordStrength()" placeholder="Digite a nova senha" autocomplete="on" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>" required>
            </div>

            <span id="msgViewStrength"><br><br></span>

            <div class="row button">
                <button type="submit" name="SendUpPass" value="Salvar">Salvar</button>
            </div>
            
            <div class="signup-link">
                <a href="<?php echo URLADM ?>">Clique Aqui </a>para acessar
            </div>
        </form>
    </div>
</div>