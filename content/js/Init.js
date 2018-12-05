$(document).ready(
  //inicializa o html adicionando os envetos js especificados abaixo
  function() {
    Main.load_mask();
	
	///ESPIAR SENHA DE LOGIN
	$('#espiar').mousedown(function() {
        document.getElementById("senha-login").type="text";
    });
	
	  $('#espiar').mouseup(function() {
        document.getElementById("senha-login").type="password";
    });
	
	window.addEventListener('mouseup', function (e) {
		if(document.getElementById("senha-login") != undefined)
			document.getElementById("senha-login").type="password"
	});
	///ESPIAR SENHA DE LOGIN	
	
    //event for form login
    $("#form_login").submit(function(event) {
      event.preventDefault();
      Main.login();
    });

    $('#email-login').blur(function() {
      if (this.value != '') {
        if (Main.valida_email(this.value) == false)
          Main.show_error("email-login", 'Formato de e-mail inválido', '');
        else
          Main.show_error("email-login", '', '');
      }
    });

    $('#senha-login').blur(function() {
      if (this.value != '') Main.show_error("senha-login", '', '');
    });

    $('#bt_logout').click(function() {
        Main.logout();
    });

    //LOGIN

    //TURMAS
    $('#curso_id').blur(function() {
      if (this.value != '0') Main.show_error("curso_id", '', '');
    });

    //TURMAS

    $('#cpf_outro').blur(function() {
      if (this.value != '') Main.show_error("cpf_outro", '', 'is-valid');
    });

    $('#rg_outro').blur(function() {
      if (this.value != '') Main.show_error("rg_outro", '', 'is-valid');
    });

    //REGRAS LETIVAS
    $('#modalidade_id').change(function() {
      if (this.value != '0') Main.show_error("modalidade_id", '', '');
    });

    $('#periodo').blur(function() {
      if (this.value != '') Main.show_error("periodo", '', 'is-valid');
    });

    $('#limite_falta').blur(function() {
      if (this.value != '') Main.show_error("limite_falta", '', 'is-valid');
    });

    $('#dias_letivos').blur(function() {
      if (this.value != '') Main.show_error("dias_letivos", '', 'is-valid');
    });

    $('#media').blur(function() {
      if (this.value != '') Main.show_error("media", '', 'is-valid');
    });

    $('#duracao_aula').blur(function() {
      if (this.value != '') Main.show_error("duracao_aula", '', 'is-valid');
    });

    $('#hora_inicio_aula').blur(function() {
      if (this.value != '') Main.show_error("hora_inicio_aula", '', 'is-valid');
    });

    $('#quantidade_aula').blur(function() {
      if (this.value != '') Main.show_error("quantidade_aula", '', 'is-valid');
    });

    $('#reprovas').blur(function() {
      if (this.value != '') Main.show_error("reprovas", '', 'is-valid');
    });

    $('#hora_inicio').blur(function() {
      if (this.value != '') Main.show_error("hora_inicio", '', 'is-valid');
    });

    $('#hora_fim').blur(function() {
      if (this.value != '') Main.show_error("hora_fim", '', 'is-valid');
    });

    $('#dia').change(function() {
      if (this.value != '') Main.show_error("dia", '', '');
    });

    $('#nome_etapa').change(function() {
      if (this.value != '') Main.show_error("nome_etapa", '', '');
    });

    $('#valor').change(function() {
      if (this.value != '') Main.show_error("valor", '', '');
    });

    $('#data_inicio').change(function() {
      if (this.value != '') Main.show_error("data_inicio", '', '');
    });

    $('#data_fim').change(function() {
      if (this.value != '') Main.show_error("data_fim", '', '');
    });

    $('#data_abertura').change(function() {
      if (this.value != '') {
        Main.show_error("data_abertura", '', '');
        Main.show_error("data_fechamento", '', '');
      }
    });

    $('#nome_etapa_extra').change(function() {
      if (this.value != '') Main.show_error("nome_etapa_extra", '', '');
    });

    $('#media_etapa_extra').change(function() {
      if (this.value != '') Main.show_error("media_etapa_extra", '', '');
    });

    $('#valor_etapa_extra').change(function() {
      if (this.value != '') Main.show_error("valor_etapa_extra", '', '');
    });

    $('#data_fechamento').change(function() {
      if (this.value != '') Main.show_error("data_fechamento", '', '');
    });

    $('#data_abertura_etapa_extra').change(function() {
      if (this.value != '') {
        Main.show_error("data_abertura_etapa_extra", '', '');
        Main.show_error("data_fechamento_etapa_extra", '', '');
      }
    });

    $('#data_fechamento_etapa_extra').change(function() {
      if (this.value != '') Main.show_error("data_fechamento_etapa_extra", '', '');
    });

    //REGRAS LETIVAS
    $('#apelido').blur(function() {
      if (this.value != '') Main.show_error("apelido", '', 'is-valid');
    });
    $('#nome').blur(function() {
      if (this.value != '') Main.show_error("nome", '', 'is-valid');
    });

    $('#senha').blur(function() {
      if (this.value != '') Main.show_error("senha", '', 'is-valid');
    });

    $('#confirmar_senha').blur(function() {
      if (this.value != '') Main.show_error("confirmar_senha", '', 'is-valid');
    });

    $('#codigo_ativacao').blur(function() {
      if (this.value != '' && this.value.length == 6) Main.show_error("codigo_ativacao", '', 'is-valid');
    });

    $('#grupo_id').blur(function() {
      if (this.value != '0') Main.show_error("grupo_id", '', '');
    });

    $('#nova_senha').blur(function() {
      if (this.value != '' && this.value.length >= 8) Main.show_error("nova_senha", '', 'is-valid');
      else Main.show_error("nova_senha", 'A senha deve conter no mínimo 8 caracteres.', 'is-invalid');
    });

    $('#senha').blur(function() {
      if (this.value != '' && this.value.length >= 8) Main.show_error("senha", '', 'is-valid');
      else Main.show_error("senha", 'A senha deve conter no mínimo 8 caracteres.', 'is-invalid');
    });

    $('#confirmar_nova_senha').blur(function() {
      if (this.value != '' && this.value.length >= 8) Main.show_error("confirmar_nova_senha", '', 'is-valid');
    });

    $('#ordem').blur(function() {
      if (this.value != '') Main.show_error("ordem", '', 'is-valid');
    });

    $('#descricao').blur(function() {
      if (this.value != '') Main.show_error("descricao", '', 'is-valid');
    });

    $('#url_modulo').blur(function() {
      if (this.value != '') Main.show_error("url_modulo", '', 'is-valid');
    });

    $('#itens_por_pagina').blur(function() {
      if (this.value != '') Main.show_error("itens_por_pagina", '', 'is-valid');
    });

    $('#icone').blur(function() {
      /*if(this.value != '')*/
      Main.show_error("icone", '', 'is-valid');
    });

    $('#menu_id').blur(function() {
      if (this.value != '0') Main.show_error("menu_id", '', '');
    });

    $('#email').blur(function() {
      if (this.value != '') {
        if (Main.valida_email(this.value) == false)
          Main.show_error("email", 'Formato de e-mail inválido', 'is-invalid');
        else
          Main.show_error("email", '', 'is-valid');
      }
    });

    $('#email').keypress(function() {
      if ((window.event ? event.keyCode : event.which) == 13) {
        Main.login();
      };
    });

    $('#senha').keypress(function() {
      if ((window.event ? event.keyCode : event.which) == 13) {
        Main.login();
      };
    });

    //BTN CADASTROS
    
    $("#form_cadastro_chamada").submit(function(event) {
      event.preventDefault();
      Main.chamada_validar();
    });

    $("#form_cadastro_horario").submit(function(event) {
      event.preventDefault();
      Main.create_edit();
    });

    $("#form_cadastro_inscricao").submit(function(event) {
      event.preventDefault();
      Main.inscricao_validar();
    });

    $("#form_cadastro_turma").submit(function(event) {
      event.preventDefault();
      Main.validar_turma();
    });

    $("#form_cadastro_regras").submit(function(event) {
      event.preventDefault();
      Main.validar_regras();
    });

    $("#form_cadastro_grade").submit(function(event) {
      event.preventDefault();
        Main.validar_grade();
     
    });

    $("#form_cadastro_curso").submit(function(event) {
      event.preventDefault();
      Main.curso_validar();
    });

    $("#form_cadastro_disciplina").submit(function(event) {
      event.preventDefault();
      Main.disciplina_validar();
    });

    $("#form_cadastro_configuracoes_email").submit(function(event) {
      event.preventDefault();
      Main.config_email_validar();
    });

    $("#form_alterar_senha").submit(function(event) {//quando o usuário está inserindo a senha nova do esqueceu sua senha
      event.preventDefault();
      Main.nova_senha_validar();
    });

    $("#form_redefinir_senha").submit(function(event) {//quando o usuário está solicitando a alteração de senha
      event.preventDefault();
      Main.redefinir_senha_validar();
    });

    $("#form_redefinir_senha_primeiro_acesso").submit(function(event) {
      event.preventDefault();
      Main.senha_primeiro_acesso_validar();
    });

    $("#form_cadastro_configuracoes_geral").submit(function(event) {
      event.preventDefault();
      Main.settings_geral_validar();
    });

    $("#form_cadastro_usuario").submit(function(event) {
      event.preventDefault();
      if(Main.usuario_validar() == true)
        Main.create_edit();
    });

    $("#form_cadastro_aluno").submit(function(event) {
      event.preventDefault();
      if(Main.usuario_validar() == true && Main.aluno_validar() == true)
        Main.create_edit();
    });

    $("#form_cadastro_usuario_permissoes").submit(function(event) {
      event.preventDefault();
      Main.method = "store_permissoes";
      Main.create_edit();
    });

    $("#form_cadastro_grupo_permissoes").submit(function(event) {
      event.preventDefault();
      Main.method = "store_permissoes";
      Main.create_edit();
    });

    $("#form_cadastro_account").submit(function(event) {
      event.preventDefault();
      Main.registro_validar();
    });

    $("#form_cadastro_menu").submit(function(event) {
      event.preventDefault();
      Main.menu_validar();
    });

    $("#form_cadastro_modulo").submit(function(event) {
      event.preventDefault();
      Main.modulo_validar();
    });

    $("#form_cadastro_grupo").submit(function(event) {
      event.preventDefault();
      Main.grupo_validar();
    });

    $("#form_cadastro_modalidade").submit(function(event) {
      event.preventDefault();
      Main.modalidade_validar();
    });

    $('#data_nascimento').blur(function() {
      if (this.value != '') Main.show_error("data_nascimento", "", "is-valid");
    });

    $('#masculino').change(function() {
      Main.show_error("sexo", "", "");
    });

    $('#feminino').change(function() {
      Main.show_error("sexo", "", "");
    });

    $('#bt_delete').click(function() {
      Main.delete_registro();
    });

    $('#opt_id').blur(function() {
      if (this.value != '0') Main.show_error("opt_id", '', '');
    });
  }
);