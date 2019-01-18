<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 12/01/2019
 * Time: 02:03
 */
?>

<style>
    .table tbody tr:hover
    {
        background-color: #3938362e !important;
    }
</style>
<br /><br />
<div class='row padding20 text-white relative' style="width: 95%; left: 3.5%">
    <?php
    echo"<div class='col-lg-12 padding0'>";
    echo"<nav aria-label='breadcrumb'>";
    echo"<ol class='breadcrumb'>";
    echo"<li class='breadcrumb-item'><a href='".$url."ocos/".(($method == 'edit_os') ? "os" : "orcamento")."'>".(($method == 'edit_os') ? "Ordens de serviços" : "Orçamentos")."</a></li>";
    echo "<li class='breadcrumb-item active' aria-current='page'>".((isset($obj->Ocos_id)) ? 'Editar '.(($method == 'edit_os') ? "ordem de serviço" : "orçamento") : 'Novo orçamento '.(($method == 'edit_os') ? "ordem de serviço" : "orçamento"))."</li>";
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

        <input type='hidden' id='id' name='id' value='<?php if(!empty($obj->Ocos_id)) echo $obj->Ocos_id; ?>'/>
        <input type='hidden' id='controller' value='<?php echo $controller; ?>'/>

        <div class="row">
            <div class="col-lg-4">
                <div class="form-group relative">
                    <input maxlength="100" id="nome" name="nome" value='<?php echo (!empty($obj->Nome_produto) ? $obj->Nome_produto:''); ?>' type="text" class="input-material">
                    <label for="nome" class="label-material">Produto</label>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-nome'></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class='form-group'>
                    <?php
                    echo"<select name='cliente_id' id='cliente_id' class='form-control padding0'>";
                    echo"<option value='0' class='background_dark'>Selecione um cliente</option>";

                    for($i = 0; $i < count($obj_cliente); $i++)
                    {
                        $selected = "";
                        if(isset($obj->Cliente_id) && $obj_cliente[$i]->Id == $obj->Cliente_id)
                            $selected = "selected";

                        echo"<option class='background_dark' $selected value='". $obj_cliente[$i]->Id ."'>".$obj_cliente[$i]->Nome_usuario."</option>";
                    }
                    echo "</select>";
                    ?>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-cliente_id'></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class='form-group'>
                    <?php
                    echo"<select name='tipo_servico' id='tipo_servico' class='form-control padding0'>";
                    echo"<option value='0' class='background_dark'>Tipo de serviço</option>";

                    $selected_fabr = "";
                    $selected_rep = "";

                    if(isset($obj->Tipo_servico) && $obj->Tipo_servico == 1)
                        $selected_fabr = "selected";
                    else if(isset($obj->Tipo_servico) && $obj->Tipo_servico == 2)
                        $selected_rep = "selected";

                    echo"<option value='1' ".$selected_fabr." class='background_dark'>Fabricação</option>";
                    echo"<option value='2' ".$selected_rep." class='background_dark'>Reparo</option>";
                    echo "</select>";
                    ?>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-tipo_servico'></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group relative" id="data1">
                    <input id="data_inicio" name="data_inicio" value='<?php echo (!empty($obj->Data_inicio) ? $obj->Data_inicio:''); ?>' type="text" class="input-material">
                    <label for="data_inicio" class="label-material">Data de início</label>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-data_inicio'></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group relative">
                    <input maxlength="100" id="tempo" name="tempo" value='<?php echo (!empty($obj->Tempo) ? $obj->Tempo:''); ?>' type="text" class="input-material">
                    <label for="tempo" class="label-material">Tempo necessário (dias)</label>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-tempo'></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group relative">
                    <input id="data_fim" name="data_fim" readonly="readonly" value='<?php echo (!empty($obj->Data_fim) ? $obj->Data_fim:''); ?>' type="text" class="input-material">
                    <label for="data_fim" class="label-material active">Data de término</label>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-data_fim'></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group relative">
                    <input readonly="readonly" id="criado_por" name="criado_por" value='<?php echo (!empty($obj->Criador->Nome_usuario) ? $obj->Criador->Nome_usuario:''); ?>' type="text" class="input-material">
                    <label for="criado_por" class="label-material">Criado por</label>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-criado_por'></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class='form-group'>
                    <?php
                    echo"<select name='usuario_responsavel' id='usuario_responsavel' class='form-control padding0'>";
                    echo"<option value='0' class='background_dark'>Selecione o usuário responsável</option>";

                    for($i = 0; $i < count($obj_responsavel); $i++)
                    {
                        $selected = "";
                        if(isset($obj->Usuario_responsavel_id) && $obj_responsavel[$i]->Id == $obj->Usuario_responsavel_id)
                            $selected = "selected";

                        echo"<option class='background_dark' $selected value='". $obj_responsavel[$i]->Id ."'>".$obj_responsavel[$i]->Nome_usuario."</option>";
                    }
                    echo "</select>";
                    ?>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-usuario_responsavel'></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class='form-group'>
                    <?php
                    echo"<select name='status_ocos' id='status_ocos' class='form-control padding0'>";
                    echo"<option value='0' class='background_dark'>Selecione o status</option>";

                    for($i = 0; $i < count($obj_status); $i++)
                    {
                        $selected = "";
                        if(isset($obj->Status_id) && $obj_status[$i]->Status_id == $obj->Status_id)
                            $selected = "selected";

                        echo"<option class='background_dark' $selected value='". $obj_status[$i]->Status_id ."'>".$obj_status[$i]->Nome_status."</option>";
                    }
                    echo "</select>";
                    ?>
                    <div class='input-group mb-2 mb-sm-0 text-danger' id='error-status_ocos'></div>
                </div>
            </div>
        </div>
        <fieldset>
            <legend>&nbsp;Peças</legend>
            <div class="row">
                <div class="col-lg-4">
                    <div class='form-group'>
                        <?php
                        echo"<select name='categoria_id_ocos' id='categoria_id_ocos' class='form-control padding0'>";
                        echo"<option value='0' class='background_dark'>Categoria</option>";

                        for($i = 0; $i < count($obj_categoria); $i++)
                        {
                            echo"<option class='background_dark' value='". $obj_categoria[$i]->Categoria_id ."'>".$obj_categoria[$i]->Nome_categoria."</option>";
                        }
                        echo "</select>";
                        ?>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-categoria_id_ocos'></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class='form-group'>
                        <?php
                        echo"<select name='peca_id_ocos' id='peca_id_ocos' class='form-control padding0'>";
                            echo"<option value='0' class='background_dark'>Peças</option>";
                        echo "</select>";
                        ?>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-peca_id_ocos'></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="qtd_ocos" spellcheck="false" name="qtd_ocos" type="text" class="input-material">
                        <label for="qtd_ocos" class="label-material">Quantidade</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-qtd_ocos'></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" readonly="readonly" id="preco_unitario_ocos" spellcheck="false" name="preco_unitario_ocos" type="text" class="input-material">
                        <label for="preco_unitario_ocos" class="label-material active">Preço unitário (R$)</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-preco_unitario_ocos'></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="total" readonly="readonly" spellcheck="false" name="total" type="text" class="input-material">
                        <label for="total" class="label-material active">Total (R$)</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-total'></div>
                    </div>
                </div>
                <div class="col-lg-4 align-center">
                    <input type='button' class='btn btn-danger btn-block' value='Adicionar' id="bt_add_peca">
                </div>
            </div>
        </fieldset>
        <?php if(isset($analisa_preco) && $analisa_preco == 1) : ?>
            <br />
            <div  style="border: 1px solid white;" class="p-2 border_radius bg-warning text-center">
                <input type='button' id="bt_atualiza_preco" class='btn btn-danger btn-block' value='Atualizar preços' style="display: inline; width: auto;">
                <br />
                <br />
                <span class="text-danger">Foi detectado uma alteração no preço de estoque de algumas peças. Clique no botão para atualizar o preço das peças adicionadas.</span>
            </div>
        <?php endif; ?>
        <br />
        <fieldset>
            <legend>&nbsp;Peças adicionadas</legend>
            <?php echo "<input type='hidden' id='qtd_peça_adicionado' name='qtd_peça_adicionado' value='".COUNT($obj->Linhas)."'>"; ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-hover background_white w-100" style="color: black;">
                            <thead>
                                <tr>
                                    <td>Categoria</td>
                                    <td>Peça</td>
                                    <td>Quantidade</td>
                                    <td>Preço unitário (R$)</td>
                                    <td>Total (R$)</td>
                                    <td class="text-center">Remover</td>
                                </tr>
                            </thead>
                            <tbody id="table_peça_adicionado" style="color: black;">
                                <?php
                                    for($i = 0; $i < COUNT($obj->Linhas); $i++)
                                    {
                                        echo"<tr id='peça_id_ocos_adicionado_linha".$i."'>";
                                            echo"<td>";
                                                echo"<input type='text' value='".$obj->Linhas[$i]->Peca->Categoria->Nome_categoria."' readonly='readonly' id='categoria_id_ocos_adicionado_col0_lin".$i."' name='categoria_id_ocos_adicionado_col0_lin".$i."' class='form-control background_white'>";
                                            echo"</td>";
                                            echo"<td>";
                                                echo"<input type='hidden' value='".$obj->Linhas[$i]->Linha_id."' name='linha_id_ocos".$i."' id='linha_id_ocos".$i."'>";
                                                echo"<input type='hidden' value='".$obj->Linhas[$i]->Peca_id."' name='peca_id_ocos_adicionado_hide_col1_lin".$i."' id='peca_id_ocos_adicionado_hide_col1_lin".$i."'>";
                                                echo"<input type='text' readonly='readonly' id='peca_id_ocos_adicionado_col1_lin".$i."' name='peca_id_ocos_adicionado_col1_lin".$i."' class='form-control background_white' value='".$obj->Linhas[$i]->Peca->Nome_peca."'>";
                                            echo"</td>";
                                            echo"<td>";
                                                echo "<input type='text' readonly='readonly' id='qtd_id_ocos_adicionado_col2_lin".$i."' name='qtd_id_ocos_adicionado_col2_lin".$i."' class='form-control background_white' value='".$obj->Linhas[$i]->Quantidade."'>";
                                            echo"</td>";
                                            echo"<td>";
                                                echo "<input type='text' readonly='readonly' id='preco_unitario_id_ocos_adicionado_col3_lin".$i."' name='preco_unitario_id_ocos_adicionado_col3_lin".$i."' class='form-control background_white' value='".number_format($obj->Linhas[$i]->Preco_unitario ,2, ',', ' ')."'>";
                                            echo"</td>";
                                            echo"<td>";
                                                echo "<input type='text' readonly='readonly' id='total_id_ocos_adicionado_col4_lin".$i."' name='total_id_ocos_adicionado_col4_lin".$i."' class='form-control background_white' value='".number_format($obj->Linhas[$i]->Preco_unitario * $obj->Linhas[$i]->Quantidade ,2, ',', ' ')."'>";
                                            echo"</td>";
                                            echo"<td style='vertical-align: middle;' class='text-center'>";
                                                echo "<span class='glyphicon glyphicon-remove text-danger' style='cursor: pointer;' title='Remover peça' onclick='Main.remove_elemento(\"peça_id_ocos_adicionado_linha".$i."\")'></span>";
                                            echo"</td>";
                                        echo"</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </fieldset>
        <br />
        <fieldset>
            <legend>&nbsp;Serviços</legend>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="descricao_servico" spellcheck="false" name="descricao_servico" type="text" class="input-material">
                        <label for="descricao_servico" class="label-material active">Descrição</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-descricao_servico'></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group relative">
                        <input maxlength="100" id="valor_servico" spellcheck="false" name="valor_servico" type="text" class="input-material">
                        <label for="valor_servico" class="label-material active">Valor (R$)</label>
                        <div class='input-group mb-2 mb-sm-0 text-danger' id='error-valor_servico'></div>
                    </div>
                </div>
                <div class="col-lg-4 align-center">
                    <input type='button' class='btn btn-danger btn-block' value='Adicionar' id="bt_add_servico">
                </div>
            </div>
        </fieldset>
        <br />
        <fieldset>
            <legend>&nbsp;Serviços adicionados</legend>
            <?php echo "<input type='hidden' id='qtd_serviço_adicionado' name='qtd_serviço_adicionado' value='".COUNT($obj->Servicos)."'>"; ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-hover background_white w-100">
                            <thead>
                            <tr>
                                <td style="width: 70%;">Descrição</td>
                                <td style="width: 20%;">Valor</td>
                                <td style="width: 10%;" class="text-center">Remover</td>
                            </tr>
                            </thead>
                            <tbody id="table_serviço_adicionado" style="color: black;">
                                <?php
                                    for($i = 0; $i < COUNT($obj->Servicos); $i++)
                                    {
                                        echo "<tr id='serviço_id_ocos_adicionado_linha".$i."'>";
                                            echo"<td>";
                                                echo"<input type='hidden' value='".$obj->Servicos[$i]->Servico_id."' name='servico_id_ocos".$i."' id='servico_id_ocos".$i."'>";
                                                echo "<input type='text' readonly='readonly' id='descricao_servico_id_ocos_adicionado_col0_lin".$i."' name='descricao_servico_id_ocos_adicionado_col0_lin".$i."' class='form-control background_white' value='".$obj->Servicos[$i]->Descricao."'>";
                                            echo"</td>";
                                            echo"<td>";
                                                echo"<input type='text' readonly='readonly' id='valor_servico_id_ocos_adicionado_col1_lin".$i."' name='valor_servico_id_ocos_adicionado_col1_lin".$i."' class='form-control background_white' value='".number_format($obj->Servicos[$i]->Valor ,2, ',', ' ')."'>";
                                            echo"</td>";
                                            echo "<td style='vertical-align: middle;' class='text-center'>";
                                                echo "<span class='glyphicon glyphicon-remove text-danger' style='cursor: pointer;' title='Remover serviço' onclick='Main.remove_elemento(\"serviço_id_ocos_adicionado_linha".$i."\")'></span>";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </fieldset>
        <br />
        <div class='form-group'>
            <div class='checkbox checbox-switch switch-success custom-controls-stacked'>
                <?php
                $checked = "checked";
                if(isset($obj->Ativo) && $obj->Ativo == 0)
                    $checked = "";

                echo"<label for='ativo' class='text-white'>";
                echo "<input type='checkbox' $checked id='ativo' name='ativo' value='1' /><span></span> ".($method == 'edit_os' ? 'Ordem de serviço ativa' : 'orçamento ativo');
                echo"</label>";
                ?>
            </div>
        </div>
        <?php if($method != 'edit_os') : ?>
            <div class='form-group'>
                <div class='checkbox checbox-switch switch-success custom-controls-stacked'>
                    <?php
                    echo"<label for='g_os' class='text-white'>";
                    echo "<input type='checkbox' id='g_os' name='g_os' value='0' /><span></span> Gerar ordem de serviço";
                    echo"</label>";
                    ?>
                </div>
            </div>
        <?php else : ?>
            <input type='hidden' value="1" id="g_os" name="g_os" />
        <?php endif; ?>
        <?php
        if(empty($obj->Ocos_id))
            echo"<input type='submit' class='btn btn-danger btn-block' style='width: 200px;' value='Cadastrar'>";
        else
            echo"<input type='submit' class='btn btn-danger btn-block' style='width: 200px;' value='Atualizar'>";
        ?>
        </form>
    </div>
</div>