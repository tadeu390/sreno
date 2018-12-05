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
				background-image: url("<?php echo $url; ?>content/imagens/study.jpg");
				background-repeat: no-repeat;
				background-position: center;
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
							<img src="<?php echo $url; ?>content/imagens/logo.png" style="width: 80px;">	
						</td>
						<td>
							<div style="font-size: 20px; display: flex; align-items: center; height: 100%;">
								<h3 style="color: black;">Centro de Educação Profissional "Tancredo Neves"</h3>
							</div>	
						</td>
					</tr>
					<tr>
						<td style="text-align: center; color: #336CD2; font-size: 25px;" colspan="2">
							<img style="width: 30px;" src="<?php echo $url; ?>content/imagens/graduate-cap.png">
							Acadêmico
						</td>
					</tr>
				</table>
			</div>
			<div style="height: 400px; position: relative;" class="fundo_content">

			</div>

			<div >
				<div style="background-color: white; width: 90%; margin-left: 5%;">
					<div style="display: -webkit-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; margin-right: -15px; margin-left: -15px;">
						<div style="width: 60%">
							<div style="padding: 20px;line-height: 20px; font-size: 20px; color: black;">
								
								<table>
									<tr>
										<td>
											<img style="width: 30px;" src="<?php echo $url;?>content/imagens/info.png">
										</td>
										<td style="padding-left: 10px;"><br />
											<?php echo $Nome_usuario; ?>, seja bem vindo ao CEP. Siga os passos abaixo para realizar o seu primeiro acesso.
										</td>
									</tr>
								</table>
							</div>
							 <div style="padding: 20px;line-height: 20px;">
								<br />
								<h3 style="color: black;">1º Passo</h3>
								<h4 style="color: black;">Copie o código fornecido nesse e-mail</h4>
							</div>
							<div style="padding: 20px;line-height: 20px;">
								<br />
								<h3 style="color: black;">2º Passo</h3>
								<h4 style="color: black;">Cole o código na área definida</h4>
							</div>
							<div style="padding: 20px;line-height: 20px;">
								<br />
								<h3 style="color: black;">3º Passo</h3>
								<h4 style="color: black;">Crie sua senha de acesso</h4>
							</div>
						</div>
						<div style="width: 35%; text-align: center;">
							<div style="height: 100%; width: 100%">
								<br /><br /><br />
								<table style="width: 100%">
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
											Seu código  de acesso é<br /><br />
										</td>
									</tr>
									<tr>
										<td>
											<div style="padding: 20px;line-height: 20px;">
												<span style="padding: 20px; padding-right: 40px; padding-left: 40px; font-size: 20px; color: #336CD2; border: 3px solid #336CD2;"><?php echo $codigo; ?></span>
											</div>
										</td>
									</tr>
									<tr>
										<td>
										<br />
											<h4 style="line-height: 30px; color: #DD3068; text-align: left;">
												Não compartilhe o conteúdo deste e-mail com ninguém, pois <br />
											este pode fazer com que usuários não autorizados tenham acesso<br />
											as suas informações.</h4>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style="line-height: 25px; text-align: center; border: 3px solid black;" class="fundo">
				<br />CEP - Centro de Educação Profissional "Tancredo Neves" <br />
				Pç N. Sra. Aparecida, 70 - Bairro N. Sra. Aparecida <br />
				37530-000 - Brazópolis/MG - Tel: (35) 3641-1073 <br />
				<a href="http://www.cepbrazopolis.com.br">www.cepbrazopolis.com.br</a><br /><br />
			</div>
		</div>
		<div style="line-height: 25px; text-align: center; padding: 10px; color: gray; border: 3px solid black; border-top: none;">
				Esta mensagem e quaisquer arquivos em anexo podem conter informações confidenciais e/ou privilegiadas. Se você não for o destinatário ou a pessoa autorizada a receber esta mensagem, por favor não leia, copie, repasse, imprima, guarde, nem tome qualquer ação baseada nestas informações. Por favor, notifique o remetente imediatamente por e-mail e apague a mensagem permanentemente. Este ambiente está sendo monitorado para evitar uso indevido de nossos sistemas.
			</div>
	</body>
</html>