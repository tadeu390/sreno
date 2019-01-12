<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/01/2019
 * Time: 22:29
 */

/*!
 *  ESTA CLASSE É RESPONSÁVEL POR GERENCIAR AS TRANSAÇÕES DE PEÇAS NO BANCO DE DADOS, ISTO É, QUAMDO ENTRA OU SAI PEÇA
 * */
class Transacao_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Quantidade;
    public $Preco_unitario;
    public $Fornecedor_id;
    public $Peca_id;
    public $Peca;

    public function __construct()
    {
        $this->load->model('Peca_model');
        $this->Peca = $this->Peca_model;
    }
    /*!
    *	RESPONSÁVEL POR RETORNAR UMA LISTA DE TRANSAÇÕES OU UMA TRANSAÇÃO ESPECÍFICA.
    *
    *	$Ativo -> Quando passado "TRUE" quer dizer pra retornar somente registro(s) ativos(s), se for passado FALSE retorna tudo.
    *	$id -> Id de uma transação específica.
    *	$page-> Número da página de registros que se quer carregar.
    */
    public function get_transacao($id, $ativo, $page, $filter, $ordenacao)
    {
        $Ativos = "";
        if($ativo == true)
            $Ativos = " AND t.Ativo = 1 ";

        if($id === false)
        {
            $limit = $page * ITENS_POR_PAGINA;
            $inicio = $limit - ITENS_POR_PAGINA;
            $step = ITENS_POR_PAGINA;

            $order = "";

            if($ordenacao != FALSE)
                $order = "ORDER BY " . $ordenacao['field'] . " " . $ordenacao['order'];

            $pagination = " LIMIT ".$inicio.",".$step;
            if($page === false)
                $pagination = "";

            $query = $this->db->query(" 
                  SELECT * FROM (
                    SELECT (SELECT count(*) FROM  Transacao t WHERE  TRUE ".$Ativos.") AS Size, t.Id AS Transacao_id, 
                    t.Preco_unitario, t.Fornecedor_id, t.Peca_id, t.Quantidade, 
                    DATE_FORMAT(t.Data_registro, '%d/%m/%Y') as Data_registro, t.Ativo  
                    FROM Transacao t 
                    WHERE TRUE ".$Ativos."
                 ".$pagination.") AS x ".str_replace("'", "", $this->db->escape($order))."");

            ///POR ENQUANTO ISSO NÃO É INTERESSANTE, POIS DA PROBLEMA PRA ORDENAR, UTILIZAR ISSO APENAS EM LUGARES QUE NÃO VOLTAM LISTA PARA ORDENACAO
            $this->model = $query->result_object();
            for($i = 0; $i < COUNT($this->model); $i++)
                $this->model[$i]->Peca = $this->Peca->get_peca($this->model[$i]->Peca_id, $this->model[$i]->Ativo, FALSE, FALSE, FALSE);

            return $this->model;
        }

        $query = $this->db->query("
            SELECT Id AS Transacao_id, Quantidade, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro, Preco_unitario, Fornecedor_id, Peca_id, Ativo   
                FROM Transacao 
            WHERE Id = ".$this->db->escape($id)." ".$Ativos."");

        return $query->row_object();
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UMA TRANSAÇÃO NO BANCO DE DADOS.
    */
    public function set_transacao()
    {
        if(empty($this->Id))
            return $this->db->insert('Transacao', $this);
        else
        {
            $this->db->where('Id', $this->Id);
            return $this->db->update('Transacao', $this);
        }
    }
    /*!
    *	RESPONSÁVEL POR "APAGAR" UM TRANSAÇÃO DO BANCO DE DADOS.
    *
    *	$id -> Id da transação a ser "apagada".
    */
    public function deletar($id)
    {
        return $this->db->query("
            UPDATE Transacao SET Ativo = 0 
            WHERE Id = ".$this->db->escape($id)."");
    }
}
/*  function cm ($one, $two)
            {
                $t = $one->Quantidade;
                $t2 = $two->Quantidade;
                if ($t === $t2) {
                    return 0;
                }
                return $t < $t2 ? -1 : 1;
            }
            usort($this->model, "cm");*/