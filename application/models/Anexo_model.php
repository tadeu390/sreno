<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 11/01/2019
 * Time: 00:12
 */

/*!
*   ESTA CLASSE É RESPONSÁVEL POR CONTROLAR TUDO REFERENTE AOS ANEXOS DOS ORÇAMENTOS/OSs
*/
class Anexo_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Ativo;
    public $Legenda;
    public $Arquivo;
    /*!
    *   RESPONSÁVEL POR RETORNAR UMA LISTA DE ANEXOS DE UM DETERMINADO ORÇAMENTO/OS.
    *
    *   $id -> Id de um orçamento/os.
    *   $ativo -> Se passado como true retorna apenas registro(s) ativo(s).
    */
    public function get_anexo($id, $ativo)
    {
        $Ativos = "";
        if($ativo == true)
            $Ativos = " AND Ativo = 1 ";

        if($id === FALSE)
        {
            $query = $this->db->query("SELECT Id AS Anexo_id, Ativo, Legenda, Arquivo, Ocos_id     
              FROM Anexo WHERE Ativo = ".$this->db->escape_str($Ativos)." ");
            return json_decode(json_encode($query->result_array()),false);
        }
        $query = $this->db->query("SELECT Id AS Anexo_id, Ativo, Legenda, Arquivo, Ocos_id  
            FROM Anexo WHERE TRUE AND Ativo = ".$this->db->escape_str($Ativos)." AND Ocos_id = ".$this->db->escape_str($id)."");
        return json_decode(json_encode($query->row_array()),false);
    }
 /*!
 *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UM ANEXO.
 */
    public function set_anexo()
    {
        if(empty($this->Id))
            return $this->db->insert('Anexo', $this);
        else
        {
            $this->db->where('Id', $this->Id);
            return $this->db->update('Anexo', $this);
        }
    }
}