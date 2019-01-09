<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 26/12/2018
 * Time: 22:35
 */
?>
<?php $this->load->helper("permissao");?>
<?php $this->load->helper("paginacao");?>
<?php $this->load->helper("mstring");?>
<br /><br />
<div class='row padding20 text-white'>
	<?php
    	echo"<div class='col-lg-10 offset-lg-1 padding0'>";
			echo"<nav aria-label='breadcrumb'>";
  				echo"<ol class='breadcrumb'>";
    				echo "<li class='breadcrumb-item active' aria-current='page'>Fornecedores</li>";
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
		echo "<div class='col-lg-10 offset-lg-1 padding background_dark' style='margin-top: 10px;'>";
			echo "<div class='table-responsive'>";
				echo "<table class='table table-striped table-hover text-white'>";
					echo "<thead>";
						echo"<tr>";
							echo"<td colspan='4' style='font-size: 12px;'>";
							if(!empty($fornecedores[0]->Size))
								echo "A busca retornou ".$fornecedores[0]->Size." registro(s)";
							else
								echo "A busca não obteve resultados.";
							echo"</td>";
						echo"</tr>";
						echo"<tr>";
							echo"<td class='text-right' colspan='4'>";
							if(permissao::get_permissao(CREATE, $controller))
								echo"<a class='btn btn-danger' href='".$url."$controller/create/0/'><span class='glyphicon glyphicon-plus'></span> Novo fornecedor</a>";
							echo"</td>";
						echo"</tr>";
						echo "<tr>";
							echo "<td>#</td>";
							echo "<td>";
								echo"<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Nome_fantasia/".$paginacao['order']."'>Nome fantasia</a>";
								if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Nome_fantasia')
									echo "&nbsp;<div class='fa fa-chevron-down'></div>";
								else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Nome_fantasia')
									echo "&nbsp;<div class='fa fa-chevron-up'></div>";
							echo"</td>";
							echo "<td>";
								echo "<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Ativo/".$paginacao['order']."'>Ativo</a>";
								if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Ativo')
									echo "&nbsp;<div class='fa fa-chevron-down'></div>";
								else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Ativo')
									echo "&nbsp;<div class='fa fa-chevron-up'></div>";
							echo "</td>";
							//echo "<td>E-mail</td>";
							//echo "<td>Grupo</td>";
							echo "<td class='text-right'>Ações</td>";
						echo "<tr>";
					echo "</thead>";
					echo "<tbody>";
						for($i = 0; $i < count($fornecedores); $i++)
						{
							$cor = "";
							if($fornecedores[$i]->Ativo == 0)
								$cor = "class='text-danger'";
							echo "<tr $cor>";
								echo "<td>".($i + 1)."</td>";
								echo "<td><span title='".$fornecedores[$i]->Nome_fantasia."'>".
								mstring::corta_string($fornecedores[$i]->Nome_fantasia, 25)
								."</span></td>";
								echo "<td>".(($fornecedores[$i]->Ativo == 1) ? 'Sim' : 'Não')."</td>";
								//echo "<td $cor>".$fornecedores[$i]['email']."</td>";
								//echo "<td $cor>".$fornecedores[$i]['nome_grupo']."</td>";
								echo "<td class='text-right'>";
									if(permissao::get_permissao(UPDATE, $controller))
										echo "<a href='".$url.$controller."/edit/".$fornecedores[$i]->Fornecedor_id."' title='Editar' style='cursor: pointer;' class='glyphicon glyphicon-edit text-danger'></a> | ";
									echo "<a href='".$url.$controller."/detalhes/".$fornecedores[$i]->Fornecedor_id."' title='Detalhes' style='cursor: pointer;' class='glyphicon glyphicon-th text-danger'></a> | ";
									if(permissao::get_permissao(DELETE, $controller))
										echo " <span onclick='Main.confirm_delete(". $fornecedores[$i]->Fornecedor_id .");' id='sp_lead_trash' name='sp_lead_trash' title='Apagar' style='cursor: pointer;' class='glyphicon glyphicon-trash text-danger'></span>";
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