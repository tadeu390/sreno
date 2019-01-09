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
            {
                if(strstr($ordenacao['field'], '.') == FALSE)
                    $order = "ORDER BY t." . $ordenacao['field'] . " " . $ordenacao['order'];
                else
                    $order = "ORDER BY " . $ordenacao['field'] . " " . $ordenacao['order'];
            }

            $pagination = " LIMIT ".$inicio.",".$step;
            if($page === false)
                $pagination = "";

            $query = $this->db->query("
                SELECT (SELECT count(*) FROM  Transacao) AS Size, t.Id AS Transacao_id, t.Preco_unitario, t.Fornecedor_id, t.Peca_id, t.Quantidade, p.Nome AS Nome_peca, 
                DATE_FORMAT(t.Data_registro, '%d/%m/%Y') as Data_registro, p.Estocado_em, t.Ativo  
                    FROM Transacao t 
                    INNER  JOIN  Peca p ON t.Peca_id = p.Id 
                WHERE TRUE ".$Ativos."
                ".str_replace("'", "", $this->db->escape($order))." ".$pagination."");

            return json_decode(json_encode($query->result_array()),false);
        }

        $query = $this->db->query("
            SELECT Id AS Transacao_id, Quantidade, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro, Preco_unitario, Fornecedor_id, Peca_id, Ativo   
                FROM Transacao 
            WHERE Id = ".$this->db->escape($id)." ".$Ativos."");

        return json_decode(json_encode($query->row_array()),false);
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UMA TRANSAÇÃO NO BANCO DE DADOS.
    *
    *	$data -> Contém os dados da transação.
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