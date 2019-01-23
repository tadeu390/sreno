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
<div class='row padding20 text-white relative' style="width: 95%; left: 3.5%">
	<?php
    	echo"<div class='col-lg-12 padding0'>";
			echo"<nav aria-label='breadcrumb'>";
  				echo"<ol class='breadcrumb'>";
    				echo "<li class='breadcrumb-item active' aria-current='page'>Estoque</li>";
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
							echo"<td colspan='2' style='font-size: 12px;'>";
							if(!empty($estoque[0]->Size))
								echo "A busca retornou ".$estoque[0]->Size." registro(s)";
							else
								echo "A busca não obteve resultados.";
							echo"</td>";
							echo "<td colspan='3' class='text-right'>";
							    echo "Total geral do estoque: R$ " . $estoque[0]->Total_estoque_geral;
							echo "</td>";
						echo"</tr>";
						echo "<tr>";
							echo "<td style='width: 10%;'>#</td>";
                            echo "<td>";
                                echo "<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Nome_peca/".$paginacao['order']."'>Peça</a>";
                                if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Nome_peca')
                                    echo "&nbsp;<div class='fa fa-chevron-down'></div>";
                                else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Nome_peca')
                                    echo "&nbsp;<div class='fa fa-chevron-up'></div>";
                            echo "</td>";
							echo "<td>";
								echo"<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Saldo/".$paginacao['order']."'>Saldo</a>";
								if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Saldo')
									echo "&nbsp;<div class='fa fa-chevron-down'></div>";
								else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Saldo')
									echo "&nbsp;<div class='fa fa-chevron-up'></div>";
							echo"</td>";
							echo "<td>";
								echo "<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Preco_medio_unitario/".$paginacao['order']."'>Preço médio unitário / metro</a>";
								if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Preco_medio_unitario')
									echo "&nbsp;<div class='fa fa-chevron-down'></div>";
								else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Preco_medio_unitario')
									echo "&nbsp;<div class='fa fa-chevron-up'></div>";
							echo "</td>";
                            echo "<td>";
                            echo "<a id='col-list' href='".$url."$controller/index/".$paginacao['pg_atual']."/Total_estoque/".$paginacao['order']."'>Total</a>";
                            if($paginacao['order'] == 'DESC' && $paginacao['field'] == 'Total_estoque')
                                echo "&nbsp;<div class='fa fa-chevron-down'></div>";
                            else if($paginacao['order'] == 'ASC' && $paginacao['field'] == 'Total_estoque')
                                echo "&nbsp;<div class='fa fa-chevron-up'></div>";
                            echo "</td>";
						echo "<tr>";
					echo "</thead>";
					echo "<tbody>";
						for($i = 0; $i < count($estoque); $i++)
						{
							$cor = "";
							echo "<tr $cor>";
								echo "<td>".($i + 1)."</td>";
                                echo "<td>
                                    <span title='".$estoque[$i]->Nome_peca."'>".
                                        mstring::corta_string($estoque[$i]->Nome_peca, 25)
                                ."</span>
                                </td>";
								echo "<td>";
								    echo $estoque[$i]->Saldo." ".$estoque[$i]->Estocado_em;
                                echo"</td>";
                                echo "<td>";
                                    echo "R$ ".number_format(round($estoque[$i]->Preco_medio_unitario, 2),2, ',', '.');
                                echo "</td>";
                                echo "<td>";
                                    echo "R$ ".number_format(round($estoque[$i]->Total_estoque, 2),2, ',', '.');
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