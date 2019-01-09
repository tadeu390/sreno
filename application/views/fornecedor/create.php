<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 26/12/2018
 * Time: 22:50
 */
?>

<br /><br />
<div class='row padding20 text-white relative' style="width: 95%; left: 3.5%">
    <?php
        echo"<div class='col-lg-12 padding0'>";
            echo"<nav aria-label='breadcrumb'>";
                echo"<ol class='breadcrumb'>";
                    echo"<li class='breadcrumb-item'><a href='".$url."fornecedor'>Fornecedores</a></li>";
                    echo "<li class='breadcrumb-item active' aria-current='page'>".((isset($obj->Id)) ? 'Editar fornecedor' : 'Novo fornecedor')."</li>";
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
            echo "<input type='hidden' id='id' name='id' value='".$obj_fornecedor->Fornecedor_id."'>";
            echo "<input type='hidden' id='endereco_id' name='endereco_id' value='".$Endereco['Endereco_id']."'>";

        ?>
            <input type='hidden' id='controller' value='<?php echo $controller; ?>'/>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="nome" name="nome" value='<?php echo (!empty($obj_fornecedor->Nome_fantasia) ? $obj_fornecedor->Nome_fantasia:''); ?>' type="text" class="input-material">
                        <label for="nome" class="label-material">Nome fantasia</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-nome'></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="cnpj" name="cnpj" value='<?php echo (!empty($obj_fornecedor->Cnpj) ? $obj_fornecedor->Cnpj:''); ?>' type="text" class="input-material">
                        <label for="cnpj" class="label-material">Cnpj</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-cnpj'></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="email" name="email" value='<?php echo (!empty($obj_fornecedor->Email) ? $obj_fornecedor->Email:''); ?>' type="text" class="input-material">
                        <label for="email" class="label-material">E-mail</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-email'></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="razao_social" name="razao_social" value='<?php echo (!empty($obj_fornecedor->Razao_social) ? $obj_fornecedor->Razao_social:''); ?>' type="text" class="input-material">
                        <label for="razao_social" class="label-material">Razão social</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-razao_social'></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="celular" name="celular" value='<?php echo (!empty($obj_fornecedor->Celular) ? $obj_fornecedor->Celular:''); ?>' type="text" class="input-material">
                        <label for="celular" class="label-material">Celular</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-celular'></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="telefone" name="telefone" value='<?php echo (!empty($obj_fornecedor->Telefone) ? $obj_fornecedor->Telefone:''); ?>' type="text" class="input-material">
                        <label for="telefone" class="label-material">Telefone</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-telefone'></div>
                    </div>
                </div>
            </div>
            <fieldset>
                <legend>&nbsp;Endereço</legend>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group relative">
                            <input maxlength="100" id="rua" spellcheck="false" name="rua" value='<?php echo (!empty($Endereco['Rua']) ? $Endereco['Rua']:''); ?>' type="text" class="input-material">
                            <label for="rua" class="label-material">Rua</label>
                            <div class='input-group mb-2 mb-sm-0 text-danger' id='error-rua'></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group relative">
                            <input maxlength="40" id="cidade" spellcheck="false" name="cidade" value='<?php echo (!empty($Endereco['Cidade']) ? $Endereco['Cidade']:''); ?>' type="text" class="input-material">
                            <label for="cidade" class="label-material">Cidade</label>
                            <div class='input-group mb-2 mb-sm-0 text-danger' id='error-cidade'></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group relative">
                            <input maxlength="40" id="bairro" spellcheck="false" name="bairro" value='<?php echo (!empty($Endereco['Bairro']) ? $Endereco['Bairro']:''); ?>' type="text" class="input-material">
                            <label for="bairro" class="label-material">Bairro</label>
                            <div class='input-group mb-2 mb-sm-0 text-danger' id='error-bairro'></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group relative">
                            <input maxlength="40" id="numero" spellcheck="false" name="numero" value='<?php echo (!empty($Endereco['Numero']) ? $Endereco['Numero']:''); ?>' type="text" class="input-material">
                            <label for="numero" class="label-material">Número</label>
                            <div class='input-group mb-2 mb-sm-0 text-danger' id='error-numero'></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group relative">
                            <input maxlength="40" id="complemento" spellcheck="false" name="complemento" value='<?php echo (!empty($Endereco['Complemento']) ? $Endereco['Complemento']:''); ?>' type="text" class="input-material">
                            <label for="complemento" class="label-material">Complemento</label>
                            <div class='input-group mb-2 mb-sm-0 text-danger' id='error-complemento'></div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br />
        <div class='form-group'>
            <div class='checkbox checbox-switch switch-success custom-controls-stacked'>
                <?php
                $checked = "";
                if(isset($obj_fornecedor->Ativo) && $obj_fornecedor->Ativo == 1)
                    $checked = "checked";

                echo"<label for='ativo' class='text-white'>";
                echo "<input type='checkbox' $checked id='ativo' name='ativo' value='1' /><span></span> Fornecedor ativo";
                echo"</label>";
                ?>
            </div>
        </div>
            <?php
                if(empty($obj_fornecedor->Fornecedor_id))
                    echo"<input type='submit' class='btn btn-danger btn-block' style='width: 200px;' value='Cadastrar'>";
                else
                    echo"<input type='submit' class='btn btn-danger btn-block' style='width: 200px;' value='Atualizar'>";
                ?>
        </form>
    </div>
</div>