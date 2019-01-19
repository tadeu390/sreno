<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 12/01/2019
 * Time: 02:03
 */
?>

<?php $this->load->helper("permissao");?>
<?php $this->load->helper("paginacao");?>
<?php $this->load->helper("mstring");?>
<br /><br />
<div class='row padding20 text-white relative' style="width: 95%; left: 3.5%">
	<?php
    	echo"<div class='col-lg-12 padding0'>";
			echo"<nav aria-label='breadcrumb'>";
  				echo"<ol class='breadcrumb'>";
    				echo "<li class='breadcrumb-item active' aria-current='page'>".(($method == 'orcamento') ? "Orçamentos" : "Ordens de serviços")."</li>";
    			echo "</ol>";
			echo"</nav>";
		echo "</div>";

		//$atr = array("id" => "form_filtros", "name" => "form_filtros","class" => "col-lg-10 offset-lg-1 padding20 background_dark", "method" => "get");
		//echo form_open("$controller/index/?".$paginacao['field']."/".(($paginacao['order'] == 'ASC') ? 'DESC' : 'ASC'), $atr);

		//$this->load->view("usuario/_filtro", $filtros);

		//echo "</form>";
    ?>
	<input type='hidden' id='controller' value='<?php echo $controller; ?>'/>
	<?php
		echo "<div class='col-lg-12 padding background_dark' style='margin-top: 10px;'>";
			echo "<div class='table-responsive'>";
				echo "<table class='table table-striped table-hover text-white'>";
					echo "<thead>";
						echo"<tr>";
							echo"<td colspan='5' style='font-size: 12px;'>";
							if(isset($ocos[0]->Size))
								echo "A busca retornou ".$ocos[0]->Size." registro(s)";
							else
								echo "A busca não obteve resultados.";
							echo"</td>";
						echo"</tr>";
						echo"<tr>";
							echo"<td class='text-right' colspan='5'>";
							if(permissao::get_permissao(CREATE, $controller) && $method == 'orcamento')
								echo"<a class='btn btn-danger' href='".$url."$controller/create/0/'><span class='glyphicon glyphicon-plus'></span> Novo orçamento </a>";
							echo"</td>";
						echo"</tr>";
						echo "<tr>";
							echo "<td>#</td>";
							echo "<td>";
								echo"<a id='col-list' href='".$url."$controller/".$method."/".$paginacao['pg_atual']."/Nome_produto/".$paginacao['order']."'>Produto</a>";
								if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Nome_produto')
									echo "&nbsp;<div class='fa fa-chevron-down'></div>";
								else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Nome_produto')
									echo "&nbsp;<div class='fa fa-chevron-up'></div>";
							echo"</td>";
							echo "<td>";
								echo "<a id='col-list' href='".$url."$controller/".$method."/".$paginacao['pg_atual']."/Tipo_servico/".$paginacao['order']."'>Serviço</a>";
								if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Tipo_servico')
									echo "&nbsp;<div class='fa fa-chevron-down'></div>";
								else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Tipo_servico')
									echo "&nbsp;<div class='fa fa-chevron-up'></div>";
							echo "</td>";
                            echo "<td>";
                            echo "<a id='col-list' href='".$url."$controller/".$method."/".$paginacao['pg_atual']."/Status_id/".$paginacao['order']."'>Status</a>";
                            if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Status_id')
                                echo "&nbsp;<div class='fa fa-chevron-down'></div>";
                            else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Status_id')
                                echo "&nbsp;<div class='fa fa-chevron-up'></div>";
                            echo "</td>";
							//echo "<td>E-mail</td>";
							//echo "<td>Grupo</td>";
							echo "<td class='text-right'>Ações</td>";
						echo "<tr>";
					echo "</thead>";
					echo "<tbody>";
						for($i = 0; $i < count($ocos); $i++)
						{
							$cor = "";
							if($ocos[$i]->Ativo == 0)
								$cor = "class='text-danger'";
							echo "<tr $cor>";
								echo "<td>".($i + 1)."</td>";
								echo "<td><span title='".$ocos[$i]->Nome_produto."'>".
								mstring::corta_string($ocos[$i]->Nome_produto, 25)
								."</span></td>";
								echo "<td $cor>".(($ocos[$i]->Tipo_servico == 1) ? "Fabricação" : "Reparo" )."</td>";
								echo "<td $cor>".$ocos[$i]->Status->Nome_status."</td>";
								echo "<td class='text-right'>";
									if(permissao::get_permissao(UPDATE, $controller))
										echo "<a href='".$url.$controller."/".(($method == 'orcamento') ? "edit" : "edit_os")."/".$ocos[$i]->Ocos_id."' title='Editar' style='cursor: pointer;' class='glyphicon glyphicon-edit text-danger'></a> | ";
									if(permissao::get_permissao(DELETE, $controller))
										echo " <span onclick='Main.confirm_delete(". $ocos[$i]->Ocos_id .");' id='sp_lead_trash' name='sp_lead_trash' title='Apagar' style='cursor: pointer;' class='glyphicon glyphicon-trash text-danger'></span>";
								echo "</td>";
							echo "</tr>";
						}
					echo "</tbody>";
				echo "</table>";
			echo "</div>";
			paginacao::get_paginacao($paginacao, $controller);
		echo "</div>";
	?>
</div>