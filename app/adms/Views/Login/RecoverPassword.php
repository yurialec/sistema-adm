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
            <span>Recuperar Senha</span>
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

        <form method="POST" action="" id="form-recover-pass" class="form-login">
            <div class="row">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Digite o seu e-mail" value="<?php isset($valorForm['user']) ? printf($valorForm['user']) : null ?>">
            </div>

            <div class="row button">
                <button type="submit" name="SendRecoverPass" value="Recuperar">Recuperar</button>
            </div>

            <div class="signup-link">
                <a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar
            </div>
        </form>
    </div>
</div>