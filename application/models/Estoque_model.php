<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/01/2019
 * Time: 22:47
 */
/*!
 *  ESTA CLASSE É RESPONSÁVEL POR GERENCIAR O ESTOQUE DE CADA PEÇA NO BANCO DE DADOS
 * */
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

            return json_decode(json_encode($query->result_array()),false);
        }

        $query = $this->db->query("
            SELECT Id AS Estoque_id, Saldo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro, Preco_medio_unitario, Peca_id  
                FROM Estoque 
            WHERE Peca_id = ".$this->db->escape($peca_id)." ".$Ativos."");

        return json_decode(json_encode($query->row_array()),false);
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
        //$this->Id = "";

        if($transacao->Quantidade > 0)
        {
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

                $this->db->where('Peca_id', $this->Peca_id);
                $this->db->update('Estoque', $this);
            }
        }
        else
        {
            $this->Preco_medio_unitario = $estoque->Preco_medio_unitario;
            $this->Saldo = $estoque->Saldo + $transacao->Quantidade;

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
		$estoque = $this->get_estoque($transacao->Peca_id, FALSE, FALSE, FALSE, FALSE);
		$this->Id = $estoque->Estoque_id;

        $valor_estoque = $estoque->Saldo * $estoque->Preco_medio_unitario;
        if($transacao_alterada->Preco_unitario != $transacao->Preco_unitario)
        {
            $valor_transacao = ($transacao_alterada->Preco_unitario - $transacao->Preco_unitario) * $transacao->Quantidade;

            $total = $valor_estoque + $valor_transacao;
            $this->Saldo = $estoque->Saldo;
            $this->Preco_medio_unitario = $total / $this->Saldo;
            $this->Peca_id = $transacao->Peca_id;

            $this->db->where('Peca_id', $this->Peca_id);
            $this->db->update('Estoque', $this);
        }
        if($transacao_alterada->Quantidade != $transacao->Quantidade)
        {
            //depois que atualizou para preço modificado, então carregar novamente do banco para pegar o estoque atualizado
            $estoque = $this->get_estoque($transacao->Peca_id, FALSE, FALSE, FALSE, FALSE);
            $valor_transacao =  $transacao->Preco_unitario * ($transacao_alterada->Quantidade - $transacao->Quantidade);

            $total = $valor_estoque + $valor_transacao;
            $this->Saldo = $estoque->Saldo + ($transacao_alterada->Quantidade - $transacao->Quantidade);

            $this->Preco_medio_unitario = $total / $this->Saldo;
            $this->Peca_id = $transacao->Peca_id;

            $this->db->where('Peca_id', $this->Peca_id);
            $this->db->update('Estoque', $this);
        }
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
        $this->Preco_medio_unitario = $total / $this->Saldo;
        $this->Peca_id = $transacao->Peca_id;

        $this->db->where('Peca_id', $this->Peca_id);
        $this->db->update('Estoque', $this);
    }
}