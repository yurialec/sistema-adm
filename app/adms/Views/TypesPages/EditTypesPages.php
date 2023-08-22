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
            <span class="title-content">Editar Tipos de Páginas</span>
            <div class="top-list-right">
                <?php
                echo "<a href='" . URLADM . "list-types-pgs/index' class='btn-info'>Listar</a> ";
                if (isset($valorForm['id'])) {
                    echo "<a href='" . URLADM . "view-types-pgs/index/" . $valorForm['id'] . "' class='btn-primary'>Visualizar</a><br><br>";
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

                <div class="row-input">
                    <div class="column">
                        <?php
                        $type = "";
                        if (isset($valorForm['type'])) {
                            $type = $valorForm['type'];
                        }
                        ?>
                        <label class="title-input">Tipo:<span class="text-danger">*</span></label>
                        <input type="text" name="type" id="type" class="input-adm" placeholder="Digite o nome completo" value="<?php echo $type; ?>" required>
                    </div>

                    <div class="column">
                        <?php
                        $name = "";
                        if (isset($valorForm['name'])) {
                            $name = $valorForm['name'];
                        }
                        ?>
                        <label class="title-input">Nome:</label>
                        <input type="text" name="name" id="name" class="input-adm" placeholder="Digite o apelido" value="<?php echo $name; ?>">
                    </div>
                    <div class="column">
                        <?php
                        $order_type_pg = "";
                        if (isset($valorForm['order_type_pg'])) {
                            $order_type_pg = $valorForm['order_type_pg'];
                        }
                        ?>
                        <label class="title-input">Ordem:<span class="text-danger">*</span></label>
                        <input type="text" name="order_type_pg" id="order_type_pg" class="input-adm" placeholder="Digite o nome completo" value="<?php echo $order_type_pg; ?>" required>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <?php
                        $obs = "";
                        if (isset($valorForm['obs'])) {
                            $obs = $valorForm['obs'];
                        }
                        ?>
                        <label class="title-input">Observação:</label>
                        <input type="text" name="obs" id="obs" class="input-adm" placeholder="Digite o nome completo" value="<?php echo $obs; ?>" required>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" name="SendEditTypePage" class="btn-warning" value="Salvar">Salvar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->