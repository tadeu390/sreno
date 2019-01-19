$(document).ready(
    //inicializa o html adicionando os envetos js especificados abaixo
    function()
    {
        Main.load_mask();

        ///ESPIAR SENHA DE LOGIN
        $('#espiar').mousedown(function()
        {
            document.getElementById("senha-login").type="text";
        });

        $('#espiar').mouseup(function()
        {
            document.getElementById("senha-login").type="password";
        });

        window.addEventListener('mouseup', function (e)
        {
            if(document.getElementById("senha-login") != undefined)
                document.getElementById("senha-login").type="password"
        });
        ///ESPIAR SENHA DE LOGIN

        //event for form login
        $("#form_login").submit(function(event)
        {
            event.preventDefault();
            Main.login();
        });

        $('#email-login').blur(function()
        {
            if (this.value != '')
            {
                if (Main.valida_email(this.value) == false)
                    Main.show_error("email-login", 'Formato de e-mail inválido', '');
                else
                    Main.show_error("email-login", '', '');
            }
        });

        $('#senha-login').blur(function()
        {
            if (this.value != '') Main.show_error("senha-login", '', '');
        });

        $('#bt_logout').click(function()
        {
            Main.logout();
        });

        //LOGIN
        $('#bt_atualiza_preco').click(function()
        {
            Main.atualiza_preco();
        });
        $('#status_ocos').blur(function()
        {
            if (this.value != '0') Main.show_error("status_ocos", '', '');
        });
        $('#usuario_responsavel').blur(function()
        {
            if (this.value != '0') Main.show_error("usuario_responsavel", '', '');
        });
        $('#tempo').blur(function()
        {
            if (this.value != '' && this.value != '0') Main.show_error("tempo", '', 'is-valid');
        });
        $('#data_inicio').blur(function()
        {
            if (this.value != '') Main.show_error("data_inicio", '', 'is-valid');
        });
        $('#descricao_ocos').blur(function()
        {
            if (this.value != '') Main.show_error("descricao_ocos", '', 'form-control');
            document.getElementById("descricao_ocos").style.backgroundColor = "white";
        });
        $('#tipo_servico').blur(function()
        {
            if (this.value != '0') Main.show_error("tipo_servico", '', '');
        });
        $('#cliente_id').blur(function()
        {
            if (this.value != '0') Main.show_error("cliente_id", '', '');
        });
        $('#qtd_ocos').blur(function()
        {
            if (this.value != '') Main.show_error("qtd_ocos", '', 'is-valid');
        });
        $('#peca_id_ocos').blur(function()
        {
            if (this.value != '0') Main.show_error("peca_id_ocos", '', '');
        });
        $('#categoria_id_ocos').blur(function()
        {
            if (this.value != '0') Main.show_error("categoria_id_ocos", '', '');
        });
        $('#valor_servico').blur(function()
        {
            if ($.isNumeric(this.value.replace(",",".")) && this.value > 0) Main.show_error("valor_servico", '', 'is-valid');
        });
        $('#descricao_servico').blur(function()
        {
            if (this.value != '') Main.show_error("descricao_servico", '', 'is-valid');
        });
        $('#data_inicio').blur(function()
        {
            Main.gera_data_fim();
        });
        $('#tempo').blur(function()
        {
            Main.gera_data_fim();
        });
        $('#bt_add_servico').click(function()
        {
            Main.add_servico(this.value);
        });
        $('#bt_add_peca').click(function()
        {
            Main.add_peca(this.value);
        });

        $('#peca_id_ocos').change(function()
        {
            Main.calcula_preco_peca(this.value);
        });
        $('#qtd_ocos').blur(function()
        {
            Main.calcula_preco_peca(this.value);
        });
        $('#categoria_id_ocos').change(function()
        {
            Main.carrega_pecas(this.value);
        });
        $('#fornecedor_id').blur(function()
        {
            if (this.value != '') Main.show_error("fornecedor_id", '', '');
        });
        $('#peca_id').blur(function()
        {
            if (this.value != '') Main.show_error("peca_id", '', '');
        });
        $('#quantidade').blur(function()
        {
            if (this.value != '') Main.show_error("quantidade", '', 'is-valid');
        });
        $('#preco_unitario').blur(function()
        {
            if (this.value != '') Main.show_error("preco_unitario", '', 'is-valid');
        });
        $('#estocado_em').blur(function()
        {
            if (this.value != '') Main.show_error("estocado_em", '', '');
        });
        $('#categoria_id').blur(function()
        {
            if (this.value != '') Main.show_error("categoria_id", '', '');
        });
        $('#razao_social').blur(function()
        {
            if (this.value != '') Main.show_error("razao_social", '', 'is-valid');
        });
        $('#cnpj').blur(function()
        {
            if (this.value != '') Main.show_error("cnpj", '', 'is-valid');
        });

        $('#numero').blur(function()
        {
            if (this.value != '') Main.show_error("numero", '', 'is-valid');
        });
        $('#bairro').blur(function()
        {
            if (this.value != '') Main.show_error("bairro", '', 'is-valid');
        });
        $('#cidade').blur(function()
        {
            if (this.value != '') Main.show_error("cidade", '', 'is-valid');
        });

        $('#rua').blur(function()
        {
            if (this.value != '') Main.show_error("rua", '', 'is-valid');
        });
        $('#telefone').blur(function()
        {
            if (this.value != '') Main.show_error("telefone", '', 'is-valid');
        });

        $('#celular').blur(function()
        {
           if (this.value != '') Main.show_error("celular", '', 'is-valid');
        });

        $('#cpf').blur(function()
        {
           if (this.value != '') Main.show_error("cpf", '', 'is-valid');
        });

        $('#nome').blur(function()
        {
            if (this.value != '') Main.show_error("nome", '', 'is-valid');
        });

        $('#senha').blur(function()
        {
            if (this.value != '') Main.show_error("senha", '', 'is-valid');
        });

        $('#confirmar_senha').blur(function()
        {
            if (this.value != '') Main.show_error("confirmar_senha", '', 'is-valid');
        });

        $('#codigo_ativacao').blur(function()
        {
            if (this.value != '' && this.value.length == 6) Main.show_error("codigo_ativacao", '', 'is-valid');
        });

        $('#grupo_id').blur(function()
        {
            if (this.value != '0') Main.show_error("grupo_id", '', '');
        });

        $('#nova_senha').blur(function()
        {
            if (this.value != '' && this.value.length >= 8) Main.show_error("nova_senha", '', 'is-valid');
            else Main.show_error("nova_senha", 'A senha deve conter no mínimo 8 caracteres.', 'is-invalid');
        });

        $('#senha').blur(function()
        {
            if (this.value != '' && this.value.length >= 8) Main.show_error("senha", '', 'is-valid');
            else Main.show_error("senha", 'A senha deve conter no mínimo 8 caracteres.', 'is-invalid');
        });

        $('#confirmar_nova_senha').blur(function()
        {
            if (this.value != '' && this.value.length >= 8) Main.show_error("confirmar_nova_senha", '', 'is-valid');
        });

        $('#ordem').blur(function()
        {
            if (this.value != '') Main.show_error("ordem", '', 'is-valid');
        });

        $('#descricao').blur(function()
        {
          if (this.value != '') Main.show_error("descricao", '', 'is-valid');
        });

        $('#url_modulo').blur(function()
        {
            if (this.value != '') Main.show_error("url_modulo", '', 'is-valid');
        });

        $('#itens_por_pagina').blur(function()
        {
            if (this.value != '') Main.show_error("itens_por_pagina", '', 'is-valid');
        });

        $('#icone').blur(function()
        {
            /*if(this.value != '')*/
              Main.show_error("icone", '', 'is-valid');
        });

        $('#menu_id').blur(function()
        {
            if (this.value != '0') Main.show_error("menu_id", '', '');
        });

        $('#email').blur(function()
        {
            if (this.value != '')
            {
                if (Main.valida_email(this.value) == false)
                    Main.show_error("email", 'Formato de e-mail inválido', 'is-invalid');
                else
                    Main.show_error("email", '', 'is-valid');
            }
        });

        $('#email').keypress(function()
        {
            if ((window.event ? event.keyCode : event.which) == 13)
            {
                Main.login();
            };
        });

        $('#senha').keypress(function()
        {
            if ((window.event ? event.keyCode : event.which) == 13)
            {
                Main.login();
            };
        });

        //BTN CADASTROS
        $("#form_cadastro_ocos").submit(function(event)
        {
            event.preventDefault();
            Main.ocos_validar();
        });
        $("#form_cadastro_transacao").submit(function(event)
        {
            event.preventDefault();
            Main.transacao_validar();
        });
        $("#form_cadastro_peca").submit(function(event)
        {
            event.preventDefault();
            Main.peca_validar();
        });
        $("#form_cadastro_categoria").submit(function(event)
        {
            event.preventDefault();
            Main.categoria_validar();
        });
        $("#form_cadastro_fornecedor").submit(function(event)
        {
            event.preventDefault();
            Main.fornecedor_validar();
        });
        $("#form_cadastro_cliente").submit(function(event)
        {
            event.preventDefault();
            Main.cliente_validar();
        });

        $("#form_cadastro_configuracoes_email").submit(function(event)
        {
            event.preventDefault();
            Main.config_email_validar();
        });

        $("#form_alterar_senha").submit(function(event)
        {//quando o usuário está inserindo a senha nova do esqueceu sua senha
            event.preventDefault();
            Main.nova_senha_validar();
        });

        $("#form_redefinir_senha").submit(function(event)
        {//quando o usuário está solicitando a alteração de senha
            event.preventDefault();
            Main.redefinir_senha_validar();
        });

        $("#form_redefinir_senha_primeiro_acesso").submit(function(event)
        {
            event.preventDefault();
            Main.senha_primeiro_acesso_validar();
        });

        $("#form_cadastro_configuracoes_geral").submit(function(event)
        {
            event.preventDefault();
            Main.settings_geral_validar();
        });

        $("#form_cadastro_usuario").submit(function(event)
        {
            event.preventDefault();
            if(Main.usuario_validar() == true)
                Main.create_edit();
        });

        $("#form_cadastro_usuario_permissoes").submit(function(event)
        {
            event.preventDefault();
            Main.method = "store_permissoes";
            Main.create_edit();
        });

        $("#form_cadastro_grupo_permissoes").submit(function(event)
        {
            event.preventDefault();
            Main.method = "store_permissoes";
            Main.create_edit();
        });

        $("#form_cadastro_menu").submit(function(event)
        {
            event.preventDefault();
            Main.menu_validar();
        });

        $("#form_cadastro_modulo").submit(function(event)
        {
            event.preventDefault();
            Main.modulo_validar();
        });

        $("#form_cadastro_grupo").submit(function(event)
        {
            event.preventDefault();
            Main.grupo_validar();
        });

        $('#data_nascimento').blur(function()
        {
            if (this.value != '') Main.show_error("data_nascimento", "", "is-valid");
        });

        $('#masculino').change(function()
        {
            Main.show_error("sexo", "", "");
        });

        $('#feminino').change(function()
        {
            Main.show_error("sexo", "", "");
        });

        $('#bt_delete').click(function()
        {
            Main.delete_registro();
        });
    }
);