<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 11/01/2019
 * Time: 00:02
 */

require_once ("Geral.php");//INCLUI A CLASSE GENÉRICA

class Ocos extends Geral
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

        $this->load->model('Status_model');
        $this->load->model('Ocos_model');
        $this->load->model('Anexo_model');
        $this->load->model('Linha_model');
        $this->load->model('Estoque_model');

        $this->set_menu();
        $this->data['controller'] = strtolower(get_class($this));
        $this->data['menu_selectd'] = $this->Geral_model->get_identificador_menu(strtolower(get_class($this)));
    }
    /*!
    *	RESPONSÁVEL POR RECEBER DA MODEL TODOS OS ORÇAMENTOS CADASTRADOS E ENVIA-LOS A VIEW.
    *
    *	$page -> Número da página atual de registros.
    */
    public function orcamento($page = FALSE, $field = FALSE, $order = FALSE)
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
            $this->data['paginacao']['method'] = "orcamento";

            $this->data['ocos'] = $this->Ocos_model->get_ocos(FALSE, TRUE, $page, FALSE, $ordenacao);
            $this->data['paginacao']['size'] = (!empty($this->data['ocos']) ? $this->data['ocos'][0]->Size : 0);
            $this->data['paginacao']['pg_atual'] = $page;
            $this->view("ocos/orcamento", $this->data);
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
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE ORÇAMENTOS.
    */
    public function create()
    {
        $this->data['title'] = 'Novo orçamento';
        if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE)
        {
            $this->data['obj'] = $this->Ocos_model->get_ocos(0, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_cliente'] = $this->Usuario_model->get_usuario(TRUE, FALSE, FALSE, FALSE, FALSE, CLIENTE);
            $this->data['obj_categoria'] = $this->Categoria_model->get_categoria(FALSE, FALSE, FALSE, FALSE, FALSE);
            //$this->data['obj_peca'] = $this->Peca_model->get_peca(FALSE, TRUE, FALSE, FALSE, FALSE);
            $this->view("ocos/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR VALIDAR OS DADOS NECESSÁRIOS DA TRANSAÇÃO.
    */
    public function valida_transacao()
    {
        $this->Transacao_model->Preco_unitario = str_replace(',', '.',$this->Transacao_model->Preco_unitario);
        $delimitadores_preco = explode('.', $this->Transacao_model->Preco_unitario);

        $this->Transacao_model->Quantidade = str_replace(',', '.',$this->Transacao_model->Quantidade);
        $delimitadores_quantidade = explode('.', $this->Transacao_model->Quantidade);

        if($this->Transacao_model->Fornecedor_id == 0)
            return "Informe o fornecedor da peça";
        else if($this->Transacao_model->Peca_id == 0)
            return "Informe a peça";
        else if(empty($this->Transacao_model->Quantidade))
            return "Informe a quantidade";
        else if(!IS_NUMERIC($this->Transacao_model->Quantidade) || $this->Transacao_model->Quantidade <= 0 || COUNT($delimitadores_quantidade) > 1)
            return "Quantidade deve ser um número inteiro positivo e maior do que zero.";
        else if(empty($this->Transacao_model->Preco_unitario))
            return "Informe o preço unitário";
        else if(!IS_NUMERIC($this->Transacao_model->Preco_unitario) || $this->Transacao_model->Preco_unitario <= 0 || COUNT($delimitadores_preco) > 2)
            return "Preço unitário deve ser um número inteiro ou decimal positivo e maior do que zero.";
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
    /*!
    *   RESPONSÁVEL POR CARREGAR AS PEÇAS PARA ADICIONAR AO ORÇAMENTO, TODA VEZ QUE UMA CATEGORIA FOR SELECIONADA.
    *
    *   $categoria_id -> Id da categoria para se carregar todas as peças associdas a essa categoria.
    */
    public function carrega_pecas($categoria_id = FALSE)
    {
        $this->data['obj_peca'] = $this->Peca_model->get_peca_por_categoria($categoria_id);

        $resultado = $this->load->view("/ocos/_carrega_pecas", $this->data, TRUE);

        $arr = array('response' => $resultado);
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    /*!
    *   RESPONSÁVEL POR LEVANTAR O PREÇO MÉDIO UNITÁRIO DA PEÇA E CALCULAR O PREÇO TOTAL DE UMA DETERMINADA PEÇA NO ORÇAMENTO.
    *
    *   $peca_id -> Id da peça que será calculada.
    *   $quantidade -> Quantidade de peças que se deseja calcular o preço.
    */
    public function calcula_preco_peca($peca_id = FALSE, $quantidade)
    {
        $resultado = "sucesso";
        $estoque = $this->Estoque_model->get_estoque($peca_id, FALSE, FALSE, FALSE, FALSE);
        $preco_unitario = 0;
        $total = 0;
        if($quantidade <= $estoque->Saldo)
        {
            $preco_unitario = number_format($estoque->Preco_medio_unitario, 2, ',', ' ');
            $total = number_format($estoque->Preco_medio_unitario * $quantidade, 2, ',', ' ');
        }
        else
            $resultado = "A quantidade informada é superior a quantidae disponível em estoque. <br /> Quantidade disponível: ".$estoque->Saldo;

        $arr = array('response' => $resultado, 'preco_unitario' => $preco_unitario, 'total' => $total);
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
}