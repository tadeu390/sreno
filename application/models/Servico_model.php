<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 11/01/2019
 * Time: 00:21
 */

/*!
*   ESTA CLASSE É RESPONSÁVEL POR CONTROLAR TUDO REFERENTE AOS SERVIÇOS DOS ORÇAMENTOS/OSs.
*/
class Servico_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Ativo;
    public $Valor;
    public $Descricao;
    /*!
    *   RESPONSÁVEL POR RETORNAR UMA LISTA DE SERVIÇOS DE UM DETERMINADO ORÇAMENTO/OS.
    *
    *   $id -> Id de um orçamento/os.
    *   $ativo -> Se passado como true retorna apenas registro(s) ativo(s).
    */
    public function get_servico($id, $ativo)
    {
        $Ativos = "";
        if($ativo == true)
            $Ativos = " AND Ativo = 1 ";

        if($id === FALSE)
        {
            $query = $this->db->query("SELECT Id AS Anexo_id, Ativo, Legenda, Arquivo, Ocos_id     
              FROM Servico WHERE Ativo = ".$this->db->escape_str($Ativos)." ");
            return json_decode(json_encode($query->result_array()),false);
        }
        $query = $this->db->query("SELECT Id AS Servico_id, Ativo, Valor, Descricao, Ocos_id  
            FROM Anexo WHERE TRUE AND Ativo = ".$this->db->escape_str($Ativos)." AND Ocos_id = ".$this->db->escape_str($id)."");
        return json_decode(json_encode($query->row_array()),false);
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UM SERVIÇO.
    */
    public function set_servico()
    {
        if(empty($this->Id))
            return $this->db->insert('Servico', $this);
        else
        {
            $this->db->where('Id', $this->Id);
            return $this->db->update('Servico', $this);
        }
    }
}