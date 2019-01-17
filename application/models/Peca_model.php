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

    public $Categoria;

    public function __construct()
    {
        $this->load->model('Categoria_model');
        $this->Categoria = $this->Categoria_model;
        $this->model = new stdClass();

        $this->model->Categoria = new stdClass();
    }

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

            return $query->result_object();
        }

        $query = $this->db->query("
            SELECT Id AS Peca_id, Nome AS Nome_peca, Ativo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro, Categoria_id, Estocado_em 
                FROM Peca 
            WHERE Id = ".$this->db->escape($id)." ".$Ativos."");

        if(!empty($query->row_object()))
        {
            $this->model = $query->row_object();
            $this->model->Categoria = $this->Categoria->get_categoria($this->model->Categoria_id, FALSE, FALSE, FALSE, FALSE);
        }
        return $this->model;
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

        if(!empty($registro_banco->Nome_peca) && $query['Nome'] == $registro_banco->Nome_peca)
            return "valido";
        else if(empty($query['Nome']))
            return "valido";
        return "invalido";
    }
    /*!
     *  RESPONSÁVEL POR CARREGAR DO BANCO AS PEÇAS DE ACORDO COM A ID DA CATEGORIA INFORMADA.
     *
     * $categoria_id -> Contém a id da categoria que se deseja carregar as peças.
     * */
    public function get_peca_por_categoria($categoria_id)
    {
        $query = $this->db->query("
                SELECT (SELECT count(*) FROM  Peca) AS Size, p.Id AS Peca_id, p.Nome AS Nome_peca, p.Ativo, p.Categoria_id, p.Estocado_em 
                    FROM Peca p 
                    INNER JOIN Estoque e ON e.Peca_id = p.Id AND e.Saldo > 0 
                WHERE Categoria_id = ".$this->db->escape_str($categoria_id)." AND Ativo = 1");

        return $query->result_object();
    }
}