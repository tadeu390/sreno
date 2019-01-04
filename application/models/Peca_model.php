<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 03/01/2019
 * Time: 22:02
 */

class Peca_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Ativo;
    public $Nome;
    public $Estocado_em;
    public $Categoria_id;
    /*!
    *	RESPONSÁVEL POR RETORNAR UMA LISTA DE PEÇAS OU UMA PEÇA ESPECÍFICA.
    *
    *	$Ativo -> Quando passado "TRUE" quer dizer pra retornar somente registro(s) ativos(s), se for passado FALSE retorna tudo.
    *	$id -> Id de uma peça específica.
    *	$page-> Número da página de registros que se quer carregar.
    */
    public function get_peca($id, $ativo, $page, $filter, $ordenacao)
    {
        $Ativos = "";
        if($ativo == true)
            $Ativos = " AND Ativo = 1 ";

        if($id === false)
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
                SELECT (SELECT count(*) FROM  Peca) AS Size, Id AS Peca_id, Nome AS Nome_peca, Ativo, Categoria_id, Estocado_em 
                    FROM Peca 
                WHERE TRUE ".$Ativos."
                ".str_replace("'", "", $this->db->escape($order))." ".$pagination."");

            return json_decode(json_encode($query->result_array()),false);
        }

        $query = $this->db->query("
            SELECT Id AS Peca_id, Nome AS Nome_peca, Ativo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro, Categoria_id, Estocado_em 
                FROM Peca 
            WHERE Id = ".$this->db->escape($id)." ".$Ativos."");

        return json_decode(json_encode($query->row_array()),false);
    }
    /*!
    *	RESPONSÁVEL POR "APAGAR" UMA PEÇA DO BANCO DE DADOS.
    *
    *	$id -> Id da peça a ser "apagada".
    */
    public function deletar($id)
    {
        return $this->db->query("
            UPDATE Peca SET Ativo = 0 
            WHERE Id = ".$this->db->escape($id)."");
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UMA PEÇA NO BANCO DE DADOS.
    *
    *	$data -> Contém os dados da peça.
    */
    public function set_peca()
    {
        if(empty($this->Id))
            return $this->db->insert('Peca', $this);
        else
        {
            $this->db->where('Id', $this->Id);
            return $this->db->update('Peca', $this);
        }
    }
    /*!
    *	RESPONSÁVEL POR VERIFICAR SE UMA DETERMINADA PEÇA JÁ EXISTE NO BANCO DE DADOS.
    */
    public function valida_peca()
    {
        $query = $this->db->query("
            SELECT Nome FROM Peca 
            WHERE UPPER(Nome) = UPPER(".$this->db->escape($this->Nome).")");
        $query = $query->row_array();

        $registro_banco = $this->get_peca($this->Id, FALSE, FALSE, FALSE, FALSE);

        if(!empty($registro_banco) && $query['Nome'] == $registro_banco->Nome_peca)
            return "valido";
        else if(empty($query['Nome']))
            return "valido";
        return "invalido";
    }
}