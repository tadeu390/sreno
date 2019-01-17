<?php
	require_once("Usuario.php");//HERDA AS ESPECIFICAÇÕES DA CLASSE DE USUÁRIO.
	/*!
	*	ESTA CLASSE TEM POR FUNÇÃO CONTROLAR AS INFORMAÇÕES DE CLIENTE.
	*/
	class Cliente extends Usuario
	{
		/*
			CONSTRUTOR RESPONSÁVEL POR VALIDAR A SESSÃO E VERIFICAR O MENU SELECIONADO.
		*/
		public function __construct()
		{
			parent::__construct();
			if($this->Account_model->session_is_valid()['status'] != "ok")
				redirect('account/login');
			$this->set_menu();
			$this->data['controller'] = strtolower(get_class($this));
			$this->load->model('Account_model');
			$this->load->model('Endereco_model');
			$this->load->model('Cliente_model');
			$this->load->model('Tipo_usuario_model');
			$this->data['menu_selectd'] = $this->Geral_model->get_identificador_menu("usuario");
		}
		/*!
		*	RESPONSÁVEL POR REDIRECIONAR A PÁGINA PRO INDEX DE USUÁRIOS. O JS REDIRECIONA PRA ESTE MÉTODO
		*	QUE POR SUA VEZ REDIRECIONA PARA A LISTAGEM DE USUÁRIOS.
		*
		*	$page -> Página atual.
		*/
		public function index($page = FALSE, $field = FALSE, $order = FALSE)
		{
			redirect("usuario/index");
		}
		/*!
		*	RESPONSÁVEL POR CARREGAR O FORMULÁRIO COM CAMPOS DE USUARIO + OS CAMPOS DE CLIENTE.
		*
		*	$id -> Contém a id do cliente.
		*	$type -> Contém um número inteiro, que diz respeito ao tipo de usuário que se quer criar.
		*/
		public function create($id = NULL, $type = NULL)
		{
			if($this->Geral_model->get_permissao(CREATE, get_parent_class($this)) == TRUE)
			{
				$this->data['obj'] = $this->Usuario_model->get_usuario(FALSE, 0, FALSE);
				$this->data['obj_cliente'] = array('Cliente_id' => '');
				$this->data['Endereco'] = array(
											'Endereco_id' => '', 'Rua' => '', 'Bairro' => '',
											'Cidade' => '', 'Numero' => '', 'Complemento' => '');

				$this->data['type'] = $type;
				$this->data['grupos_usuario'] = $this->Grupo_model->get_grupo(FALSE, FALSE, FALSE);
                $this->data['tipos_usuario'] = $this->Tipo_usuario_model->get_tipo_usuario(FALSE, TRUE);
				$this->data['title'] = 'Novo cliente';
				$this->view("cliente/create", $this->data);
			}
			else
				$this->view("templates/permissao", $this->data);
		}
		/*!
		*	RESPONSÁVEL POR RECEBER DA MODEL OS DADOS DE UM CLIENTE + OS DADOS DE USUÁRIO DO MESMO E
		*	EM SEGUIDA ENVIA-LOS A VIEW EXBINDO ESTES DADOS.
		*
		*	$id -> Id do usuário/cliente.
		*	$type -> Grupo de usuário.
		*/
		public function edit($id = FALSE, $type = NULL)
		{
			if($this->Geral_model->get_permissao(UPDATE, get_parent_class($this)) == TRUE)
			{
				$this->data['obj'] = $this->Usuario_model->get_usuario(FALSE, $id, FALSE);
				$this->data['obj_cliente'] = $this->Cliente_model->get_cliente($this->data['obj']->Id);
				$this->data['Endereco'] = $this->Endereco_model->get_endereco(TRUE, $this->data['obj_cliente']->Endereco_id);
				if(empty($this->data['Endereco']))
				{
                    $this->data['Endereco'] = array(
                        'Endereco_id' => '', 'Rua' => '', 'Bairro' => '',
                        'Cidade' => '', 'Numero' => '', 'Complemento' => '');
				}
				$this->data['type'] = CLIENTE;
				$this->data['grupos_usuario'] = $this->Grupo_model->get_grupo(FALSE, FALSE, FALSE);
                $this->data['tipos_usuario'] = $this->Tipo_usuario_model->get_tipo_usuario(FALSE, TRUE);
				$this->data['title'] = 'Editar cliente';
				$this->view("cliente/create", $this->data);
			}
			else
				$this->view("templates/permissao", $this->data);	
		}
		/*!
		*	RESPONSÁVEL POR VALIDAR OS DADOS NECESSÁRIOS DO CLIENTE.
		*
		*	$cliente -> Contém todos os dados do cliente a ser validado.
		*/
		public function valida_cliente($cliente)
		{
            if($cliente['Cpf'] == "")
                return "Insira o CPF";
            else if($cliente['Celular'] == "")
                return "Insira o celular";
            else if($cliente['Telefone'] == "")
                return "Insira o Telefone";
			return 1;
		}
		/*!
		*	RESPONSÁVEL POR ENVIAR AO MODEL OS DADOS DO CLIENTE.
		*
		*	$cliente -> Contém todos os dados de um cliente a ser cadastrado/editado.
		*/
		public function store_banco($cliente)
		{
			return  $this->Cliente_model->set_cliente($cliente);
		}
        /*!
         *  RESPONSÁVEL POR VALIDAR OS DADOS DE ENDEREÇO DO FORNECEDOR.
         *
         *  $endereco -> Contém os dados de endereço que serão validados.
         */
        public function valida_endereco()
        {
            if(empty($this->Endereco_model->Rua))
                return "Insira o nome da rua";
            else if(empty($this->Endereco_model->Cidade))
                return "Insira o nome da cidade";
            else if(empty($this->Endereco_model->Bairro))
                return "Insira o nome do bairro";
            else if(empty($this->Endereco_model->Numero))
                return "Insira o número da casa";
            return 1;
        }
		/*!
		*	RESPONSÁVEL POR CAPTAR OS DADOS DO FORMULÁRIO SUBMETIDO.
		*/
		public function store()
		{
			$resultado = "sucesso";
			$dataToSave = array(
				'Id' => $this->input->post('id'),
				'Ativo' => $this->input->post('conta_ativa'),
				'Nome' => $this->input->post('nome'),
				'Email' => $this->input->post('email'),
				'Data_nascimento' => $this->input->post('data_nascimento'),
				'Sexo' => $this->input->post('sexo'),
				'Grupo_id' => $this->input->post('grupo_id'),
				'Tipo_usuario_id' => $this->input->post('tipo_usuario_id'),
				'Email_notifica_nova_conta' => $this->input->post('email_notifica_nova_conta')
			);

            $this->Endereco_model->Rua = $this->input->post('rua');
            $this->Endereco_model->Cidade = $this->input->post('cidade');
            $this->Endereco_model->Bairro = $this->input->post('bairro');
            $this->Endereco_model->Numero = $this->input->post('numero');
            $this->Endereco_model->Complemento = $this->input->post('complemento');

			$dataToSave['Data_nascimento'] = $this->convert_date($dataToSave['Data_nascimento'], "en");

			if(empty($dataToSave['Email_notifica_nova_conta']))
				$dataToSave['Email_notifica_nova_conta'] = 0;

			if(empty($dataToSave['Ativo']))
				$dataToSave['Ativo'] = 0;

			//BLOQUEIA ACESSO DIRETO AO MÉTODO
            if(!empty($this->input->post()))
		    {
			 	if($this->Geral_model->get_permissao(CREATE, get_parent_class($this)) == TRUE || $this->Geral_model->get_permissao(UPDATE, get_parent_class($this)) == TRUE)
				{
					$resultado = parent::valida_usuario($dataToSave);

				 	if($resultado == 1)
				 	{
                        $resultado = $this->valida_endereco();
                        if($resultado == 1)
                        {
                            $dataToSaveCliente = array(
                                'Id' => $this->input->post('cliente_id'),
                                'Usuario_id' => $this->input->post('id'),
                                'Cpf' => $this->input->post('cpf'),
                                'Telefone' => $this->input->post('telefone'),
                                'Celular' => $this->input->post('celular'),
                                'Endereco_id' => ''
                            );

                            $resultado = $this->valida_cliente($dataToSaveCliente);
                            if($resultado == 1)
                            {
                                $endereco_id = $this->Endereco_model->set_endereco();

                                $resultado = parent::store_banco($dataToSave);

                                $dataToSaveCliente['Usuario_id'] = $resultado;//QUANDO ESTIVER CRIANDO ISSO É NECESSARIO, POIS O POST DO ID VIRÁ VAZIO
                                $dataToSaveCliente['Endereco_id'] = $endereco_id;//QUANDO ESTIVER CRIANDO ISSO É NECESSARIO, POIS O POST DO ID VIRÁ VAZIO
                                $resultado = $this->store_banco($dataToSaveCliente);

                                $resultado = "sucesso";
                            }
                        }
				 	}
				}
				else
					$resultado = "Você não tem permissão para realizar esta ação.";

				$arr = array('response' => $resultado);
				header('Content-Type: application/json');
				echo json_encode($arr);
			}
			else
				redirect('usuario/index');
		}
		/*!
		*	RESPONSÁVEL POR RECEBER DA MODEL TODOS OS ATRIBUTOS DE UM CLIENTE E OS ENVIA-LOS A VIEW.
		*
		*	$id -> Id do cliente.
		*/
		public function detalhes($id = FALSE)
		{
			if($this->Geral_model->get_permissao(READ, get_parent_class($this)) == TRUE)
			{
				$this->data['title'] = 'Detalhes do cliente';
				$this->data['obj'] = $this->Usuario_model->get_usuario(FALSE, $id, FALSE);
				$this->data['obj']->Ultimo_acesso = $this->Logs_model->get_last_access_user($this->data['obj']->Id)['Data_registro'];
				$this->data['obj_cliente'] = $this->Cliente_model->get_cliente($id);
				$this->data['obj_endereco'] = $this->Endereco_model->get_endereco(TRUE, $this->data['obj_cliente']->Endereco_id);
				$this->view("cliente/detalhes", $this->data);
			}
			else
				$this->view("templates/permissao", $this->data);
		}
	}