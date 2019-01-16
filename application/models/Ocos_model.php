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
    public $Status_id;
    public $Usuario_responsavel_id;
    public $Usuario_criador_id;
    public $Cliente_id;

    public $Status;
    public $Responsavel;
    public $Criador;
    public $Cliente;

    public function __construct()
    {
        $this->Ativo = 1;
        $this->load->model('Status_model');
        $this->load->model('Usuario_model');

        $this->Status = $this->Status_model;
        $this->Responsavel = $this->Usuario_model;
        $this->Criador = $this->Usuario_model;
        $this->Cliente = $this->Usuario_model;
    }
    /*!
    *   RESPONSÁVEL POR RETORNAR UMA LISTA DE ORÇAMENTOS/OS OU UM DETERMINADO ORÇAMENTO/OS.
    *
    *   $id -> Id de um orçamento/os.
    *   $ativo -> Se passado como true retorna apenas registro(s) ativo(s).
    *   $page -> Página a ser buscada na lista da consulta.
    *   $filter -> Contém campos e os respectivos valores de filtros.
    *   $ordenacao -> Contém a ordem e o campo para ordenar a lista de registros obtidos.
    */
    public function get_ocos($id, $ativo, $page, $filter, $ordenacao, $tipo)
    {
        $t = "";
        if($tipo !== FALSE)
            $t = " AND Tipo = ".$tipo;

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
                Nome_produto, Descricao, Tipo_servico, Tempo, DATE_FORMAT(Data_inicio, '%d/%m/%Y') AS Data_inicio, 
                DATE_FORMAT(DATE_ADD(Data_inicio, INTERVAL Tempo DAY), '%d/%m/%Y') AS Data_fim, Tipo, 
                Status_id, Usuario_criador_id, Usuario_responsavel_id, Cliente_id 
                FROM Ocos 
                WHERE TRUE ".$Ativos." ".$t."
			    ".str_replace("'", "", $this->db->escape($order))." ".$pagination."");

            return $query->result_object();
        }

        $query = $this->db->query("
                SELECT Id AS Ocos_id,  
                Ativo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro, 
                Nome_produto, Descricao, Tipo_servico, Tempo, DATE_FORMAT(Data_inicio, '%d/%m/%Y') AS Data_inicio, 
                DATE_FORMAT(DATE_ADD(Data_inicio, INTERVAL Tempo DAY), '%d/%m/%Y') AS Data_fim, Tipo,   
                Status_id, Usuario_criador_id, Usuario_responsavel_id, Cliente_id    
                FROM Ocos 
                WHERE TRUE ".$Ativos." AND Id = ".$this->db->escape($id)."");

        return $query->row_object();
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UM ORÇAMENTO/OS.
    */
    public function set_ocos()
    {
        if(empty($this->Id))
        {
            $this->db->insert('Ocos', $this);

            $query = $this->db->query("SELECT Id FROM Ocos  
                WHERE Cliente_id = ".$this->db->escape($this->Cliente_id)." AND  
                Usuario_criador_id = ".$this->db->escape($this->Usuario_criador_id)." AND 
                Nome_produto = ".$this->db->escape($this->Nome_produto)." 
                ORDER BY Id DESC LIMIT 1
            ");
            return $query->row_object()->Id;
        }
        else
        {
            $this->db->where('Id', $this->Id);
            $this->db->update('Ocos', $this);
            return $this->Id;
        }
    }
}