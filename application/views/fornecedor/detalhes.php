<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 27/12/2018
 * Time: 22:04
 */
?>
<br /><br />
<div class='row padding20 text-white'>
	<?php
    	echo"<div class='col-lg-10 offset-lg-1 padding0'>";
			echo"<nav aria-label='breadcrumb'>";
  				echo"<ol class='breadcrumb'>";
    				echo"<li class='breadcrumb-item'><a href='".$url."fornecedor'>Fornecedores</a></li>";
    				echo "<li class='breadcrumb-item active' aria-current='page'>Detalhes</li>";
    			echo "</ol>";
			echo"</nav>";
		echo "</div>";
    ?>
	<?php
		echo "<div class='col-lg-10 offset-lg-1 background_dark'>";
			echo"<a href='javascript:window.history.go(-1)' class='link padding' title='Voltar'>";
				echo"<span class='glyphicon glyphicon-arrow-left text-white' style='font-size: 25px;'></span>";
			echo"</a>";
			echo "<br />";
			echo "<br />";
			echo "<div class='table-responsive'>";
				echo "<table class='table table-striped table-hover text-white'>";
					echo"</tr>";
					echo "<tr>";
						echo "<td>Nome fantasia</td>";
						echo "<td>".$obj->Nome_fantasia."</td>";
					echo"</tr>";
					echo"<tr>";
						echo "<td>Ativo</td>";
						echo "<td>".(($obj->Ativo == 1) ? 'Sim' : 'Não')."</td>";
					echo "</tr>";
					echo"<tr>";
						echo "<td>Data de registro</td>";
						echo "<td>".$obj->Data_registro."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Cnpj</td>";
						echo "<td>".$obj->Cnpj."</td>";
					echo "</tr>";
                    echo "<tr>";
                    echo "<td>Celular</td>";
                    echo "<td>".$obj->Celular."</td>";
                    echo "</tr>";
					echo "<tr>";
						echo "<td>Telefone</td>";
						echo "<td>".$obj->Telefone."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>E-mail</td>";
						echo "<td>".$obj->Email."</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>Razão social</td>";
						echo "<td>".$obj->Razao_social."</td>";
					echo "</tr>";
				echo "</table>";
                echo "<p>Endereço do fornecedor </p>";
                echo "<table class='table table-striped table-hover text-white'style='margin-bottom: 0px;'>";
                    echo "<tr>";
                        echo "<td style='width: 30%;'>";
                            echo "Rua";
                        echo "</td>";
                        echo "<td class='text-left'>";
                            echo $obj_endereco->Rua;
                        echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td style='width: 30%;'>";
                            echo "Cidade";
                        echo "</td>";
                        echo "<td class='text-left'>";
                            echo $obj_endereco->Cidade;
                        echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td style='width: 30%;'>";
                            echo "Bairro";
                        echo "</td>";
                        echo "<td class='text-left'>";
                            echo $obj_endereco->Bairro;
                        echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td style='width: 30%;'>";
                            echo "Número";
                        echo "</td>";
                        echo "<td class='text-left'>";
                            echo $obj_endereco->Numero;
                        echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td style='width: 30%;'>";
                            echo "Complemento";
                        echo "</td>";
                        echo "<td class='text-left'>";
                            echo $obj_endereco->Complemento;
                        echo "</td>";
                    echo "</tr>";
                echo "</table>";
			echo "</div>";
		echo "</div>";
	?>
</div>