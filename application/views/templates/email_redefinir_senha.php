<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<?php echo"<link rel='shortcut icon' href='".$url."content/imagens/favicon.ico'>"; ?>
		<style>
			.fundo{
				background-image: url("<?php echo $url; ?>content/imagens/luz.png");
			}
			.fundo_content
			{
				background-image: url("<?php echo $url; ?>content/imagens/logo.png");
				background-repeat: no-repeat;
				background-position: center;
                background-size: 400px;
			}
			*{
				font-family: Gill Sans MT;
				padding: 0;
				margin: 0;
			}
		</style>
	</head>
	<body>
		<div>
			<div class="fundo" style="padding: 30px;">
				<table style="width: 100%;">
					<tr>
						<td style="text-align: center;">
                            <br />
                            <h1 style="color: black;">Serralheria Renó</h1>
						</td>
					</tr>
				</table>
                <br />
                <br />
			</div>
			<div style="height: 400px; position: relative;" class="fundo_content">

			</div>
			<div>
				<div style="background-color: white; width: 90%; margin-left: 5%;">
					<div>
						<div style="width: 100%; text-align: center; padding: 20px;line-height: 20px; font-size: 20px; color: black;"">
                        <?php echo $Nome; ?>, você solicitou por meio do portal da <b>Serralheria Renó</b> a alteração da sua senha.
						<br /><br /><br />
                        Segue o link abaixo para prosseguir com a alteração da sua senha.<br/><br />
                        <?php echo"<a href='".$url."account/alterando_senha/".$Id."/".$codigo."'>".$url."account/alterando_senha/".$Id."/".$codigo."</a>"; ?>
						</div>
                        <br />
						<div style="width: 100%; text-align: center;">
                            <table style="width: 100%;">
                                <tr>
                                    <td>
                                        <div style="width: 100%">
                                        <img style="width: 30px;" src="<?php echo $url;?>content/imagens/exclamation-sign.png">
                                            <span style="font-size: 25px; color: #336CD2;">Atenção</span>
                                            <br />
                                            <br />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 style="line-height: 30px; color: #DD3068;">
                                            Não compartilhe o conteúdo deste e-mail com ninguém, pois
                                            este pode fazer com que usuários não autorizados tenham acesso
                                            as suas informações.</h4>
                                        <br /><br />
                                    </td>
                                </tr>
                            </table>
						</div>
					</div>
				</div>
			</div>
			<div style="line-height: 25px; text-align: center; border: 3px solid black;" class="fundo">
				<br />Serralheria Renó <br />
				Sítio Monjolinho - Bairro Estação Dias - Placa KM6<br />
				37530-000 - Brazópolis/MG - Cel: (35) 999435624 - Cel: (35) 3617 - 5001 <br />
				<a href="http://www.serralheriareno.com.br">www.serralheriareno.com.br</a><br /><br />
			</div>
		</div>
		<div style="line-height: 25px; text-align: center; padding: 10px; color: gray; border: 3px solid black; border-top: none;">
				Esta mensagem e quaisquer arquivos em anexo podem conter informações confidenciais e/ou privilegiadas. Se você não for o destinatário ou a pessoa autorizada a receber esta mensagem, por favor não leia, copie, repasse, imprima, guarde, nem tome qualquer ação baseada nestas informações. Por favor, notifique o remetente imediatamente por e-mail e apague a mensagem permanentemente. Este ambiente está sendo monitorado para evitar uso indevido de nossos sistemas.
			</div>
	</body>
</html>