<?php
	require_once("Geral.php");//INCLUI A CLASSE GENÉRICA.
	/*!
	*	ESTA CLASSE TEM POR FUNÇÃO CONTROLAR TUDO REFERENTE AS CONFIGURAÇÕE DO SISTEMA.
	*/
	class Configuracoes extends Geral {
		/*
			No construtor carregamos as bibliotecas necessarias e tambem nossa model.
		*/
		public function __construct()
		{
			parent::__construct();
			
			if(empty($this->Account_model->session_is_valid()['id']))
			{
				$url_redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$url_redirect = str_replace("/","-x",$url_redirect);
				redirect('account/login/'.$url_redirect);
			}
			else if($this->Account_model->session_is_valid()['grupo_id'] != ADMIN)
				redirect("admin/index");
			
			$this->load->model('Configuracoes_model');
			
			$this->set_menu();
			$this->data['controller'] = strtolower(get_class($this));
			$this->data['menu_selectd'] = $this->Geral_model->get_identificador_menu(strtolower(get_class($this)));
		}
		/*!
		*	RESPONSÁVEL RECEBER DA MODEL OS DADOS DE CONFIGURAÇÕES E OS ENVIA-LOS A VIEW.
		*/
		public function geral()
		{
			if($this->Account_model->session_is_valid()['grupo_id'] == ADMIN)
			{
				$this->data['title'] = 'Configurações gerais';
				$this->data['obj'] = $this->Configuracoes_model->get_configuracoes();
				$this->data['obj_email'] = $this->Configuracoes_email_model->get_configuracoes_email();
				$this->view("configuracoes/geral",$this->data);
			}
			else
				$this->view("templates/permissao",$this->data);
		}
		/*!
		*	RESPONSÁVEL POR CAPTAR OS DADOS DO FORMULÁRIO SUBMETIDO.
		*/
		public function store()
		{
			if($this->Account_model->session_is_valid()['grupo_id'] == ADMIN)
			{
				$resultado = "sucesso";
				$dataToSave = array(
					'Id' => $this->input->post('id'),
					'Itens_por_pagina' => $this->input->post('itens_por_pagina')
					
				);

				//bloquear acesso direto ao metodo store
				 if(!empty($this->input->post()))
						$this->Configuracoes_model->set_configuracoes($dataToSave);
				 else
					redirect('admin/index');
			}
			else
				$resultado = "Você não tem permissão para realizar esta ação.";

			$arr = array('response' => $resultado);
			header('Content-Type: application/json');
			echo json_encode($arr);
		}
		/*!
		*	RESPONSÁVEL POR CAPTAR OS DADOS DE E-MAIL DO FORMULÁRIO SUBMETIDO.
		*/
		public function store_email()
		{
			$resultado = "sucesso";

			if($this->Account_model->session_is_valid()['grupo_id'] == ADMIN)
			{
				$dataToSave = array(
					'Id' => $this->input->post('id'),
					'Email' => $this->input->post('email'),
					'Descricao' => $this->input->post('descricao'),
					'Usuario' => $this->input->post('usuario'),
					'Senha' => $this->input->post('senha'),
					'Protocolo' => $this->input->post('protocolo'),
					'Host' => $this->input->post('host'),
					'Porta' => $this->input->post('porta')
				);
				//bloquear acesso direto ao metodo store
				if(!empty($this->input->post()))
						$this->Configuracoes_email_model->set_configuracoes_email($dataToSave);
				 else
					redirect('admin/index');
			}
			else
				$resultado = "Você não tem permissão para realizar esta ação.";
			
			$arr = array('response' => $resultado);
			header('Content-Type: application/json');
			echo json_encode($arr);
		}
		/*!
		*	RESPONSÁVEL POR REDIRECIONAR PARA A PÁGINA INICIAL QUANDO SÃO SALVAS AS ALTERAÇÕES.
		*/
		public function index()
		{
			redirect("configuracoes/geral");
		}
	}