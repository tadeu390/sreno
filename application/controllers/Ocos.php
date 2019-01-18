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
        $this->load->model('Servico_model');
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
        $this->data['method'] = __FUNCTION__;
        $ordenacao = array(
            "order" => $this->order_default($order),
            "field" => $this->field_default($field)
        );

        $this->set_page_cookie($page);

        $this->data['title'] = 'Orçamentos';
        if($this->Geral_model->get_permissao(READ, get_class($this)) == TRUE)
        {
            $this->data['paginacao']['order'] =$this->inverte_ordem($ordenacao['order']);
            $this->data['paginacao']['field'] = $ordenacao['field'];
            $this->data['paginacao']['method'] = "orcamento";

            $this->data['ocos'] = $this->Ocos_model->get_ocos(FALSE, TRUE, $page, FALSE, $ordenacao, ORCAMENTO);
            $this->data['paginacao']['size'] = (!empty($this->data['ocos']) ? $this->data['ocos'][0]->Size : 0);
            $this->data['paginacao']['pg_atual'] = $page;
            $this->view("ocos/orcamento", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR RECEBER DA MODEL TODOS AS OSs CADASTRADAS E ENVIA-LAS A VIEW.
    *
    *	$page -> Número da página atual de registros.
    */
    public function os($page = FALSE, $field = FALSE, $order = FALSE)
    {
        if($page === FALSE)
            $page = 1;
        $this->data['method'] = __FUNCTION__;
        $ordenacao = array(
            "order" => $this->order_default($order),
            "field" => $this->field_default($field)
        );

        $this->set_page_cookie($page);

        $this->data['title'] = 'Ordem de serviço';
        if($this->Geral_model->get_permissao(READ, get_class($this)) == TRUE)
        {
            $this->data['paginacao']['order'] =$this->inverte_ordem($ordenacao['order']);
            $this->data['paginacao']['field'] = $ordenacao['field'];
            $this->data['paginacao']['method'] = "orcamento";

            $this->data['ocos'] = $this->Ocos_model->get_ocos(FALSE, TRUE, $page, FALSE, $ordenacao, OS);
            $this->data['paginacao']['size'] = (!empty($this->data['ocos']) ? $this->data['ocos'][0]->Size : 0);
            $this->data['paginacao']['pg_atual'] = $page;
            $this->view("ocos/orcamento", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE ORÇAMENTO/OS E RECEBER DA MODEL OS DADOS
    *	DE UMA OS QUE SE DESEJA EDITAR.
    *
    *	$id -> Id da OS.
    */
    public function edit_os($id = FALSE)
    {
        $this->data['method'] = __FUNCTION__;
        $this->data['title'] = 'Editar OS';
        if($this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
        {
            $this->data['obj'] = $this->Ocos_model->get_ocos($id, FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_responsavel'] = $this->Usuario_model->get_usuario(TRUE, FALSE, FALSE, FALSE, FALSE, ADMIN);
            $this->data['obj_status'] = $this->Status_model->get_status(FALSE, FALSE);
            $this->data['obj_cliente'] = $this->Usuario_model->get_usuario(TRUE, FALSE, FALSE, FALSE, FALSE, CLIENTE);
            $this->data['obj_categoria'] = $this->Categoria_model->get_categoria(FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->view("ocos/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE ORÇAMENTO E RECEBER DA MODEL OS DADOS
    *	DE UM ORÇAMENTO QUE SE DESEJA EDITAR.
    *
    *	$id -> Id do orçamento.
    */
    public function edit($id = FALSE)
    {
        $this->data['method'] = __FUNCTION__;
        $this->data['title'] = 'Editar orçamento';
        if($this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
        {
            $this->data['obj'] = $this->Ocos_model->get_ocos($id, FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_responsavel'] = $this->Usuario_model->get_usuario(TRUE, FALSE, FALSE, FALSE, FALSE, ADMIN);
            $this->data['obj_status'] = $this->Status_model->get_status(FALSE, FALSE);
            $this->data['obj_cliente'] = $this->Usuario_model->get_usuario(TRUE, FALSE, FALSE, FALSE, FALSE, CLIENTE);
            $this->data['obj_categoria'] = $this->Categoria_model->get_categoria(FALSE, FALSE, FALSE, FALSE, FALSE);

            $this->data['analisa_preco'] = $this->analisa_preco($this->data['obj']->Linhas);

            $this->view("ocos/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
     *  RESPONSÁVEL POR DETECTAR ALTERAÇÕES DE PREÇOS DE ESTOQUE NAS LINHAS DE UM ORÇAMENTO.
     *
     *  $linhas -> Linhas a serem analisadas
     */
    public function analisa_preco($Linhas)
    {
        for($i = 0; $i < COUNT($Linhas); $i++)
        {
            $Estoque = $this->Estoque_model->get_estoque($Linhas[$i]->Peca_id, FALSE, FALSE, FALSE, FALSE);
            if($Linhas[$i]->Preco_unitario != $Estoque->Preco_medio_unitario)
                return 1;
        }
        return 0;
    }
    /*!
    *	RESPONSÁVEL POR CARREGAR O FORMULÁRIO DE CADASTRO DE ORÇAMENTOS.
    */
    public function create()
    {
        $this->data['method'] = __FUNCTION__;
        $this->data['title'] = 'Novo orçamento';
        if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE)
        {
            $this->data['obj'] = $this->Ocos_model->get_ocos(0, FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->data['obj_responsavel'] = $this->Usuario_model->get_usuario(TRUE, FALSE, FALSE, FALSE, FALSE, ADMIN);
            $this->data['obj_status'] = $this->Status_model->get_status(FALSE, TRUE);
            $this->data['obj_cliente'] = $this->Usuario_model->get_usuario(TRUE, FALSE, FALSE, FALSE, FALSE, CLIENTE);
            $this->data['obj_categoria'] = $this->Categoria_model->get_categoria(FALSE, FALSE, FALSE, FALSE, FALSE);
            $this->view("ocos/create", $this->data);
        }
        else
            $this->view("templates/permissao", $this->data);
    }
    /*!
    *	RESPONSÁVEL POR VALIDAR OS DADOS NECESSÁRIOS  DO ORÇAMENTO/OS.
    */
    public function valida_ocos()
    {
        if($this->Ocos_model->Nome_produto == "")
            return "Insira o nome do produto.";
        else if(mb_strlen($this->Ocos_model->Nome_produto) > 100)
            return "Máximo de 100 caracteres.";
        else if($this->Ocos_model->Cliente_id == 0)
            return "Selecione um cliente.";
        else if($this->Ocos_model->Tipo_servico == 0)
            return "Selecione um tipo de serviço.";
        if(!empty($this->input->post('g_os')))
        {
            if ($this->Ocos_model->Data_inicio == "")
                return "Insira a data de início.";
            else if ($this->Ocos_model->Tempo == "")
                return "Informe quantos dias levará para realizar o serviço.";
            else if ($this->Ocos_model->Tempo <= 0 OR !IS_NUMERIC($this->Ocos_model->Tempo))
                return "O tempo deve ser um número positivo inteiro e maior do que zero.";
            else
                return 1;
        }
        return 1;
    }
    /*!
    *	RESPONSÁVEL POR ENVIAR AO MODEL OS DADOS DE UM ORÇAMENTO/OS.
    */
    public function store_banco()
    {
        return $this->Ocos_model->set_ocos();
    }
    /*!
    *	RESPONSÁVEL POR CAPTAR OS DADOS DO FORMULÁRIO SUBMETIDO.
    */
    public function store()
    {
        $resultado = "sucesso";

        $this->Ocos_model->Id = $this->input->post('id');
        $this->Ocos_model->Ativo = $this->input->post('ativo');
        $this->Ocos_model->Nome_produto = $this->input->post('nome');
        $this->Ocos_model->Cliente_id = $this->input->post('cliente_id');
        $this->Ocos_model->Cliente_id = $this->input->post('cliente_id');
        $this->Ocos_model->Tipo_servico = $this->input->post('tipo_servico');
        $this->Ocos_model->Tipo = ORCAMENTO;
        $this->Ocos_model->Usuario_criador_id = $this->Account_model->session_is_valid()['id'];
        $this->Ocos_model->Status_id = (!empty($this->input->post('status_ocos')) ? $this->input->post('status_ocos') : NAO_DEFINIDO);
        $this->Ocos_model->Data_inicio = $this->convert_date($this->input->post('data_inicio'), "en");
        $this->Ocos_model->Tempo = $this->input->post('tempo');
        $this->Ocos_model->Usuario_responsavel_id = (($this->input->post('usuario_responsavel') == 0) ? null : $this->input->post('usuario_responsavel'));

        //bloquear acesso direto ao metodo store
        if(!empty($this->input->post()))
        {
            if($this->Geral_model->get_permissao(CREATE, get_class($this)) == TRUE || $this->Geral_model->get_permissao(UPDATE, get_class($this)) == TRUE)
            {
                $resultado = $this->valida_ocos();

                if($resultado == 1)
                {
                    $ocos_id = $this->store_banco();
                    //verificar antes se foi removido alguma linha na tela, pelo usuário.
                    $linhas = $this->Linha_model->get_linha($ocos_id, TRUE);
                    for($i = 0; $i < $this->input->post('qtd_peça_adicionado'); $i ++)
                    {
                        if($this->input->post('peca_id_ocos_adicionado_hide_col1_lin'.$i) != null)
                        {
                            $this->Linha_model->Id = $this->input->post('linha_id_ocos'.$i);
                            $this->Linha_model->Peca_id = $this->input->post('peca_id_ocos_adicionado_hide_col1_lin' . $i);
                            $this->Linha_model->Quantidade = $this->input->post('qtd_id_ocos_adicionado_col2_lin' . $i);
                            $this->Linha_model->Preco_unitario = $this->input->post('preco_unitario_id_ocos_adicionado_col3_lin' . $i);
                            $this->Linha_model->Preco_unitario = str_replace(',', '.',$this->Linha_model->Preco_unitario);

                            $this->Linha_model->Ocos_id = $ocos_id;

                            for($j = 0; $j < COUNT($linhas); $j ++)
                            {
                                if($linhas[$j]->Linha_id == $this->Linha_model->Id)
                                    unset($linhas[$j]);
                            }
                            $linhas = array_values($linhas);//toda vez que remover uma posição do array, ressetar os indices do array para que sempre sejam sequenciais.

                            $this->Linha_model->set_linha();
                        }
                    }
                    $servicos = $this->Servico_model->get_servico($ocos_id, TRUE);

                    for($i = 0; $i < $this->input->post('qtd_serviço_adicionado'); $i++)
                    {
                        if($this->input->post('descricao_servico_id_ocos_adicionado_col0_lin'.$i) != null)
                        {
                            $this->Servico_model->Id = $this->input->post('servico_id_ocos'.$i);
                            $this->Servico_model->Descricao = $this->input->post('descricao_servico_id_ocos_adicionado_col0_lin' . $i);
                            $this->Servico_model->Valor = $this->input->post('valor_servico_id_ocos_adicionado_col1_lin' . $i);
                            $this->Servico_model->Valor = str_replace(',', '.',$this->Servico_model->Valor);
                            $this->Servico_model->Ocos_id = $ocos_id;

                            for($j = 0; $j < COUNT($servicos); $j ++)
                            {
                                if($servicos[$j]->Servico_id == $this->Servico_model->Id)
                                    unset($servicos[$j]);
                            }
                            $servicos = array_values($servicos);

                            $this->Servico_model->set_servico();
                        }
                    }

                    //apagar os que foram removidos pelo usuário na tela.
                    for($i = 0; $i < COUNT($linhas); $i ++)
                        $this->Linha_model->deletar($linhas[$i]->Linha_id);

                    for($i = 0; $i < COUNT($servicos); $i ++)
                        $this->Servico_model->deletar($servicos[$i]->Servico_id);

                    $resultado = "sucesso";
                    //verificar se deve gerar a OS
                    if($this->input->post('g_os') == 0)
                    {
                        $Linhas = $this->Ocos_model->get_ocos($ocos_id, FALSE, FALSE, FALSE, FALSE, ORCAMENTO)->Linhas;
                        $this->Linha_model->atualiza_preco_linha($Linhas);
                        $this->Ocos_model->gerar_os($ocos_id);
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
            redirect('transacao/index');
    }
    /*!
    *	RESPONSÁVEL POR RECEBER UM ID DE ORÇAMENTOS/OS PARA "APAGAR".
    *
    *	$id -> Id do orçamento/os.
    */
    public function deletar($id = FALSE)
    {
        if($this->Geral_model->get_permissao(DELETE, get_class($this)) == TRUE)
        {
            $this->Ocos_model->deletar($id);

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
        $peca = $this->Peca_model->get_peca($peca_id, FALSE, FALSE, FALSE, FALSE);
        $preco_unitario = 0;
        $total = 0;
        if($quantidade <= $estoque->Saldo)
        {
            if($peca->Estocado_em == "unidade(s)" && $this->is_decimal($quantidade))
                $resultado = "Para esta peça a quantidade deve ser um número inteiro, pois ela é estocada em unidades e não em metros.";
            else
            {
                $preco_unitario = number_format($estoque->Preco_medio_unitario, 2, ',', ' ');
                $total = number_format($estoque->Preco_medio_unitario * $quantidade, 2, ',', ' ');
            }
        }
        else
            $resultado = "A quantidade informada é superior a quantidade disponível em estoque. <br /> Quantidade disponível: ".$estoque->Saldo;

        $arr = array('response' => $resultado, 'preco_unitario' => $preco_unitario, 'total' => $total);
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
    /*!
     *   RESPONSÁVEL POR ATUALIZAR OS PREÇOS DAS LINHAS DE UM DETERMINADO ORÇAMENTO.
     *
     *  $id -> Id da um orçamento.
    */
    public function atualiza_preco($id)
    {
        $resultado = "sucesso";
        $Linhas = $this->Ocos_model->get_ocos($id, FALSE, FALSE, FALSE, FALSE, ORCAMENTO)->Linhas;
        $this->Linha_model->atualiza_preco_linha($Linhas);

        $arr = array('response' => $resultado);
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
}