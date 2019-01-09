<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 26/12/2018
 * Time: 21:57
 */
/*!
 *      ESTA CLASSE É RESPONSÁVEL PELA CONSULTA, INSERÇÃO E VALIDAÇÃO DOS DADOS DE FORNECEDORES.
 */
require_once("Geral_model.php");//INCLUI A CLASSE GENÉRICA.

class Fornecedor_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Ativo;
    public $Nome_fantasia;
    public $Email;
    public $Cnpj;
    public $Celular;
    public $Telefone;
    public $Razao_social;
    public $Endereco_id;
    /*!
     *  RESPONSÁVEL POR RETORNAR UMA LISTA DE FORNECEDORES OU UM FORNECEDOR ESPECÍFICO. RETORNA PAGINADO E ORDENADO CASO SEJAM OS ARGUMENTOS NECESSÁRIOS.
     *
     * $id -> Id de um fornecedor.
     * $ativo -> Fornecedor ativo ou não.
     * $page -> Página a ser buscada na lista da consulta.
     * $filter -> Contém os parâmetros de filtros.
     * $ordenacao -> Contém a regra de ordenação.
     */
    public function get_fornecedor($id, $ativo, $page, $filter, $ordenacao)
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
                SELECT (SELECT count(*) FROM  Fornecedor u WHERE TRUE ) AS Size, Id AS Fornecedor_id,  
                Ativo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro,
                Nome_fantasia, Email, Cnpj, Celular, Telefone, Razao_social, Endereco_id  
                FROM Fornecedor 
                WHERE TRUE ".$Ativos."
			    ".str_replace("'", "", $this->db->escape($order))." ".$pagination."");

            return json_decode(json_encode($query->result_array()),false);
        }

        $query = $this->db->query("
                SELECT Id AS Fornecedor_id, Ativo, DATE_FORMAT(Data_registro, '%d/%m/%Y') as Data_registro,
                Nome_fantasia, Email, Cnpj, Celular, Telefone, Razao_social, Endereco_id  
                FROM Fornecedor 
                WHERE TRUE ".$Ativos." AND Id = ".$this->db->escape($id)."");

        return json_decode(json_encode($query->row_array()),false);
    }
    /*!
     *  RESPONSÁVEL POR CADASTRAR UM FORNECEDOR NO BANCO DE DADOS.
     */
    public function set_fornecedor()
    {
        if(empty($this->Id))
            $this->db->insert('Fornecedor', $this);
        else{
            $this->db->where('Id', $this->Id);
            $this->db->update('Fornecedor', $this);
        }
    }
    /*!
     *  RESPONSÁVEL POR VALIDAR OS DADOS SUBMETIDOS DE UM FORNECEDOR.
     */
    public function valida_fornecedor()
    {
        $query = $this->db->query("
				SELECT Nome_fantasia FROM Fornecedor  
				WHERE UPPER(Nome_fantasia) = UPPER(".$this->db->escape($this->Nome_fantasia).")");
        $query = $query->row_array();

        $registro_banco = $this->get_fornecedor($this->Id, FALSE, FALSE, FALSE, FALSE);

        if(!empty($registro_banco) && $query['Nome_fantasia'] == $registro_banco->Nome_fantasia)
            return "valido";
        else if(empty($query['Nome_fantasia']))
            return "valido";
        return "invalido";
    }
    /*!
    *	RESPONSÁVEL POR "APAGAR" UM FORNECEDOR DO BANCO DE DADOS.
    *
    *	$id -> Id do fornecedor a ser "apagado".
    */
    public function deletar($id)
    {
        return $this->db->query("
            UPDATE Fornecedor SET Ativo = 0 
            WHERE Id = ".$this->db->escape($id)."");
    }
}