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
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Imagem</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-users/index' class='btn-info'>Listar</a> ";
                if (isset($valorForm['id'])) {
                    echo "<a href='" . URLADM . "view-users/index/" . $valorForm['id'] . "' class='btn-primary'>Visualizar</a><br><br>";
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

            <form method="POST" action="" id="form-edit-user-image" class="form-adm" enctype="multipart/form-data">
                <div class="row-input">
                    <div class="column">
                        <input type="hidden" name="id" id="id" value="<?php printf($valorForm['id']) ?>">
                        <label><span style="color: #f00;">*</span>Imagem 300x300:</label>
                        <input type="file" name="new_image" id="new_image" onchange="inputFileValImg()"><br><br>
                    </div>

                    <div class="column">
                        <?php
                        if ((!empty($valorForm['image'])) and (file_exists("app/adms/assets/image/users/" . $valorForm['id'] . "/" . $valorForm['image']))) {
                            $old_image = URLADM . "app/adms/assets/image/users/" . $valorForm['id'] . "/" . $valorForm['image'];
                        } else {
                            $old_image = URLADM . "app/adms/assets/image/users/icon_user.png";
                        }
                        ?>
                        <span id="preview-img">
                            <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px;">
                        </span><br><br>
                    </div>
                </div>
                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>
                <button type="submit" name="SendEditImageUser" class="btn-warning" value="Salvar">Salvar</button>
            </form>
        </div>
    </div>
</div>