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
                    echo"<li class='breadcrumb-item'><a href='".$url."transacao'>Transações</a></li>";
                    echo "<li class='breadcrumb-item active' aria-current='page'>".((isset($obj->Transacao_id)) ? 'Editar transação' : 'Nova transação')."</li>";
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
        <input type='hidden' id='id' name='id' value='<?php if(!empty($obj->Transacao_id)) echo $obj->Transacao_id; ?>'/>
        <input type='hidden' id='controller' value='<?php echo $controller; ?>'/>

        <div class="row">
            <div class="col-lg-6">
                <div class='form-group'>
                    <?php
                        echo"<select name='fornecedor_id' id='fornecedor_id' class='form-control padding0'>";
                        echo"<option value='0' class='background_dark'>Selecione um fornecedor</option>";

                        for($i = 0; $i < count($obj_fornecedor); $i++)
                        {
                            $selected = "";
                            if(isset($obj->Fornecedor_id) && $obj_fornecedor[$i]->Fornecedor_id == $obj->Fornecedor_id)
                                $selected = "selected";

                            echo"<option class='background_dark' $selected value='". $obj_fornecedor[$i]->Fornecedor_id ."'>".$obj_fornecedor[$i]->Nome_fantasia."</option>";
                        }
                        echo "</select>";
                    ?>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-fornecedor_id'></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class='form-group'>
                    <?php
                    echo"<select name='peca_id' id='peca_id' class='form-control padding0'>";
                    echo"<option value='0' class='background_dark'>Selecione uma peça</option>";

                    for($i = 0; $i < count($obj_peca); $i++)
                    {
                        $selected = "";
                        if(isset($obj->Peca_id) && $obj_peca[$i]->Peca_id == $obj->Peca_id)
                            $selected = "selected";

                        echo"<option class='background_dark' $selected value='". $obj_peca[$i]->Peca_id ."'>".$obj_peca[$i]->Nome_peca."</option>";
                    }
                    echo "</select>";
                    ?>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-peca_id'></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group relative">
                    <input maxlength="100" id="quantidade" name="quantidade" value='<?php echo (!empty($obj->Quantidade) ? $obj->Quantidade:''); ?>' type="text" class="input-material">
                    <label for="quantidade" class="label-material">Quantidade / tamanho</label>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-quantidade'></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group relative">
                    <input maxlength="100" id="preco_unitario" name="preco_unitario" value='<?php echo (!empty($obj->Preco_unitario) ? $obj->Preco_unitario:''); ?>' type="text" class="input-material">
                    <label for="preco_unitario" class="label-material">Preço unitário / metro (R$)</label>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-preco_unitario'></div>
                </div>
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