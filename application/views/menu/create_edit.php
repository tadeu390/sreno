<br /><br />
<div class='row padding20 text-white'>
	<?php
    	echo"<div class='col-lg-8 offset-lg-2 padding0'>";
			echo"<nav aria-label='breadcrumb'>";
  				echo"<ol class='breadcrumb'>";
    				echo"<li class='breadcrumb-item'><a href='".$url."menu'>Menus</a></li>";
    				echo "<li class='breadcrumb-item active' aria-current='page'>".((isset($obj['Id'])) ? 'Editar menu' : 'Novo menu')."</li>";
    			echo "</ol>";
			echo"</nav>";
		echo "</div>";
    ?>
	<div class='col-lg-8 offset-lg-2 padding background_dark'>
		<div>
			<a href='javascript:window.history.go(-1)' title='Voltar'>
				<span class='glyphicon glyphicon-arrow-left text-white' style='font-size: 25px;'></span>
			</a>
		</div>
		<br /><br />
			<?php $atr = array("id" => "form_cadastro_$controller", "name" => "form_cadastro"); 
				echo form_open("$controller/store", $atr); 
			?>
				<input type='hidden' id='id' name='id' value='<?php if(!empty($obj['Id'])) echo $obj['Id']; ?>'/>
				<input type='hidden' id='controller' value='<?php echo $controller; ?>'/>
				
				<div class="form-group relative">
					<input maxlength="20" id="nome" name="nome" value='<?php echo (!empty($obj['Nome']) ? $obj['Nome']:''); ?>' type="text" class="input-material">
					<label for="nome" class="label-material">Nome</label>
					<div class='input-group mb-2 mb-sm-0 text-danger' id='error-nome'></div>
				</div>

				<div class='form-group'>
						<div style="color: #8a8d93;">Ordem</div>
						<input name='ordem' min="1" id='ordem' value='<?php echo (!empty($obj['Ordem']) ? $obj['Ordem']:''); ?>' type='number' class='form-control' />
					<div class='input-group mb-2 mb-sm-0 text-danger' id='error-ordem'></div>
				</div>
				<div class='form-group'>
					<div class='checkbox checbox-switch switch-success custom-controls-stacked'>
						<?php
							$checked = "";
							if($obj['Ativo'] == 1)
								$checked = "checked";
							
							echo"<label for='menu_ativo' class='text-white'>";
								echo "<input type='checkbox' $checked id='menu_ativo' name='menu_ativo' value='1' /><span></span> Menu ativo";
							echo"</label>";
						?>
					</div>
				</div>
				
				<?php
					if(empty($obj['Id']))
						echo"<input type='submit' class='btn btn-danger btn-block' style='width: 200px;' value='Cadastrar'>";
					else
						echo"<input type='submit' class='btn btn-danger btn-block' style='width: 200px;' value='Atualizar'>";
				?>
			</form>
	</div>
</div>