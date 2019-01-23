<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 03/01/2019
 * Time: 22:15
 */

require_once("Geral.php");//INCLUI A CLASSE GENÉRICA.
/*!
*	ESTA CLASSE TEM POR FUNÇÃO CONTROLAR TUDO REFERENTE AS PEÇAS.
*/
class Peca extends Geral
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

        $this->load->model('Peca_model');
        $this->load->model('Categoria_model');

        $this->set_menu();
        $this->data['controller'] = strtolower(get_class($this));
        $this->data['menu_selectd'] = $this->Geral_model->get_identificador_menu(strtolower(get_class($this)));
    }
    /*!
    *	RESPONSÁVEL POR RECEBER DA MODEL TODOS AS PEÇAS CADASTRADAS E ENVIA-LAS A VIEW.
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

        $this->data['title'] = 'Peças';
        if($this->Geral_model->get_permissao(READ, get_class($this)) == TRUE)
        {
            $this->data['paginacao']['order'] =$this->inverte_ordem($ordenacao['order']);
            $this->data['paginacao']['field'] = $ordenacao['field'];

            $this->data['pecas'] = $this->Peca_model->get_peca(FALSE, FALSE, $page, FALSE, $ordenacao);
            $this->data['paginacao']['size'] = (!empty($this->data['pecas']) ? $this->data['pecas'][0]->Size : 0);
            $this->data['paginacao']['pg_atual'] = $page;
            $this->view("peca/index", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR RECEBER UMA ID DE UMA PEÇA PARA "APAGAR".
    *
    *	$id -> Id da peça.
    */
    public function deletar($id = FALSE)
    {
        if($this->Geral_model->get_permissao(DELETE, get_class($this)) == TRUE)
        {
            $this->Peca_model->deletar($id);
            $resultado = "sucesso";
            $arr = array('response' => $resultado);
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE PEÇA E RECEBER DA MODEL OS DADOS
    *	DA PEÇA QUE SE DESEJA EDITAR.
    *
    *	$id -> Id da peça.
    */
    public function edit($id = FALSE)
    {
        $this->data['title'] = 'Editar peça';
        if($this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
        {
            $this->data['obj'] = $this->Peca_model->get_peca($id, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_categoria'] = $this->Categoria_model->get_categoria(FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->view("peca/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE PEÇAS.
    */
    public function create()
    {
        $this->data['title'] = 'Nova peça';
        if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE)
        {
            $this->data['obj'] = $this->Peca_model->get_peca(0, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_categoria'] = $this->Categoria_model->get_categoria(FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->view("peca/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR VALIDAR OS DADOS NECESSÁRIOS DA PEÇA.
    */
    public function valida_peca()
    {
        if(empty($this->Peca_model->Nome))
            return "Informe o nome da peça";
        else if(mb_strlen($this->Peca_model->Nome) > 100)
            return "Máximo 100 caracteres";
        else if(empty($this->Peca_model->Estocado_em))
            return "Como será estocado?";
        else if(mb_strlen($this->Peca_model->Estocado_em) > 20)
            return "Máximo 20 caracteres";
        else if($this->Peca_model->valida_peca($this->Peca_model->Nome, $this->Peca_model->Id) == 'invalido')
            return "O nome informado para a peça já se encontra cadastrado no sistema.";
        else
            return 1;
    }
    /*!
    *	RESPONSÁVEL POR ENVIAR AO MODEL OS DADOS DE UMA PEÇA.
    */
    public function store_banco()
    {
        $this->Peca_model->set_peca();
    }
    /*!
    *	RESPONSÁVEL POR CAPTAR OS DADOS DO FORMULÁRIO SUBMETIDO.
    */
    public function store()
    {
        $resultado = "sucesso";
        $this->Peca_model->Id = $this->input->post('id');
        $this->Peca_model->Nome = $this->input->post('nome');
        $this->Peca_model->Ativo = $this->input->post('ativo');
        $this->Peca_model->Estocado_em = $this->input->post('estocado_em');
        $this->Peca_model->Categoria_id = $this->input->post('categoria_id');

        if(empty($this->Peca_model->Ativo))
            $this->Peca_model->Ativo = 0;

        //bloquear acesso direto ao metodo store
        if(!empty($this->input->post()))
        {
            if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE || $this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
            {
                $resultado = $this->valida_peca();

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
            redirect('peca/index');
    }
}