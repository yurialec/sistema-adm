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
            <span>Área Restrita</span>
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

        <span id="msg"></span>

        <form method="POST" action="" class="form-login" id="form-login">
            <div class="row">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="user" id="user" placeholder="Digite o susuário" value="<?php isset($valorForm['user']) ? printf($valorForm['user']) : null ?>">
            </div>
            <div class="row">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Digite a senha" autocomplete="on" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>">
            </div>
            <div class="row button">
                <button type="submit" name="SendLogin" value="Acessar">Acessar</button>
            </div>
            <div class="signup-link">
                <a href="<?php echo URLADM ?>new-user/index">Cadastrar</a> -
                <a href="<?php echo URLADM ?>recover-password/index">Esqueceu a senha?</a>
            </div>
        </form>
    </div>
</div>