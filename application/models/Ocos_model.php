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
    public $Linha;
    public $Servico;

    public function __construct()
    {
        $this->Ativo = 1;
        $this->load->model('Status_model');
        $this->load->model('Usuario_model');
        $this->load->model('Linha_model');
        $this->load->model('Servico_model');

        $this->Status = $this->Status_model;
        $this->Responsavel = $this->Usuario_model;
        $this->Criador = $this->Usuario_model;
        $this->Cliente = $this->Usuario_model;
        $this->Linha = $this->Linha_model;
        $this->Servico = $this->Servico_model;

        $this->model = new stdClass();
        $this->model->Linhas = Array();
        $this->model->Status = new stdClass();
        $this->model->Criador = new stdClass();
        $this->model->Responsavel = new stdClass();
        $this->model->Cliente = new stdClass();
        $this->model->Servicos = Array();
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
                Status_id, Usuario_criador_id, Usuario_responsavel_id, Cliente_id, Observacao 
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
                Status_id, Usuario_criador_id, Usuario_responsavel_id, Cliente_id, Observacao     
                FROM Ocos 
                WHERE TRUE ".$Ativos." AND Id = ".$this->db->escape($id)."");

        if(!empty($query->row_object()))
        {
            $this->model = $query->row_object();
            $this->model->Linhas = $this->Linha->get_linha($this->model->Ocos_id, TRUE);
            $this->model->Servicos = $this->Servico->get_servico($this->model->Ocos_id, TRUE);
            $this->model->Status = $this->Status->get_status($this->model->Status_id, FALSE);
            $this->model->Criador = $this->Criador->get_usuario(FALSE, $this->model->Usuario_criador_id, FALSE, FALSE, FALSE, FALSE);
            $this->model->Responsavel = $this->Responsavel->get_usuario(FALSE, $this->model->Usuario_responsavel_id, FALSE, FALSE, FALSE, FALSE);
            $this->model->Cliente = $this->Cliente->get_usuario(FALSE, $this->model->Cliente_id, FALSE, FALSE, FALSE, FALSE);
        }
        return $this->model;
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
    /*!
     *  RESPONSÁVEL POR ALTERAR O STATUS DE UM ORÇAMENTO NO BANCO DE DADOS PARA ORDEM DE SERVIÇO.
     *
     *  $id -> id do orçamento.
     */
    public function gerar_os($id)
    {
        $query = $this->db->query("UPDATE Ocos SET Tipo = 2 
          WHERE Id = ".$this->db->escape($id)."");
    }
    /*!
     *  RESPONSÁVEL POR "APAGAR" ORÇAMENTO/OS
     *
     *  $id -> id do orçamento/os.
     */
    public function deletar($id)
    {
        $query = $this->db->query("UPDATE Ocos SET Ativo = 0 
          WHERE Id = ".$this->db->escape($id)."");
    }
}