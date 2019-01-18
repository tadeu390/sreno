<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 27/12/2018
 * Time: 22:28
 */
?>

<br /><br />
<div class='row padding20 text-white relative' style="width: 95%; left: 3.5%">
    <?php
    echo"<div class='col-lg-12 padding0'>";
    echo"<nav aria-label='breadcrumb'>";
    echo"<ol class='breadcrumb'>";
    echo"<li class='breadcrumb-item'><a href='".$url."peca'>Peças</a></li>";
    echo "<li class='breadcrumb-item active' aria-current='page'>".((isset($obj->Peca_id)) ? 'Editar peça' : 'Nova peça')."</li>";
    echo "</ol>";
    echo"</nav>";
    echo "</div>";
    ?>
    <div class='col-lg-12 padding background_dark'>
        <div>
            <a href='javascript:window.history.go(-1)' title='Voltar'>
                <span class='glyphicon glyphicon-arrow-left text-white' style='font-size: 25px;'></span>
            </a>
        </div>
        <br /><br />
        <?php $atr = array("id" => "form_cadastro_$controller", "name" => "form_cadastro");
            echo form_open("$controller/store", $atr);
        ?>
        <input type='hidden' id='id' name='id' value='<?php if(!empty($obj->Peca_id)) echo $obj->Peca_id; ?>'/>
        <input type='hidden' id='controller' value='<?php echo $controller; ?>'/>

        <div class="form-group relative">
            <input maxlength="100" id="nome" name="nome" value='<?php echo (!empty($obj->Nome_peca) ? $obj->Nome_peca:''); ?>' type="text" class="input-material">
            <label for="nome" class="label-material">Nome</label>
            <div class='input-group mb-2 mb-sm-0 text-danger' id='error-nome'></div>
        </div>
        <div class='form-group'>
            <?php
            echo"<select name='categoria_id' id='categoria_id' class='form-control padding0'>";
            echo"<option value='0' class='background_dark'>Selecione uma categoria</option>";

            for($i = 0; $i < count($obj_categoria); $i++)
            {
                $selected = "";
                if(isset($obj->Categoria_id) && $obj_categoria[$i]->Categoria_id == $obj->Categoria_id)
                    $selected = "selected";

                echo"<option class='background_dark' $selected value='". $obj_categoria[$i]->Categoria_id ."'>".$obj_categoria[$i]->Nome_categoria."</option>";
            }
            echo "</select>";
            ?>
            <div class='input-group mb-2 mb-sm-0 text-danger' id='error-categoria_id'></div>
        </div>
        <div class='form-group'>
            <?php
            echo"<select name='estocado_em' id='estocado_em' class='form-control padding0'>";
            echo"<option value='0' class='background_dark'>Estoque em</option>";
                $selectedMt = "";
                $selectedQtd = "";
                if(isset($obj->Estocado_em) && $obj->Estocado_em == 'metro(s)')
                    $selectedMt = "selected";
                else if(isset($obj->Estocado_em) && $obj->Estocado_em == 'unidade(s)')
                    $selectedQtd = "selected";
                echo"<option class='background_dark' ".$selectedMt." value='metro(s)'>Em metro(s)</option>";
                echo"<option class='background_dark' ".$selectedQtd." value='unidade(s)'>Em unidade(s)</option>";
            echo "</select>";
            ?>
            <div class='input-group mb-2 mb-sm-0 text-danger' id='error-estocado_em'></div>
        </div>
        <div class='form-group'>
            <div class='checkbox checbox-switch switch-success custom-controls-stacked'>
                <?php
                $checked = "checked";
                if(isset($obj->Ativo) && $obj->Ativo == 0)
                    $checked = "";

                echo"<label for='ativo' class='text-white'>";
                echo "<input type='checkbox' $checked id='ativo' name='ativo' value='1' /><span></span> Peça ativa";
                echo"</label>";
                ?>
            </div>
        </div>

        <?php
        if(empty($obj->Id))
            echo"<input type='submit' class='btn btn-danger btn-block' style='width: 200px;' value='Cadastrar'>";
        else
            echo"<input type='submit' class='btn btn-danger btn-block' style='width: 200px;' value='Atualizar'>";
        ?>
        </form>
    </div>
</div>