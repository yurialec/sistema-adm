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
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Grupo de Páginas</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-groups-pages/index' class='btn-info'>Listar</a> ";
                if (isset($valorForm['id'])) {
                    echo "<a href='" . URLADM . "view-group-page/index/" . $valorForm['id'] . "' class='btn-primary'>Visualizar</a><br><br>";
                }
                ?>
            </div>
        </div>

        <div class="content-adm-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <span id="msg"></span>
        </div>

        <div class="content-adm">
            <form method="POST" action="" id="form-edit-user" class="form-adm">
                <?php
                $id = "";
                if (isset($valorForm['id'])) {
                    $id = $valorForm['id'];
                }
                ?>
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

                <div class="column">
                    <?php
                    $name = "";
                    if (isset($valorForm['name'])) {
                        $name = $valorForm['name'];
                    }
                    ?>
                    <label class="title-input">Nome:</label>
                    <input type="text" name="name" id="name" class="input-adm" placeholder="Digite o nome do grupo" value="<?php echo $name; ?>">
                </div>
        </div>

        <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

        <button type="submit" name="SendEditGroupPage" class="btn-warning" value="Salvar">Salvar</button>

        </form>
    </div>
</div>
</div>
<!-- Fim do conteudo do administrativo -->