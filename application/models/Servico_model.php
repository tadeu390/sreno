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
    public $Ocos_id;

    public function __construct()
    {
        $this->Ativo = 1;
    }
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

        $query = $this->db->query("SELECT Id AS Servico_id, Ativo, Valor, Descricao, Ocos_id  
            FROM Servico 
            WHERE TRUE ".$this->db->escape_str($Ativos)." AND Ocos_id = ".$this->db->escape_str($id)."");

        return $query->result_object();
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
    /*!
     *  RESPONSÁVEL POR "APAGAR" UM SERVIÇO DE UM DETERMINADO ORÇAMENTO/OS.
     *
     *  $id -> Id do serviço a ser "apagado".
     */
    public function deletar($id)
    {
        $query = $this->db->query("UPDATE Servico SET Ativo = 0  
              WHERE Id = ".$this->db->escape($id)."");
    }
}