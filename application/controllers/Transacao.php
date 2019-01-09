<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/01/2019
 * Time: 22:50
 */

require_once("Geral.php");//INCLUI A CLASSE GENÉRICA.
/*!
*	ESTA CLASSE TEM POR FUNÇÃO CONTROLAR TUDO REFERENTE AS TRANSAÇÕES DE ESTOQUE.
*/
class Transacao extends Geral
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

        $this->load->model('Transacao_model');
        $this->load->model('Estoque_model');
        $this->load->model('Fornecedor_model');

        $this->set_menu();
        $this->data['controller'] = strtolower(get_class($this));
        $this->data['menu_selectd'] = $this->Geral_model->get_identificador_menu(strtolower(get_class($this)));
    }
    /*!
    *	RESPONSÁVEL POR RECEBER DA MODEL TODOS AS TRANSAÇÕES CADASTRADAS E ENVIA-LAS A VIEW.
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

            $this->data['transacoes'] = $this->Transacao_model->get_transacao(FALSE, TRUE, $page, FALSE, $ordenacao);
            $this->data['paginacao']['size'] = (!empty($this->data['transacoes']) ? $this->data['transacoes'][0]->Size : 0);
            $this->data['paginacao']['pg_atual'] = $page;
            $this->view("transacao/index", $this->data);
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
            $this->data['obj'] = $this->Transacao_model->get_transacao($id, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_peca'] = $this->Peca_model->get_peca(FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_fornecedor'] = $this->Fornecedor_model->get_fornecedor(FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->view("transacao/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE TRANSAÇÕES.
    */
    public function create()
    {
        $this->data['title'] = 'Nova transação';
        if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE)
        {
            $this->data['obj'] = $this->Transacao_model->get_transacao(0, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_peca'] = $this->Peca_model->get_peca(FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_fornecedor'] = $this->Fornecedor_model->get_fornecedor(FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->view("transacao/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR VALIDAR OS DADOS NECESSÁRIOS DA TRANSAÇÃO.
    */
    public function valida_transacao()
    {
        if($this->Transacao_model->Fornecedor_id == 0)
            return "Informe o fornecedor da peça";
        else if($this->Transacao_model->Peca_id == 0)
            return "Informe a peça";
        else if(empty($this->Transacao_model->Quantidade))
            return "Informe a quantidade";
        else if(empty($this->Transacao_model->Preco_unitario))
            return "Informe o preço unitário";
        else
            return 1;
    }
    /*!
    *	RESPONSÁVEL POR ENVIAR AO MODEL OS DADOS DE UMA PEÇA.
    */
    public function store_banco()
    {
        if(empty($this->Transacao_model->Id))
        {
            $this->Transacao_model->set_transacao();
            $this->Estoque_model->set_estoque($this->Transacao_model);
        }
        else
        {
            $transacao = $this->Transacao_model->get_transacao($this->Transacao_model->Id, FALSE, FALSE, FALSE, FALSE);
            $this->Estoque_model->altera_estoque($transacao, $this->Transacao_model);

            $this->Transacao_model->set_transacao();
        }
    }
    /*!
    *	RESPONSÁVEL POR CAPTAR OS DADOS DO FORMULÁRIO SUBMETIDO.
    */
    public function store()
    {
        $resultado = "sucesso";
        $this->Transacao_model->Id = $this->input->post('id');
        $this->Transacao_model->Fornecedor_id = $this->input->post('fornecedor_id');
        $this->Transacao_model->Peca_id = $this->input->post('peca_id');
        $this->Transacao_model->Quantidade = $this->input->post('quantidade');
        $this->Transacao_model->Preco_unitario = $this->input->post('preco_unitario');

        //bloquear acesso direto ao metodo store
        if(!empty($this->input->post()))
        {
            if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE || $this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
            {
                $resultado = $this->valida_transacao();

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
            redirect('transacao/index');
    }
    /*!
    *	RESPONSÁVEL POR RECEBER UM ID DA TRANSAÇÃO PARA "APAGAR".
    *
    *	$id -> Id da transação.
    */
    public function deletar($id = FALSE)
    {
        if($this->Geral_model->get_permissao(DELETE, get_class($this)) == TRUE)
        {
            $transacao = $this->Transacao_model->get_transacao($id, FALSE, FALSE, FALSE, FALSE);
            $transacao_alterada = $this->Transacao_model->get_transacao($id, FALSE, FALSE, FALSE, FALSE);
            $transacao_alterada->Preco_unitario = 0;
            $this->Estoque_model->deletar($transacao, $transacao_alterada);
            $this->Transacao_model->deletar($id);

            $resultado = "sucesso";
            $arr = array('response' => $resultado);
            header('Content-Type: application/json');
            echo json_encode($arr);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
}