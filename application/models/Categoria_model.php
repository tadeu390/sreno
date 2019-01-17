<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 27/12/2018
 * Time: 21:42
 */

require_once("Geral_model.php");//INCLUI A CLASSE GENÉRICA.
/*!
*	ESTA MODEL TRATA DAS OPERAÇÕES NA BASE DE DADOS REFERENTE AS CATEGORIAS DE PEÇAS.
*/
class Categoria_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Ativo;
    public $Nome;
    /*!
    *	RESPONSÁVEL POR RETORNAR UMA LISTA DE CATEGORIAS OU UMA CATEGORIA ESPECÍFICA.
    *
    *	$Ativo -> Quando passado "TRUE" quer dizer pra retornar somente registro(s) ativos(s), se for passado FALSE retorna tudo.
    *	$id -> Id de uma categoria específica.
    *	$page-> Número da página de registros que se quer carregar.
    */
    public function get_categoria($id, $ativo, $page, $filter, $ordenacao)
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
                SELECT (SELECT count(*) FROM  Categoria) AS Size, Id AS Categoria_id, Nome AS Nome_categoria, Ativo 
                    FROM Categoria 
                WHERE TRUE ".$Ativos."
                ".str_replace("'", "", $this->db->escape($order))." ".$pagination."");

            return $query->result_object();
        }

        $query = $this->db->query("
            SELECT Id AS Categoria_id, Nome AS Nome_categoria, Ativo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro
                FROM Categoria 
            WHERE Id = ".$this->db->escape($id)." ".$Ativos."");

        return $query->row_object();
    }
    /*!
    *	RESPONSÁVEL POR "APAGAR" UMA CATEGORIA DO BANCO DE DADOS.
    *
    *	$id -> Id da categoria a ser "apagado".
    */
    public function deletar($id)
    {
        return $this->db->query("
            UPDATE Categoria SET Ativo = 0 
            WHERE Id = ".$this->db->escape($id)."");
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UMA CATEGORIA NO BANCO DE DADOS.
    *
    *	$data -> Contém os dados da categoria.
    */
    public function set_categoria()
    {
        if(empty($this->Id))
            return $this->db->insert('Categoria', $this);
        else
        {
            $this->db->where('Id', $this->Id);
            return $this->db->update('Categoria', $this);
        }
    }
    /*!
    *	RESPONSÁVEL POR VERIFICAR SE UMA DETERMINADA CATEGORIA JÁ EXISTE NO BANCO DE DADOS.
    */
    public function valida_categoria()
    {
        $query = $this->db->query("
            SELECT Nome FROM Categoria 
            WHERE UPPER(Nome) = UPPER(".$this->db->escape($this->Nome).")");
        $query = $query->row_array();

        $registro_banco = $this->get_categoria($this->Id, FALSE, FALSE, FALSE, FALSE);

        if(!empty($registro_banco) && $query['Nome'] == $registro_banco->Nome_categoria)
            return "valido";
        else if(empty($query['Nome']))
            return "valido";
        return "invalido";
    }
}