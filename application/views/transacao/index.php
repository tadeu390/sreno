<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 27/12/2018
 * Time: 22:24
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
    				echo "<li class='breadcrumb-item active' aria-current='page'>Transações</li>";
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
							echo"<td colspan='6' style='font-size: 12px;'>";
							if(!empty($transacoes[0]->Size))
								echo "A busca retornou ".$transacoes[0]->Size." registro(s)";
							else
								echo "A busca não obteve resultados.";
							echo"</td>";
						echo"</tr>";
						echo"<tr>";
							echo"<td class='text-right' colspan='6'>";
							if(permissao::get_permissao(CREATE, $controller))
								echo"<a class='btn btn-danger' href='".$url."$controller/create/0/'><span class='glyphicon glyphicon-plus'></span> Nova transação</a>";
							echo"</td>";
						echo"</tr>";
						echo "<tr>";
							echo "<td>#</td>";
                            echo "<td>";
                                echo "<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Data_registro/".$paginacao['order']."'>Data do registro</a>";
                                if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Data_registro')
                                    echo "&nbsp;<div class='fa fa-chevron-down'></div>";
                                else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Data_registro')
                                    echo "&nbsp;<div class='fa fa-chevron-up'></div>";
                            echo "</td>";
                            echo "<td>";
                            echo "<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Peca_id/".$paginacao['order']."'>Peça</a>";
                            if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Peca_id')
                                echo "&nbsp;<div class='fa fa-chevron-down'></div>";
                            else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Peca_id')
                                echo "&nbsp;<div class='fa fa-chevron-up'></div>";
                            echo "</td>";
							echo "<td>";
								echo"<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Quantidade/".$paginacao['order']."'>Quantidade</a>";
								if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Quantidade')
									echo "&nbsp;<div class='fa fa-chevron-down'></div>";
								else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Quantidade')
									echo "&nbsp;<div class='fa fa-chevron-up'></div>";
							echo"</td>";
							echo "<td>";
								echo "<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Preco_unitario/".$paginacao['order']."'>Preço unitário / metro</a>";
								if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Preco_unitario')
									echo "&nbsp;<div class='fa fa-chevron-down'></div>";
								else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Preco_unitario')
									echo "&nbsp;<div class='fa fa-chevron-up'></div>";
							echo "</td>";
							//echo "<td>E-mail</td>";
							//echo "<td>Grupo</td>";
							echo "<td class='text-right'>Ações</td>";
						echo "<tr>";
					echo "</thead>";
					echo "<tbody>";
						for($i = 0; $i < count($transacoes); $i++)
						{
                            $cor = "";
                            if($transacoes[$i]->Ativo == 0)
                                $cor = "class='text-danger'";
							echo "<tr $cor>";
								echo "<td>".($i + 1)."</td>";
                                echo "<td>".
                                        $transacoes[$i]->Data_registro." 
                                </td>";
                                echo "<td>
                                    ".$transacoes[$i]->Peca->Nome_peca."
                                </td>";
								echo "<td>";
                                    echo"<span title='".$transacoes[$i]->Quantidade."'>".
								          $transacoes[$i]->Quantidade
                                    ."</span> ".$transacoes[$i]->Peca->Estocado_em;
                                    if($transacoes[$i]->Quantidade > 0)
                                        echo " <span class='fa fa-arrow-up text-warning'></span>";
                                    else
                                        echo" <span class='fa fa-arrow-down text-danger'></span>";
                                echo"</td>";
                                echo "<td>
                                    <span title='".$transacoes[$i]->Preco_unitario."'> R$ ";
                                        echo number_format(round($transacoes[$i]->Preco_unitario, 2),2, ',', ' ');
                                    echo "</span>
                                </td>";
								echo "<td class='text-right'>";
									if(permissao::get_permissao(UPDATE, $controller))
										echo "<a href='".$url.$controller."/edit/".$transacoes[$i]->Transacao_id."' title='Editar' style='cursor: pointer;' class='glyphicon glyphicon-edit text-danger'></a> | ";
									if(permissao::get_permissao(DELETE, $controller))
										echo " <span onclick='Main.confirm_delete(". $transacoes[$i]->Transacao_id .");' id='sp_lead_trash' name='sp_lead_trash' title='Apagar' style='cursor: pointer;' class='glyphicon glyphicon-trash text-danger'></span>";
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