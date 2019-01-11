<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 11/01/2019
 * Time: 00:39
 */

/*!
*   ESTA CLASSE É RESPONSÁVEL POR CONTROLAR TUDO REFERENTE AOS ORÇAMENTOS/OSs.
*/
class Ocos_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Ativo;
    public $Nome_produto;
    public $Tipo_servico; //1 - Manutenção / 2 - Fabricação.
    public $Tempo; //quantidade de dias necessário para entregar o produto.
    public $Data_inicio; //Data prevista para início da frabricação/manutenção.
    public $Tipo; //1 - Orçamento / 2 - Ordem de serviço.
    /*!
    *   RESPONSÁVEL POR RETORNAR UMA LISTA DE ORÇAMENTOS/OS OU UM DETERMINADO ORÇAMENTO/OS.
    *
    *   $id -> Id de um orçamento/os.
    *   $ativo -> Se passado como true retorna apenas registro(s) ativo(s).
    *   $page -> Página a ser buscada na lista da consulta.
    *   $filter -> Contém campos e os respectivos valores de filtros.
    *   $ordenacao -> Contém a ordem e o campo para ordenar a lista de registros obtidos.
    */
    public function get_ocos($id, $ativo, $page, $filter, $ordenacao)
    {
        $Ativos = "";
        if($ativo == true)
            $Ativos = " AND Ativo = 1 ";

        if($id === FALSE)
        {
            $order = "";

            if($ordenacao != FALSE)
                $order = "ORDER BY ".$ordenacao['field']." ".$ordenacao['order'];

            $limit = $page * ITENS_POR_PAGINA;
            $inicio = $limit - ITENS_POR_PAGINA;
            $step = ITENS_POR_PAGINA;

            $pagination = " LIMIT ".$inicio.",".$step;
            if($page === false)
                $pagination = "";

            $query = $this->db->query("
                SELECT (SELECT count(*) FROM  Ocos WHERE TRUE ".$Ativos.") AS Size, Id AS Ocos_id,  
                Ativo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro,
                Nome_produto, Descricao, Tipo_servico, Tempo, Data_inicio, DATE_ADD(Data_inicio, INTERVAL Tempo DAY) AS Data_fim, Tipo, 
                Status_id, Usuario_criador_id, Usuario_responsavel_id, Cliente_id 
                FROM Ocos 
                WHERE TRUE ".$Ativos."
			    ".str_replace("'", "", $this->db->escape($order))." ".$pagination."");

            return json_decode(json_encode($query->result_array()),false);
        }

        $query = $this->db->query("
                SELECT Id AS Ocos_id,  
                Ativo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro,
                Nome_produto, Descricao, Tipo_servico, Tempo, Data_inicio, DATE_ADD(Data_inicio, INTERVAL Tempo DAY) AS Data_fim, Tipo, 
                Status_id, Usuario_criador_id, Usuario_responsavel_id, Cliente_id   
                FROM Ocos 
                WHERE TRUE ".$Ativos." AND Id = ".$this->db->escape($id)."");

        return json_decode(json_encode($query->row_array()),false);
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UM ORÇAMENTO/OS.
    */
    public function set_ocos()
    {
        if(empty($this->Id))
            return $this->db->insert('Ocos', $this);
        else
        {
            $this->db->where('Id', $this->Id);
            return $this->db->update('Ocos', $this);
        }
    }
}