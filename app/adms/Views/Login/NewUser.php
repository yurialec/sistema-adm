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
            <span>Novo Usuário</span>
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

        <form method="POST" action="" id="form-new-user" class="form-login">
            <div class="row">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="name" id="name" placeholder="Digite o nome" value="<?php isset($valorForm['name']) ? printf($valorForm['name']) : null ?>" required>
            </div>

            <div class="row">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Digite seu melhor e-mail" value="<?php isset($valorForm['email']) ? printf($valorForm['email']) : null ?>" required>
            </div>

            <div class="row">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php isset($valorForm['password']) ? printf($valorForm['password']) : null ?>" required>
            </div>

            <span id="msgViewStrength"><br><br></span>
            <div class="row button">
                <button type="submit" name="SendNewUser" value="Cadastrar">Cadastrar</button>
            </div>

            <div class="signup-link">
                <a href="<?php echo URLADM ?>">Clique Aqui </a>para acessar
            </div>
        </form>
    </div>
</div>