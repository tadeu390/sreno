var Main = {
	load_mask : function(){
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover(),
			$(".chosen-select").chosen({no_results_text: "Não encontrado"}),
			$('#cpf').mask('000.000.000-00'),
			$('#codigo_ativacao').mask('999999'),
			$('#itens_por_pagina').mask('000'),
			$('#porta').mask('0000'),
			$('#data_nascimento').mask('00/00/0000'),
			$('#cpf').mask('000.000.000-00'),
			$('#cnpj').mask('00.000.000/0000-00'),
            $('#telefone').mask('(00) 0000 - 0000'),
            $('#celular').mask('(00) 0 0000 - 0000'),
            $('#numero').mask('0000'),
            $('#tempo').mask('0000'),
			$('[data-toggle="tooltip"]').tooltip(),
			$('#data1 input').datepicker({
		    	language: "pt-BR",
		    	 clearBtn: true,
		    	todayHighlight: true,
			}),
			$('#clearDates').on('click', function(){
			     
			})   
		});
	},
	modal : function(tipo, mensagem)
	{
		$("#mensagem_"+tipo).html(mensagem);
		$('#modal_'+tipo).modal({
			keyboard: true,
			backdrop : 'static',
		});

		if(tipo == "aviso")
		{
			$('#modal_aviso').on('shown.bs.modal', function () {
			 	$('#bt_close_modal_aviso').trigger('focus')
			})
		}
		else if(tipo == "confirm")
		{
			$('#modal_confirm').on('shown.bs.modal', function () {
		  		$('#bt_confirm_modal').trigger('focus')
			})
		}
	},
	weekday : function(dia)
	{
		var arrayDia = new Array(8);
		arrayDia[1] = "Segunda";
		arrayDia[2] = "Terça";
		arrayDia[3] = "Quarta";
		arrayDia[4] = "Quinta";
		arrayDia[5] = "Sexta";
		arrayDia[6] = "Sábado";
		arrayDia[7] = "Domingo";

		return arrayDia[dia];
	},
	str_to_date : function(str)
	{
		return new Date(new Date(str.split('/')[2],str.split('/')[1],str.split('/')[0]));
	},
	convert_date : function(str,to_region)
	{
		if(to_region == "en")
		{
			return str.split('/')[2]+'-'+str.split('/')[1]+'-'+str.split('/')[0];
		}
        else if(to_region == "en2")
        {
            return str.split('/')[1]+'-'+str.split('/')[0]+'-'+str.split('/')[2];
        }
		else if(to_region == "pt")
		{
			return str.split('-')[2]+'/'+str.split('-')[1]+'/'+str.split('-')[0];
		}
	},
	formata_data : function(data)
	{

		var dia  = data.getDate();
		var diaF = (dia.length == 1) ? '0'+dia : dia;
		var mes  = (data.getMonth()+1).toString(); //+1 pois no getMonth Janeiro começa com zero.
		var mesF = (mes.length == 1) ? '0'+mes : mes;
		var anoF = data.getFullYear();
        return diaF+"/"+mesF+"/"+anoF;
	},
	corta_string : function (string, tam)
	{
		var str = string.substr(0, tam);
		
		if(string.length > tam)
			str = str + "...";
		
		return str;
	},
	get_cookie : function(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	},
	login : function () {
		if(Main.login_isvalid() == true)
		{
			Main.modal("aguardar","Aguarde... validando seus dados.");
			$.ajax({
				url: Url.base_url+'account/validar',
				data: $("#form_login").serialize(),
				dataType:'json',
				cache: false,
				type: 'POST',
				success: function (msg) {
					if(msg.response == "primeiro_acesso")
						window.location.assign(Url.base_url+"account/primeiro_acesso");
					else if(msg.response == "valido")
					{
						var url_redirect = $("#url_redirect").val();
						url_redirect = url_redirect.replace(/-x/g,"/");
						
						if($("#url_redirect").val() != "")
							window.location.assign(url_redirect);
						else
							location.reload();
					}
					else
					{
						setTimeout(function(){
							$('#modal_aguardar').modal('hide');
						},500);
						Main.limpa_login();
						Main.modal("aviso", msg.response);
					}
				}
			});
		}
	},
	troca_status: function(idd)//checkbox de permissões
	{
		//settimeout para recuperar o efeito de transição do botão, somente por questões de estética
		setTimeout(function(){
			document.getElementById(idd).className = "checkbox checbox-switch switch-success";
		},500);	
		document.getElementById("flag"+idd).value = "success";
	},
	logout : function (){
		Main.modal("aguardar", "Aguarde... encerrando sessão");
	},
	login_isvalid : function (){
		if($("#email-login").val() == "")
			Main.show_error("email-login","Informe seu e-mail","");
		else if(Main.valida_email($("#email-login").val()) == false)
			Main.show_error("email-login","Formato de e-mail inválido","");
		else if($("#senha-login").val() == "")
			Main.show_error("senha-login","Insira sua senha","");
		else
			return true;
	},
	valida_email : function(email)
	{
		var nome = email.substring(0, email.indexOf("@"));
		var dominio = email.substring(email.indexOf("@")+ 1, email.length);

		if ((nome.length >= 1) &&
			(dominio.length >= 3) && 
			(nome.search("@")  == -1) && 
			(dominio.search("@") == -1) &&
			(nome.search(" ") == -1) && 
			(dominio.search(" ") == -1) &&
			(dominio.search(".") != -1) &&      
			(dominio.indexOf(".") >= 1)&& 
			(dominio.lastIndexOf(".") < dominio.length - 1)) 
			return true;
		else
			return false;
	},
	show_error : function(form, error, class_error)
	{
		if(class_error != "")
			document.getElementById(form).className = "input-material "+class_error;
		if(error != "" && document.getElementById(form) != undefined)
			document.getElementById(form).focus();
		
		document.getElementById("error-"+form).innerHTML = error;
	},
	limpa_login : function ()
	{
		$("#senha-login").val("");
		$("#senha-login").focus();
	},
	method : '',
	form : '',
	method_redirect : '',
	create_edit : function ()
	{
		Main.modal("aguardar", "Aguarde... processando dados.");
		//QUANDO NÃO FOR DEFINIDO NENHUM MÉTODO NO 'init.js', POR DEFAULT É CONSIDERADO O METÓDO STORE PARA RECEBER OS DADOS
		
		if(Main.method == "" || Main.method == null)
			Main.method = "store";
		
		//QUANDO NÃO HÁ NECESSIDADE DE COLOCAR UM NOME ESPECÍFICO PRO FORMULÁRIO, USA O NOME PADRÃO ESPECIFICADO ABAIXO
		if(Main.form == "" || Main.form == null)
			Main.form = "form_cadastro";

		//QUANDO O MÉTODO DE REDIRECT NÃO É ESPECIFICADO, CONSIDERAR O PADRÃO index
		if(Main.method_redirect == "" || Main.method_redirect == null)
			Main.method_redirect = "index";

		$.ajax({
			url: Url.base_url+$("#controller").val()+'/'+Main.method,
			data: $("#"+$("form[name="+Main.form+"]").attr("id")).serialize(),
			dataType:'json',
			cache: false,
			type: 'POST',
			success: function (msg) {
				if(msg.response == "sucesso")
				{
					$("#mensagem_aguardar").html("Dados salvos com sucesso");
					window.location.assign(Url.base_url+$("#controller").val()+"/"+ Main.method_redirect +"/"+Main.get_cookie("page"));
				}
				else
				{
					setTimeout(function(){
						$("#modal_aguardar").modal('hide');
						Main.modal("aviso", msg.response);
					},500);
				}
			}
		}).fail(function(msg){
		    setTimeout(function(){
		    	$("#modal_aguardar").modal('hide');
			    Main.modal("aviso", "Houve um erro ao processar sua requisição. Verifique sua conexão com a internet.");
			},500);
		});
	},
	usuario_validar : function(){
		if($("#tipo_usuario_id").val() == "0")
			Main.show_error("tipo_usuario_id", 'Selecione um tipo de usuário', '');
        else if($("#grupo_id").val() == "0")
            Main.show_error("grupo_id", 'Selecione um grupo de usuário', '');
		else if($("#nome").val() == "")
			Main.show_error("nome", 'Informe o nome de usuário', 'is-invalid');
		else if($("#nome").val().length > 100)
			Main.show_error("nome", 'Máximo 100 caracteres', 'is-invalid');
		else if($("#email").val() == "")
			Main.show_error("email", 'Informe o e-mail de usuário', 'is-invalid');
		else if($("#email").val().length > 100)
			Main.show_error("email", 'Máximo 100 caracteres', 'is-invalid');
		else if($("#data_nascimento").val() == "")
			Main.show_error("data_nascimento", 'Informe a data de nascimento do usuário', 'is-invalid');

		else if($("#form_cadastro_"+$("#controller").val()).find("input[name='sexo']:checked").length == 0)
			Main.show_error("sexo","Selecione o sexo do usuário","");
		else if(Main.valida_email($("#email").val()) == false)
			Main.show_error("email", 'Formato de e-mail inválido', 'is-invalid');
		else if($("#senha").val() == "")
			Main.show_error("senha", 'Informe a senha de usuário', 'is-invalid');
		else if(document.getElementById("senha") != undefined && $("#senha").val().length < 8)
			Main.show_error("senha", 'A senha deve conter no mínimo 8 caracteres.', 'is-invalid');
		else if($("id").val() != "" && document.getElementById("email_notifica_nova_conta").checked == true && $("#nova_senha").val() == "")
			Main.modal("aviso","Para enviar e-mail de notificação é necessário que você altere a senha.");
		else
		{
			var trava = 0;
			if($("#id").val() == "")//se estiver criando um usuário
			{
				if($("#confirmar_senha").val() == "")
				{
					trava = 1;
					Main.show_error("confirmar_senha", 'Repita a senha de usuário', 'is-invalid');
				}
				else if($("#senha").val() != $("#confirmar_senha").val())
				{
					trava = 1;
					Main.show_error("confirmar_senha", 'Senha especificada é diferente da anterior', 'is-invalid');
				}
			}
			if(trava == 0)
			{
				
				if($("#nova_senha").val() != "")
				{
					if(document.getElementById("nova_senha") != undefined && $("#nova_senha").val().length < 8)
						Main.show_error("nova_senha", 'A senha deve conter no mínimo 8 caracteres.', 'is-invalid');
					else if($("#confirmar_nova_senha").val() == "")
						Main.show_error("confirmar_nova_senha", 'Repita a nova senha', 'is-invalid');
					else if($("#nova_senha").val() != $("#confirmar_nova_senha").val())
						Main.show_error("confirmar_nova_senha", 'Senha especificada é diferente da anterior', 'is-invalid');
					else
						return true;
				}
				else
					return true;
			}
		}
	},
	gerador_senha : function ()
	{
		var senha = Math.floor((Math.random() * 100000000) + 1);

		Main.modal("aviso","A senha gerada é: "+senha);

		$("#senha").val(senha);
		$("#confirmar_senha").val(senha);

		if(document.getElementById("label_senha") != undefined)
			document.getElementById("label_senha").className = "label-material active";
		if(document.getElementById("label_confirmar_senha") != undefined)
			document.getElementById("label_confirmar_senha").className = "label-material active";

		$("#nova_senha").val(senha);
		$("#confirmar_nova_senha").val(senha);
	},
	menu_validar : function()
	{
		if($("#nome").val() == "")
			Main.show_error("nome", 'Informe o nome de menu', 'is-invalid');
		else if($("#nome").val().length > 20)
			Main.show_error("nome", 'Máximo 20 caracteres', 'is-invalid');
		else if($("#ordem").val() == "")
			Main.show_error("ordem", 'Informe o número da ordem', 'is-invalid');
		else
			Main.create_edit();
	},
	modulo_validar : function()
	{
		if($("#nome").val() == "")
			Main.show_error("nome", 'Informe o nome de módulo', 'is-invalid');
		else if($("#nome").val().length > 20)
			Main.show_error("nome", 'Máximo 20 caracteres', 'is-invalid');
		else if($("#descricao").val() == "")
			Main.show_error("descricao", 'Informe a descrição de módulo', 'is-invalid');
		else if($("#descricao").val().length > 50)
			Main.show_error("descricao", 'Máximo 50 caracteres', 'is-invalid');
		else if($("#url_modulo").val() == "")
			Main.show_error("url_modulo", 'Informe a url do módulo', 'is-invalid');
		else if($("#url_modulo").val().length > 100)
			Main.show_error("url_modulo", 'Máximo 20 caracteres', 'is-invalid');
		else if($("#ordem").val() == "")
			Main.show_error("ordem", 'Informe o número da ordem', 'is-invalid');
		else if($("#icone").val() == "")
			Main.show_error("icone", 'Informe o ícone do módulo', 'is-invalid');
		else if($("#icone").val().length > 50)
			Main.show_error("icone", 'Máximo 50 caracteres', 'is-invalid');
		else
			Main.create_edit();
	},
	grupo_validar : function()
	{
		if($("#nome").val() == "")
			Main.show_error("nome", 'Informe o nome de grupo', 'is-invalid');
		else if($("#nome").val().length > 20)
			Main.show_error("nome", 'Máximo 20 caracteres', 'is-invalid');
		else
			Main.create_edit();
	},
	id_registro : "",
	confirm_delete : function(id)
	{
		Main.id_registro = id;
					
		Main.modal("confirm", "Deseja realmente excluir o registro selecionado?");
	},
	delete_registro : function()
	{
		$.ajax({
			url: Url.base_url+$("#controller").val()+'/deletar/'+Main.id_registro,
			dataType:'json',
			cache: false,
			type: 'POST',
			success: function (data) {
				if(data.response == "sucesso")
					location.reload();
			}
		}).fail(function(msg){
			    setTimeout(function(){
			    	$("#modal_confirm").modal('hide');
			    	Main.modal("aviso", "Houve um erro ao processar sua requisição. Verifique sua conexão com a internet.");
				},500);
			});
	},
	senha_primeiro_acesso_validar : function() 
	{
		Main.method = "altera_senha_primeiro_acesso";

		var codigo_ativacao = $("#codigo_ativacao").val();
		var nova_senha = $("#nova_senha").val();
		var confirmar_nova_senha = $("#confirmar_nova_senha").val();

		if(codigo_ativacao.length == 0)
			Main.show_error("codigo_ativacao", 'Insira o código de ativação', 'is-invalid');
		else if(codigo_ativacao.length < 6)
			Main.show_error("codigo_ativacao", 'O código de ativação deve conter 6 caracteres numéricos', 'is-invalid');
		else if(nova_senha.length == 0)
			Main.show_error("nova_senha", 'Insira a nova senha', 'is-invalid');
		else if(nova_senha.length < 8)
			Main.show_error("nova_senha", 'A senha deve conter no mínimo 8 caracteres.', 'is-invalid');
		else if(confirmar_nova_senha == 0)
			Main.show_error("confirmar_nova_senha", 'Confirme a nova senha', 'is-invalid');
		else if(nova_senha != confirmar_nova_senha)
			Main.show_error("confirmar_nova_senha", 'As senhas não coincidem', 'is-invalid');
		else
			Main.create_edit();
	},
	redefinir_senha_validar : function()//validar na solicitação de uma nova senha
	{
		Main.method = "valida_redefinir_senha";

		var email = $("#email").val();

		if(email == "")
			Main.show_error("email", 'Informe o e-mail de usuário', 'is-invalid');
		else if(Main.valida_email(email) == false)
			Main.show_error("email", 'Formato de e-mail inválido', 'is-invalid');
		else
			Main.create_edit();
	},
	nova_senha_validar : function()//validar a senha nova que o usuário está inserindo
	{
		Main.method = "alterar_senha";

		var nova_senha = $("#nova_senha").val();
		var confirmar_nova_senha = $("#confirmar_nova_senha").val();

		if(nova_senha.length == 0)
			Main.show_error("nova_senha", 'Insira a nova senha', 'is-invalid');
		else if(nova_senha.length < 8)
			Main.show_error("nova_senha", 'A senha deve conter no mínimo 8 caracteres.', 'is-invalid');
		else if(confirmar_nova_senha == 0)
			Main.show_error("confirmar_nova_senha", 'Confirme a nova senha', 'is-invalid');
		else if(nova_senha != confirmar_nova_senha)
			Main.show_error("confirmar_nova_senha", 'As senhas não coincidem', 'is-invalid');
		else
			Main.create_edit();
	},
	settings_geral_validar : function()
	{
		Main.form = "form_cadastro_configuracoes_geral";

		if($("#itens_por_pagina").val() == "")
			Main.show_error("itens_por_pagina", 'Informe a quantidade de ítens por página', 'is-invalid');
		else if($("#itens_por_pagina").val() < 0)
			Main.show_error("itens_por_pagina", 'Informe um número positivo', 'is-invalid');
		else
			Main.create_edit();
	},
	config_email_validar : function()
	{
		Main.form = "form_cadastro_configuracoes_email";
		Main.method = "store_email";
		
		if($("#email").val() == "")
			Main.show_error("email", 'Informe um e-mail válido', 'is-invalid');
		else if(Main.valida_email($("#email").val()) == false)
			Main.show_error("email", 'Formato de e-mail inválido', 'is-invalid');
		else
			Main.create_edit();
	},
	endereco_validar : function ()
	{
        if($("#rua").val() == "")
            Main.show_error("rua","Insira o nome da rua", "is-invalid");
        else if($("#cidade").val() == "")
            Main.show_error("cidade","Insira o nome da cidade", "is-invalid");
        else if($("#bairro").val() == "")
            Main.show_error("bairro","Insira o nome do bairro", "is-invalid");
        else if($("#numero").val() == "")
            Main.show_error("numero","Insira número da casa", "is-invalid");
        else
        	return 1;
	},
    cliente_validar : function()
	{
		if(Main.usuario_validar())
		{
           if($("#cpf").val() == "")
           		Main.show_error("cpf","Insira o CPF", "is-invalid");
		   else if($("#celular").val() == "")
            	Main.show_error("celular","Insira o celular", "is-invalid");
           else if($("#telefone").val() == "")
               Main.show_error("telefone","Insira o telefone", "is-invalid");
           else if(Main.endereco_validar())
           		Main.create_edit();
		}
	},
    fornecedor_validar : function()
	{
        if($("#nome").val() == "")
            Main.show_error("nome","Insira o nome fantasia", "is-invalid");
        else if($("#cnpj").val() == "")
            Main.show_error("cnpj","Insira o CNPJ", "is-invalid");
        else if($("#email").val() == "")
            Main.show_error("email","Insira o email", "is-invalid");
        else if($("#razao_social").val() == "")
            Main.show_error("razao_social","Insira a razão social", "is-invalid");
        else if($("#celular").val() == "")
            Main.show_error("celular","Insira o celular", "is-invalid");
        else if($("#telefone").val() == "")
            Main.show_error("telefone","Insira o telefone", "is-invalid");
        else if(Main.endereco_validar())
            Main.create_edit();
	},
	categoria_validar : function()
	{
        if($("#nome").val() == "")
            Main.show_error("nome","Insira o nome da categoria", "is-invalid");
        else
        	Main.create_edit();
	},
    peca_validar : function()
	{
        if($("#nome").val() == "")
            Main.show_error("nome","Insira o nome da peça", "is-invalid");
        else if($("#categoria_id").val() == "0")
            Main.show_error("categoria_id","Selecione uma categoria", "");
        else if($("#estocado_em").val() == "0")
            Main.show_error("estocado_em","Será estocado como?", "");
		else
			Main.create_edit();
	},
    transacao_validar : function()
	{
		if($("#fornecedor_id").val() == "0")
            Main.show_error("fornecedor_id","Selecione um fornecedor", "");
        else if($("#peca_id").val() == "0")
            Main.show_error("peca_id","Selecione uma peça", "");
        else if($("#quantidade").val() == "")
            Main.show_error("quantidade","Insira a quantidade", "");
        else if($("#preco_unitario").val() == "")
            Main.show_error("preco_unitario","Insira o preço unitário", "");
        else
            Main.create_edit();
	},
    ocos_validar : function()
	{
        Main.method_redirect = "orcamento";
        if($("#nome").val() == "")
            Main.show_error("nome","Insira o nome do produto.", "is-invalid");
        else if($("#nome").val().length > 100)
            Main.show_error("nome","Máximo de 100 caracteres.", "is-invalid");
        else if($("#cliente_id").val() == "0")
            Main.show_error("cliente_id","Selecione um cliente", "");
        else if($("#tipo_servico").val() == "0")
            Main.show_error("tipo_servico","Selecione um tipo de serviço.", "");
        else if($("#descricao_ocos").val() == "")
            Main.show_error("descricao_ocos","Insira a descrição.", "");
        else if(Main.valida_quantidade_peca() == false)
			Main.modal("aviso", "É necessário informar pelo menos uma peça.");
        else if(Main.valida_quantidade_servico() == false)
            Main.modal("aviso", "É necessário informar pelo menos um serviço.");
        else if($("#form_cadastro_"+$("#controller").val()).find("input[name='g_os']:checked").length > 0 || $("#os_gerada").val() == 1)
		{
			Main.method_redirect = "os";
            if($("#data_inicio").val() == "")
                Main.show_error("data_inicio","Insira a data de início.", "is-invalid");
            else if($("#tempo").val() == "")
                Main.show_error("tempo","Informe quantos dias levará para realizar o serviço.", "is-invalid");
            else if($("#tempo").val() <= 0)
                Main.show_error("tempo","O tempo deve ser um número positivo inteiro e maior do que zero.", "is-invalid");
            else if($("#usuario_responsavel").val() == "0")
                Main.show_error("usuario_responsavel","Selecione o usuário responsável.", "");
            else if($("#status_ocos").val() == "0")
                Main.show_error("status_ocos","Selecione o status.", "");
            else
                Main.create_edit();
		}
		else
			Main.create_edit();
	},
	valida_quantidade_peca : function()
	{
        var line_number_id = $("#qtd_peça_adicionado").val();
        for(var i = 0; i < line_number_id; i++)
            if($("#total_id_ocos_adicionado_col4_lin"+i).val() != null)
            	return true;
        return false;
	},
    valida_quantidade_servico : function()
    {
        var line_number_id = $("#qtd_serviço_adicionado").val();
        for(var i = 0; i < line_number_id; i++)
            if($("#valor_servico_id_ocos_adicionado_col1_lin"+i).val() != null)
                return true;
        return false;
    },
    carrega_pecas : function(categoria_id)
	{
        if($(categoria_id).val() != 0)
        {
            Main.modal("aguardar", "Aguarde...");
            $.ajax({
                url: Url.base_url+$("#controller").val()+'/carrega_pecas/' + categoria_id,
                dataType:'json',
                cache: false,
                type: 'POST',
                success: function (data)
                {
                    setTimeout(function(){
                        $("#modal_aguardar").modal('hide');
                    },500);
                    document.getElementById("peca_id_ocos").innerHTML = data.response;
                }
            }).fail(function(msg){
                setTimeout(function(){
                    $("#modal_confirm").modal('hide');
                    Main.modal("aviso", "Houve um erro ao processar sua requisição. Verifique sua conexão com a internet.");
                },500);
            });
        }
	},
    calcula_preco_peca : function()
	{
        if($("#categoria_id_ocos").val() != 0 && $("#peca_id_ocos").val() != 0 && $("#qtd_ocos").val() != "")
        {
            Main.modal("aguardar", "Aguarde... calculando preço.");
            $.ajax({
                url: Url.base_url+$("#controller").val()+'/calcula_preco_peca/' + $("#peca_id_ocos").val() + '/' + $("#qtd_ocos").val().replace(",","."),
                dataType:'json',
                cache: false,
                type: 'POST',
                success: function (data)
                {
                    setTimeout(function(){
                        $("#modal_aguardar").modal('hide');
                    },500);
                    if(data.response == "sucesso")
                    {
                        document.getElementById("preco_unitario_ocos").value = data.preco_unitario;
                        document.getElementById("total").value = data.total;
                    }
                    else
					{
                        document.getElementById("preco_unitario_ocos").value = "";
                        document.getElementById("total").value = "";
                        document.getElementById("qtd_ocos").value = "";
                        Main.modal("aviso", data.response);
					}
                }
            }).fail(function(msg){
                setTimeout(function(){
                    $("#modal_confirm").modal('hide');
                    Main.modal("aviso", "Houve um erro ao processar sua requisição. Verifique sua conexão com a internet.");
                },500);
            });
        }
	},
	gera_data_fim : function()//soma dias em uma data
	{
		var tempo = $("#tempo").val();
		var data_inicio = $("#data_inicio").val();

		if(tempo != "" && data_inicio != "")
		{
            var date = new Date(Main.convert_date(data_inicio, "en2"));
            var newdate = new Date(date);

            newdate.setDate(newdate.getDate() + parseInt(tempo));

            //se por acaso a última linha dessa função estiver dando problema em algum caso de data, então tentar usar o código abaixo em vez
			// da última linha
            /*var dd = newdate.getDate();
            var mm = newdate.getMonth() + 1;
            var y = newdate.getFullYear();
            var someFormattedDate = mm + '/' + dd + '/' + y;*/

            document.getElementById('data_fim').value = newdate.toLocaleDateString();
		}
	},
    valida_peca : function()
    {
        if($("#categoria_id_ocos").val() == "0")
        {
            Main.show_error("categoria_id_ocos","Selecione uma categoria.", "");
            return false;
        }
        else if($("#peca_id_ocos").val() == "0")
        {
            Main.show_error("peca_id_ocos","Selecione uma peça.", "");
            return false;
        }
        else if($("#qtd_ocos").val() == "")
        {
            Main.show_error("qtd_ocos","Informe a quantidade.", "");
            return false;
        }
        else if(!$.isNumeric($("#qtd_ocos").val().replace(",",".")) && $("#qtd_ocos").val() > 0)
        {
            Main.show_error("qtd_ocos","Somente é permitido um número inteiro ou decimal positivo maior do que zero.", "");
            return false;
        }
        else if($("#total").val() == "")
            Main.show_error("total","O valor total é obrigatório.", "");
        return true;
    },
	soma_pecas : function()
	{
        var line_number_id = $("#qtd_peça_adicionado").val();
        var total = 0;
        for(var i = 0; i < line_number_id; i++)
		{
			if($("#total_id_ocos_adicionado_col4_lin"+i).val() != null)
			{
                var valor = $("#total_id_ocos_adicionado_col4_lin" + i).val().replace(',', '.').toString();
                total = total + parseFloat(valor);
            }
		}
		$("#total_peca").val(total.toFixed(2).toString().replace('.',','));
		var total_servico = parseFloat($("#total_servico").val().replace(',','.').toString());
		var total_geral = total + total_servico;
		$("#total_geral").val(total_geral.toString().replace('.',','));
	},
    add_peca : function()
    {
        var peca = Array();
        peca.push($("#categoria_id_ocos :selected").text());
        peca.push($("#peca_id_ocos :selected").text());
        peca.push($("#qtd_ocos").val());
        peca.push($("#preco_unitario_ocos").val());
        peca.push($("#total").val());

        var peca_id = Array();
        peca_id.push("categoria_id_ocos_adicionado");
        peca_id.push("peca_id_ocos_adicionado");
        peca_id.push("qtd_id_ocos_adicionado");
        peca_id.push("preco_unitario_id_ocos_adicionado");
        peca_id.push("total_id_ocos_adicionado");

        var peca_hide = Array();
        peca_hide.push("0");
        peca_hide.push($("#peca_id_ocos").val());
        peca_hide.push("0");
        peca_hide.push("0");
        peca_hide.push("0");

        if(Main.valida_peca() == true)
        {
            var coluna_peca = 1;
            if (!Main.valida_elemento($("#peca_id_ocos :selected").text(), "peca_id_ocos_adicionado", coluna_peca, "peça"))
			{
                Main.add_elemento(peca_id, peca, peca_hide, "peça");
                Main.soma_pecas();
			}
            else
                Main.modal("aviso", "A peça selecionada ja se encontra na lista abaixo. Para editar remova-a e adicione-a novamente.");
        }
    },
	valida_servico : function()
	{
		if($("#descricao_servico").val() == "")
		{
            Main.show_error("descricao_servico","Insira a descrição do serviço.", "");
            return false;
		}
        else if($("#valor_servico").val() == "")
		{
            Main.show_error("valor_servico","Insira o valor do serviço.", "");
            return false;
		}
        else if(!$.isNumeric($("#valor_servico").val().replace(",",".")) || $("#valor_servico").val() <= 0)
		{
            Main.show_error("valor_servico","Somente é permitido um número inteiro ou decimal positivo maior do que zero.", "");
            return false;
		}
		return true;
	},
    soma_servico : function()
    {
        var line_number_id = $("#qtd_serviço_adicionado").val();
        var total = 0;
        for(var i = 0; i < line_number_id; i++)
        {
        	if($("#valor_servico_id_ocos_adicionado_col1_lin"+i).val() != null)
        	{
                var valor = $("#valor_servico_id_ocos_adicionado_col1_lin" + i).val().replace(',', '.').toString();
                total = total + parseFloat(valor);
            }
        }
        $("#total_servico").val(total.toFixed(2).toString().replace('.',','));
        var total_peca = parseFloat($("#total_peca").val().replace(',','.').toString());
        var total_geral = total + total_peca;
        total_geral = total_geral.toFixed(2);
        $("#total_geral").val(total_geral.toString().replace('.',',').toString());
    },
    add_servico : function()
    {
        var servico = Array();
        servico.push($("#descricao_servico").val());
        servico.push(parseFloat($("#valor_servico").val().toString().replace(',','.')).toFixed(2).toString().replace('.', ','));

        var servico_id = Array();
        servico_id.push("descricao_servico_id_ocos_adicionado");
        servico_id.push("valor_servico_id_ocos_adicionado");

        var servico_hide = Array();
        servico_hide.push("0");
        servico_hide.push("0");

        var coluna_servico = 0;
        if(Main.valida_servico() == true)
        {
            if (!Main.valida_elemento($("#descricao_servico").val(), "descricao_servico_id_ocos_adicionado", coluna_servico, "serviço"))
			{
                Main.add_elemento(servico_id, servico, servico_hide, "serviço");
                Main.soma_servico();
			}

            else
                Main.modal("aviso", "Este serviço já se encontra na lista abaixo. Para editar remova-o e adicione-o novamente.");
        }
    },
	/*
	* 	@arr_ids -> nome dos ids de cada elemento a ser adicionado.
	* 	@arr_values -> valores a serem adicionado para cada id.
	* 	@arr_hide -> guarda o valor a ser submetido para o banco quando o valor mostrado para o usuário não é o dado a ser inserido no banco. ex. nome da peça é mostrado
	* 	mas o que deve ser enviado é o id da peça.
	* 	@context -> Qual o contexto que se refere a adição de elmentos. ex. peça, serviço.
	* */
    add_elemento : function(arr_ids, arr_values, arr_hide, context)
    {
        var line_number_id = $("#qtd_" + context + "_adicionado").val();

        var node_tr = document.createElement("TR");
        node_tr.setAttribute("id", context + "_id_ocos_adicionado_linha" + parseInt(line_number_id));

        for(var i = 0; i < arr_ids.length; i ++)
        {
            var node_td = document.createElement("TD");
            var node_input = document.createElement("INPUT");
            node_input.setAttribute("type", "text");
            node_input.setAttribute("readonly", "readonly");
            node_input.setAttribute("id", arr_ids[i] + "_col" + i + "_lin" + line_number_id);
            node_input.setAttribute("name", arr_ids[i] + "_col" + i + "_lin" + line_number_id);
            node_input.setAttribute("class", "form-control background_white");
            node_input.setAttribute("value", arr_values[i]);

            if(arr_hide[i] != "0")
            {
                var node_input_hide = null;
                node_input_hide = document.createElement("INPUT");
                node_input_hide.setAttribute("type", "hidden");
                node_input_hide.setAttribute("value", arr_hide[i]);
                node_input_hide.setAttribute("name", arr_ids[i] + "_hide_col" + i + "_lin" + line_number_id);
                node_input_hide.setAttribute("id", arr_ids[i] + "_hide_col" + i + "_lin" + line_number_id);
                node_td.appendChild(node_input_hide);
            }

            node_td.appendChild(node_input);
            node_tr.appendChild(node_td);
        }

        node_td = document.createElement("TD");
        var node_span = document.createElement("SPAN");
        node_td.setAttribute("style","vertical-align: middle;");
        node_td.setAttribute("class","text-center");
        node_span.setAttribute("class","glyphicon glyphicon-remove text-danger");
        node_span.setAttribute("style","cursor: pointer;");
        node_span.setAttribute("title","Remover " + context);
        node_span.setAttribute("onclick", "Main.remove_elemento('" + context + "_id_ocos_adicionado_linha" + parseInt(line_number_id) + "')");
        node_td.appendChild(node_span);
        node_tr.appendChild(node_td);

        document.getElementById("table_" + context + "_adicionado").appendChild(node_tr);
        $("#qtd_" + context + "_adicionado").val(parseInt(line_number_id) + 1);
    },
    remove_elemento : function (id)
    {
        var linha = document.getElementById(id);
        if(linha != undefined)
            linha.parentNode.removeChild(linha);
		setTimeout(function () {
            Main.soma_pecas();
            Main.soma_servico();
        },500);
    },
	/*
	* 	@valor -> Conteúdo que se deseja buscar.
	* 	@id -> id do elemento a ser buscado ex. procurar por peça então passa o id da peça
	* 	@col -> Informa qual a coluna que se quer procurar o valor.
	* 	@context -> Qual o contexto que se refere a adição de elmentos. ex. peça, serviço.
	* */
	valida_elemento : function(valor, id, col, context)//valor a ser procurado/ id do elemento para procurar o valor / coluna a se buscar / contexto, nome da cois que se está adicionando
	{
        var line_number_id = $("#qtd_" + context + "_adicionado").val();
        for(var i = 0; i < line_number_id; i++)
		{
			console.log("#" + id + "_col" + col + "_lin" + i);
			if($("#" + id + "_col" + col + "_lin" + i).val() == valor)
				return true;
		}
		return false;
	},
	atualiza_preco : function()
	{
        Main.modal("aguardar", "Aguarde... atualizando preço.");
        $.ajax({
            url: Url.base_url+$("#controller").val()+'/atualiza_preco/' + $("#id").val(),
            dataType:'json',
            cache: false,
            type: 'POST',
            success: function (data)
            {
                setTimeout(function(){
                    $("#modal_aguardar").modal('hide');
                },500);
                location.reload();
            }
        }).fail(function(msg){
            setTimeout(function(){
                $("#modal_confirm").modal('hide');
                Main.modal("aviso", "Houve um erro ao processar sua requisição. Verifique sua conexão com a internet.");
            },500);
        });
	},
	altera_tipo_cadastro_usuario : function(tipo,registro,method)
	{
		if(tipo != 0)
		{
			Main.modal("aguardar", "Aguarde um momento");

			if(tipo == 1)//admin
				window.location.assign(Url.base_url+"usuario/"+method+"/"+registro+"/"+tipo);
			else
                window.location.assign(Url.base_url+"cliente/"+method+"/"+registro+"/"+tipo);
		}
	},
	habilita_permissoes : function(permissao)
	{
		if(permissao == "all")
		{
			for(var i = 0; i < $("#qtd").val(); i++)
			{
				document.getElementById("criar"+i).checked = document.getElementById("hab_all").checked;
				if(document.getElementById("cr"+i) != undefined)
				{
					document.getElementById("cr"+i).className = "checkbox checbox-switch switch-success";
					document.getElementById("flagcr"+i).value = "success";
				}
				
				document.getElementById("ler"+i).checked = document.getElementById("hab_all").checked;
				if(document.getElementById("le"+i) != undefined){
					document.getElementById("le"+i).className = "checkbox checbox-switch switch-success";
					document.getElementById("flagle"+i).value = "success";
				}
				
				document.getElementById("atualizar"+i).checked = document.getElementById("hab_all").checked;
				if(document.getElementById("at"+i) != undefined){
					document.getElementById("at"+i).className = "checkbox checbox-switch switch-success";
					document.getElementById("flagat"+i).value = "success";
				}
				
				document.getElementById("remover"+i).checked = document.getElementById("hab_all").checked;
				if(document.getElementById("re"+i) != undefined){
					document.getElementById("re"+i).className = "checkbox checbox-switch switch-success";
					document.getElementById("flagre"+i).value = "success";
				}
			}
		}
		else
		{
			for(var i = 0; i < $("#qtd").val(); i++)
			{
				document.getElementById(permissao+i).checked = document.getElementById("hab_all_"+permissao).checked;
				if(document.getElementById(permissao.substr(0, 2)+i) != undefined){
					document.getElementById(permissao.substr(0, 2)+i).className = "checkbox checbox-switch switch-success";
					document.getElementById("flag"+permissao.substr(0, 2)+i).value = "success";
				}
			}
		}
	}
};