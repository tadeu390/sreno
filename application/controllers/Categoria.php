<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 27/12/2018
 * Time: 21:40
 */

require_once("Geral.php");//INCLUI A CLASSE GENÉRICA.
/*!
*	ESTA CLASSE TEM POR FUNÇÃO CONTROLAR TUDO REFERENTE AS CATEGORIAS DE PEÇAS.
*/
class Categoria extends Geral
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

        $this->load->model('Categoria_model');

        $this->set_menu();
        $this->data['controller'] = strtolower(get_class($this));
        $this->data['menu_selectd'] = $this->Geral_model->get_identificador_menu(strtolower(get_class($this)));
    }
    /*!
    *	RESPONSÁVEL POR RECEBER DA MODEL TODOS AS CATEGORIAS CADASTRADAS E ENVIA-LAS A VIEW.
    *
    *	$page -> Número da página atual de registros.
    */
    public function index($page = FALSE, $field = FALSE, $order = FALSE)
    {
        if($page === FALSE)
            $page = 1;

        $ordenacao = array(
            "order" => $this->order_default($order),
            "field" => $this->field_default($field)
        );

        $this->set_page_cookie($page);

        $this->data['title'] = 'Categorias';
        if($this->Geral_model->get_permissao(READ, get_class($this)) == TRUE)
        {
            $this->data['paginacao']['order'] =$this->inverte_ordem($ordenacao['order']);
            $this->data['paginacao']['field'] = $ordenacao['field'];

            $this->data['categorias'] = $this->Categoria_model->get_categoria(FALSE, FALSE, $page, FALSE, $ordenacao);
            $this->data['paginacao']['size'] = (!empty($this->data['categorias']) ? $this->data['categorias'][0]['Size'] : 0);
            $this->data['paginacao']['pg_atual'] = $page;
            $this->view("categoria/index", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR RECEBER UMA ID DE UMA CATEGORIA PARA "APAGAR".
    *
    *	$id -> Id da categoria.
    */
    public function deletar($id = FALSE)
    {
        if($this->Geral_model->get_permissao(DELETE, get_class($this)) == TRUE)
        {
            $this->Categoria_model->deletar($id);
            $resultado = "sucesso";
            $arr = array('response' => $resultado);
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE CATEGORIA E RECEBER DA MODEL OS DADOS
    *	DA CATEGORIA QUE SE DESEJA EDITAR.
    *
    *	$id -> Id da categoria.
    */
    public function edit($id = FALSE)
    {
        $this->data['title'] = 'Editar categoria';
        if($this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
        {
            $this->data['obj'] = $this->Categoria_model->get_categoria($id, FALSE, FALSE, FALSE, FALSE);
            $this->view("categoria/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE CATEGORIAS.
    */
    public function create()
    {
        $this->data['title'] = 'Nova categoria';
        if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE)
        {
            $this->data['obj'] = $this->Categoria_model->get_categoria(0, FALSE, FALSE, FALSE, FALSE);
            $this->view("categoria/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR VALIDAR OS DADOS NECESSÁRIOS DA CATEGORIA.
    */
    public function valida_categoria()
    {
        if(empty($this->Categoria_model->Nome))
            return "Informe o nome de menu";
        else if(mb_strlen($this->Categoria_model->Nome) > 20)
            return "Máximo 20 caracteres";
        else if($this->Categoria_model->valida_categoria($this->Categoria_model->Nome, $this->Categoria_model->Id) == 'invalido')
            return "O nome informado para a categoria já se encontra cadastrado no sistema.";
        else
            return 1;
    }
    /*!
    *	RESPONSÁVEL POR ENVIAR AO MODEL OS DADOS DE UMA CATEGORIA.
    */
    public function store_banco()
    {
        $this->Categoria_model->set_categoria();
    }
    /*!
    *	RESPONSÁVEL POR CAPTAR OS DADOS DO FORMULÁRIO SUBMETIDO.
    */
    public function store()
    {
        $resultado = "sucesso";
        $this->Categoria_model->Id = $this->input->post('id');
        $this->Categoria_model->Nome = $this->input->post('nome');
        $this->Categoria_model->Ativo = $this->input->post('ativo');

        if(empty($this->Categoria_model->Ativo))
            $this->Categoria_model->Ativo = 0;

        //bloquear acesso direto ao metodo store
        if(!empty($this->input->post()))
        {
            if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE || $this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
            {
                $resultado = $this->valida_categoria();

                if($resultado == 1)
                {
                    $this->store_banco();
                    $resultado = "sucesso";
                }
            }
            else
                $resultado = "Você não tem permissão para realizar esta ação.";

            $arr = array('response' => $resultado);
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
        else
            redirect('categoria/index');
    }
}