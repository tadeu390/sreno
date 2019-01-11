<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 10/01/2019
 * Time: 23:47
 */

/*!
*   ESTA CLASSE É RESPONSÁVEL POR CONTROLAR TUDO REFERENTE A STATUS DA ORDEM DE SERVIÇO
*/
class Status_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Ativo;
    public $Nome;
    /*!
    *   RESPONSÁVEL POR RETORNAR UMA LISTA DE STATUS OU UM STATUS ESPECÍFICO.
    *
    *   $id -> Id de um status.
    *   $ativo -> Se passado como true retorna apenas registro(s) ativo(s).
    */
    public function get_status($id, $ativo)
    {
        $Ativos = "";
        if($ativo == true)
            $Ativos = " AND Ativo = 1 ";

        if($id === FALSE)
        {
            $query = $this->db->query("SELECT Id AS Status_id, Ativo, Nome AS Nome_status  
              FROM Status WHERE Ativo = ".$this->db->escape_str($Ativos)." ");
            return json_decode(json_encode($query->result_array()),false);
        }
        $query = $this->db->query("SELECT Id AS Status_id, Ativo, Nome AS Nome_status  
            FROM Status WHERE TRUE AND Ativo = ".$this->db->escape_str($Ativos)." AND Id = ".$this->db->escape_str($id)."");
        return json_decode(json_encode($query->row_array()),false);
    }
}