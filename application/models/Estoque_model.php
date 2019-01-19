<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/01/2019
 * Time: 22:47
 */
/*!
 *  ESTA CLASSE É RESPONSÁVEL POR GERENCIAR O ESTOQUE DE CADA PEÇA NO BANCO DE DADOS
 */
class Estoque_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Saldo;
    public $Preco_medio_unitario;
    public $Peca_id;
    /*!
    *	RESPONSÁVEL POR RETORNAR UMA LISTA DE ESTOQUE OU UM ESTOQUE ESPECÍFIC.
    *
    *	$Ativo -> Quando passado "TRUE" quer dizer pra retornar somente registro(s) ativos(s), se for passado FALSE retorna tudo.
    *	$peca -> Id de uma peça do estoque.
    *	$page-> Número da página de registros que se quer carregar.
    */
    public function get_estoque($peca_id, $ativo, $page, $filter, $ordenacao)
    {
        $Ativos = "";
        if($ativo == true)
            $Ativos = " AND e.Ativo = 1 ";

        if($peca_id === false)
        {
            $limit = $page * ITENS_POR_PAGINA;
            $inicio = $limit - ITENS_POR_PAGINA;
            $step = ITENS_POR_PAGINA;

            $order = "";

            if($ordenacao != FALSE)
                $order = "ORDER BY ".$ordenacao['field']." ".$ordenacao['order'];

            $pagination = " LIMIT ".$inicio.",".$step;
            if($page === false)
                $pagination = "";

            $query = $this->db->query("
                SELECT * FROM (
                SELECT (SELECT count(*) FROM  Estoque) AS Size, e.Id AS Estoque_id, e.Preco_medio_unitario, e.Peca_id, e.Saldo, p.Nome AS Nome_peca, p.Estocado_em,
                (e.Preco_medio_unitario * e.Saldo) AS Total_estoque 
                    FROM Estoque e 
                    INNER JOIN Peca p ON e.Peca_id = p.Id 
                WHERE TRUE ".$Ativos." 
                 ".$pagination.") AS x ".str_replace("'", "", $this->db->escape($order))."");

            return $query->result_object();
        }

        $query = $this->db->query("
            SELECT Id AS Estoque_id, Saldo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro, Preco_medio_unitario, Peca_id  
                FROM Estoque 
            WHERE Peca_id = ".$this->db->escape($peca_id)." ".$Ativos."");

        return $query->row_object();
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UM ESTOQUE NO BANCO DE DADOS.
    *
    *   $transacao -> Dados da transação realizada, para atualizar o estoque.
    */
    public function set_estoque($transacao)
    {
        $estoque = $this->get_estoque($transacao->Peca_id, FALSE, FALSE, FALSE, FALSE);
        $this->Peca_id = $transacao->Peca_id;
        $this->Saldo = $transacao->Quantidade;

        $this->Preco_medio_unitario = $transacao->Preco_unitario;

        if(empty($estoque))
            $this->db->insert('Estoque', $this);
        else
        {
            $this->Saldo = $estoque->Saldo + $transacao->Quantidade;
            $this->Id = $estoque->Estoque_id;
            $valor_estoque = $estoque->Saldo * $estoque->Preco_medio_unitario;
            $valor_transacao = $transacao->Preco_unitario * $transacao->Quantidade;
            $total = $valor_estoque + $valor_transacao;

            $this->Preco_medio_unitario = $total / $this->Saldo;
            $this->Preco_medio_unitario = number_format($this->Preco_medio_unitario ,2, '.', ' ');
            $this->db->where('Peca_id', $this->Peca_id);
            $this->db->update('Estoque', $this);
        }
    }
	/*!
	 *  RESPONSÁVEL POR RECALCULAR O OS DADOS DE ESTOQUE DE UMA DETERMINADA PEÇA SEMPRE QUE UMA TRANSAÇÃO FOR ALTERADA (QUANTIDADE OU PREÇO UNITÁRIO)
	 *
	 *  $transacao -> Transação cadastrada no banco de dados.
	 *  $transacao_alterada -> Transação alterada pelo usuário no formulário.
	 */
	public function altera_estoque($transacao, $transacao_alterada)
	{
        /////////////////ATUALIZA OS DADOS DE ESTOQUE DA PEÇA LEVANDO O PREÇO ALTERADO
		$estoque = $this->get_estoque($transacao->Peca_id, FALSE, FALSE, FALSE, FALSE);
		$this->Id = $estoque->Estoque_id;

        $valor_estoque = $estoque->Saldo * $estoque->Preco_medio_unitario;

        $valor_transacao = ($transacao_alterada->Preco_unitario - $transacao->Preco_unitario) * $transacao->Quantidade;

        $total = $valor_estoque + $valor_transacao;
        $this->Saldo = $estoque->Saldo;
        $this->Preco_medio_unitario = $total / $this->Saldo;
        $this->Preco_medio_unitario = number_format($this->Preco_medio_unitario ,2, '.', ' ');
        $this->Peca_id = $transacao->Peca_id;

        $this->db->where('Peca_id', $this->Peca_id);
        $this->db->update('Estoque', $this);

        /////////////////ATUALIZA OS DADOS DE ESTOQUE DA PEÇA LEVANDO A QUANTIDADE ALTERADA

        //depois que atualizou para preço modificado, então carregar novamente do banco para pegar o estoque atualizado
        $estoque = $this->get_estoque($transacao->Peca_id, FALSE, FALSE, FALSE, FALSE);
        $valor_estoque = $estoque->Saldo * $estoque->Preco_medio_unitario;
        $valor_transacao = $transacao_alterada->Preco_unitario * ($transacao_alterada->Quantidade - $transacao->Quantidade);

        $total = $valor_estoque + $valor_transacao;

        $this->Saldo = $estoque->Saldo + ($transacao_alterada->Quantidade - $transacao->Quantidade);

        $this->Preco_medio_unitario = $total / $this->Saldo;
        $this->Preco_medio_unitario = number_format($this->Preco_medio_unitario ,2, '.', ' ');
        $this->Peca_id = $transacao->Peca_id;

        $this->db->where('Peca_id', $this->Peca_id);
        $this->db->update('Estoque', $this);
	}
    /*!
     *  RESPONSÁVEL POR RECALCULAR O OS DADOS DE ESTOQUE DE UMA DETERMINADA PEÇA SEMPRE QUE UMA TRANSAÇÃO FOR APAGADA (QUANTIDADE OU PREÇO UNITÁRIO)
     *
     *	$transacao -> Transação cadastrada no banco de dados.
	 *  $transacao_alterada -> Transação alterada para poder zerar a incidência no estoque de uma peça..
     */
	public function deletar($transacao, $transacao_alterada)
    {
        $estoque = $this->get_estoque($transacao->Peca_id, FALSE, FALSE, FALSE, FALSE);
        $this->Id = $estoque->Estoque_id;

        $valor_estoque = $estoque->Saldo * $estoque->Preco_medio_unitario;

        $valor_transacao = ($transacao_alterada->Preco_unitario - $transacao->Preco_unitario) * $transacao->Quantidade;

        $total = $valor_estoque + $valor_transacao;
        $this->Saldo = $estoque->Saldo - $transacao_alterada->Quantidade;
        $this->Preco_medio_unitario = 0;
        if($total > 0)
            $this->Preco_medio_unitario = $total / $this->Saldo;

        $this->Preco_medio_unitario = number_format($this->Preco_medio_unitario ,2, '.', ' ');
        $this->Peca_id = $transacao->Peca_id;

        $this->db->where('Peca_id', $this->Peca_id);
        $this->db->update('Estoque', $this);
    }
    /*!
     *  RESPONSÁVEL POR FAZER A ANÁLISE DE DISPONIBILIDADE DE PEÇAS EM ESTOQUE ANTES DE GERAR UMA ORDEM DE SERVIÇO PARA CADA LINHA
     *  SE UMA LINHA SEQUER ESTIVER COM QUANTIDADE INSUFICIENTE, NÃO SERÁ POSSÍVEL GERAR A ORDEM DE SERVIÇO ATÉ QUE O ESTOQUE DA PEÇA SEJA AUMENTADO.
     *
     *  $Linhas -> Lista de objetos que contém as informações de cada linha de uma OS.
     *  @return -> Retorna true para análise ok e false para análise com identificação de indisponibilidade de estoque.
     */
    public function analise_pre_debito($Linhas)
    {
        for($i = 0; $i < COUNT($Linhas); $i++)
        {
            $estoque = $this->get_estoque($Linhas[$i]->Peca_id, FALSE, FALSE, FALSE, FALSE);
            if($estoque->Saldo < $Linhas[$i]->Quantidade)
                return false;
        }
        return true;
    }
    /*!
     *  RESPONSÁVEL POR DEBITAR DO ESTOQUE UMA QUANTIDADE POR PEÇA TODA VEZ QUE UMA OS É GERADA NO SISTEMA.
     *
     *  $Linha -> Objeto que contém as informações de uma linha de uma OS.
     */
    public function debita_quantidade($Linha)
    {
        $estoque = $this->get_estoque($Linha->Peca_id, FALSE, FALSE, FALSE, FALSE);
        $this->Peca_id = $Linha->Peca_id;

        $this->Id = $estoque->Estoque_id;
        $this->Preco_medio_unitario = $estoque->Preco_medio_unitario;
        $this->Saldo = $estoque->Saldo - $Linha->Quantidade;

        $this->db->where('Peca_id', $this->Peca_id);
        $this->db->update('Estoque', $this);
    }
}