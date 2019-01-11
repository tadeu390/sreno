<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 26/12/2018
 * Time: 22:29
 */

require_once ("Geral.php");//INCLUI A CLASSE GENÉRICA

/*!
 *  RESPONSÁVEL POR CONTROLAR TUDO REFERENTE AOS DADOS DE FORNECEDORES
 */
class Fornecedor extends Geral
{
    public function __construct()
    {
        parent::__construct();

        if(empty($this->Account_model->session_is_valid()['id']))
        {
            $url_redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $url_redirect = str_replace("/","-x",$url_redirect);
            redirect('account/login/'.$url_redirect);
        }
        $this->load->model('Fornecedor_model');
        $this->load->model('Endereco_model');
        $this->set_menu();
        $this->data['controller'] = strtolower(get_class($this));
        $this->data['menu_selectd'] = $this->Geral_model->get_identificador_menu(strtolower(get_class($this)));
    }
    /*!
    *	RESPONSÁVEL POR RECEBER DA MODEL TODOS OS FORNECEDORES CADASTRADOS E ENVIA-LOS A VIEW.
    *
    *	$page -> Número da página atual de registros.
    */
    public function index($page = FALSE, $field = FALSE, $order = FALSE)
    {
        if($page === FALSE)//QUANDO A PÁGINA NÃO É ESPECIFICADA, POR DEFAULT CARREGA A PRIMEIRA PÁGINA
            $page = 1;

        $ordenacao = array(
            "order" => $this->order_default($order),
            "field" => $this->field_default($field)
        );

        $this->set_page_cookie($page);

        $this->data['title'] = 'Fornecedores';

        //$this->data['paginacao']['filter'] = (!empty($this->input->get()) ? "?".explode("?",$_SERVER["REQUEST_URI"])[1] : ""); //filtros

        if($this->Geral_model->get_permissao(READ, get_class($this)) == TRUE)
        {
            $this->data['fornecedores'] = $this->Fornecedor_model->get_fornecedor(FALSE, FALSE, $page, FALSE, $ordenacao);
            $this->data['paginacao']['size'] = (!empty($this->data['fornecedores']) ? $this->data['fornecedores'][0]->Size : 0);
            $this->data['paginacao']['pg_atual'] = $page;
            //--FILTROS--//
            $this->data['paginacao']['order'] =$this->inverte_ordem($ordenacao['order']);
            $this->data['paginacao']['field'] = $ordenacao['field'];

            //--FILTROS--//
            $this->view("fornecedor/index", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR RECEBER UM ID DE FORNECEDOR PARA "APAGAR".
    *
    *	$id -> Id do fornecedor.
    */
    public function deletar($id = FALSE)
    {
        if($this->Geral_model->get_permissao(DELETE, get_class($this)) == TRUE)
        {
            $this->Fornecedor_model->deletar($id);
            $resultado = "sucesso";
            $arr = array('response' => $resultado);
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR RECEBER DA MODEL TODOS OS ATRIBUTOS DE UM FORNECEDOR E OS ENVIA-LOS A VIEW.
    *
    *	$id -> Id de um fonnecedor.
    */
    public function detalhes($id = FALSE)
    {
        if($this->Geral_model->get_permissao(READ, get_class($this)) == TRUE)
        {
            $this->data['title'] = 'Detalhes do fornecedor';
            $this->data['obj'] = $this->Fornecedor_model->get_fornecedor($id, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_endereco'] = $this->Endereco_model->get_endereco(TRUE, $this->data['obj']->Endereco_id);
            $this->view("fornecedor/detalhes", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DO FORNECEDOR.
    */
    public function create()
    {
        if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE)
        {
            $this->data['obj_fornecedor'] = $this->Fornecedor_model->get_fornecedor(0, FALSE, FALSE, FALSE, FALSE);
            $this->data['title'] = 'Novo fornecedor';
            $this->data['Endereco'] = array();

            $this->view("fornecedor/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE FORNECEDOR E RECEBER DA MODEL OS DADOS
    *	DO FORNECEDOR QUE SE DESEJA EDITAR.
    *
    *	$id -> Id do fornecedor.
    */
    public function edit($id = FALSE)
    {
        $this->data['title'] = 'Editar fornecedor';
        if($this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
        {
            $this->data['obj_fornecedor'] = $this->Fornecedor_model->get_fornecedor($id, FALSE, FALSE, FALSE, FALSE);
            $this->data['Endereco'] = $this->Endereco_model->get_endereco(TRUE, $this->data['obj_fornecedor']->Endereco_id);
            $this->view("fornecedor/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
     *  RESPONSÁVEL POR VALIDAR OS DADOS DO FORNECEDOR
     */
    public function valida_fornecedor()
    {
       if(empty($this->Fornecedor_model->Nome_fantasia))
           return "Insira o nome fantasia";
       else if(empty($this->Fornecedor_model->Cnpj))
            return "Insira o CNPJ";
       else if(empty($this->Fornecedor_model->Email))
           return "Insira o e-mail";
       else if(empty($this->Fornecedor_model->Razao_social))
           return "Insira a razão social";
       else if(empty($this->Fornecedor_model->Celular))
           return "Insira o celular";
       else if(empty($this->Fornecedor_model->Telefone))
           return "Insira o telefone";
       else if($this->Fornecedor_model->valida_fornecedor($this->Fornecedor_model->Nome_fantasia, $this->Fornecedor_model->Id) != 'valido')
           return "O nome fantasia informado já se encontra cadastrado no sistema.";
       else
           return 1;
    }
    /*!
     *  RESPONSÁVEL POR ENVIAR OS DADOS PARA A MODEL.
     */
    public function store_banco()
    {
        $this->Fornecedor_model->set_fornecedor();
    }
    /*!
     *  RESPONSÁVEL POR VALIDAR OS DADOS DE ENDEREÇO DO FORNECEDOR.
     *
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

        $this->Fornecedor_model->Id = $this->input->post('id');
        $this->Fornecedor_model->Nome_fantasia = $this->input->post('nome');
        $this->Fornecedor_model->Cnpj = $this->input->post('cnpj');
        $this->Fornecedor_model->Email = $this->input->post('email');
        $this->Fornecedor_model->Razao_social = $this->input->post('razao_social');
        $this->Fornecedor_model->Celular = $this->input->post('celular');
        $this->Fornecedor_model->Telefone = $this->input->post('telefone');
        $this->Fornecedor_model->Ativo = $this->input->post('ativo');

        if(empty($this->Fornecedor_model->Ativo))
            $this->Fornecedor_model->Ativo = 0;

        $this->Endereco_model->Rua = $this->input->post('rua');
        $this->Endereco_model->Cidade = $this->input->post('cidade');
        $this->Endereco_model->Bairro = $this->input->post('bairro');
        $this->Endereco_model->Numero = $this->input->post('numero');
        $this->Endereco_model->Complemento = $this->input->post('complemento');

        //bloquear acesso direto ao metodo store
        if(!empty($this->input->post()))
        {
            if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE || $this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
            {
                $resultado = $this->valida_fornecedor();
                if($resultado == 1)
                {
                    $resultado = $this->valida_endereco();
                    if($resultado == 1)
                    {
                        $this->Fornecedor_model->Endereco_id = $this->Endereco_model->set_endereco();
                        $this->store_banco();
                        $resultado = "sucesso";
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
            redirect('fornecedor/index');
    }
}