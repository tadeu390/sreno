<br /><br />
<div class='row padding20 text-white relative' style="width: 95%; left: 3.5%">
	    <?php
    	echo"<div class='col-lg-12 padding0'>";
			echo"<nav aria-label='breadcrumb'>";
  				echo"<ol class='breadcrumb'>";
    				echo"<li class='breadcrumb-item'><a href='".$url."usuario'>Usuários</a></li>";
    				echo "<li class='breadcrumb-item active' aria-current='page'>Detalhes</li>";
    			echo "</ol>";
			echo"</nav>";
		echo "</div>";
    ?>
	<?php
		echo "<div class='col-lg-12 background_dark'>";
			echo"<a href='javascript:window.history.go(-1)' class='padding' title='Voltar'>";
				echo"<span class='glyphicon glyphicon-arrow-left' style='font-size: 25px; color: white;'></span>";
			echo"</a>";
			echo "<br />";
			echo "<br />";
			echo "<div class='table-responsive'>";
				$this->load->view("usuario/_detalhes",$obj);
			echo "</div>";
		echo "</div>";
	?>
</div>