<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 11/01/2019
 * Time: 00:29
 */

/*!
*   ESTA CLASSE É RESPONSÁVEL POR CONTROLAR TUDO REFERENTE AS PEÇAS ADICIONADAS AS ORÇAMENTOS/OSs.
*/
class Linha_model extends Geral_model
{
    public $Id;
    public $Data_registro;
    public $Ativo;
    public $Preco_unitario;
    public $Quantidade;
    public $Ocos_id;
    public $Peca_id;

    public $Peca;
    public function __construct()
    {
        $this->Ativo = 1;
        $this->load->model('Peca_model');

        $this->Peca = $this->Peca_model;
    }
    /*!
    *   RESPONSÁVEL POR RETORNAR UMA LISTA DE PEÇAS DE UM DETERMINADO ORÇAMENTO/OS.
    *
    *   $id -> Id de um orçamento/os.
    *   $ativo -> Se passado como true retorna apenas registro(s) ativo(s).
    */
    public function get_linha($id, $ativo)
    {
        $Ativos = "";
        if($ativo == true)
            $Ativos = " AND l.Ativo = 1 ";

        $query = $this->db->query("SELECT l.Id AS Linha_id, l.Ativo, l.Preco_unitario, l.Quantidade, l.Ocos_id, l.Peca_id 
            FROM Linha l 
            WHERE TRUE ".$this->db->escape_str($Ativos)." AND Ocos_id = ".$this->db->escape_str($id)."");

        $this->model = $query->result_object();
        for($i = 0; $i < COUNT($this->model); $i++)
            $this->model[$i]->Peca = $this->Peca->get_peca($this->model[$i]->Peca_id, FALSE, FALSE, FALSE, FALSE);

        return $this->model;
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR/ATUALIZAR UMA LINHA DE UM ORÇAMENTO/OS.
    */
    public function set_linha()
    {
        if(empty($this->Id))
            return $this->db->insert('Linha', $this);
        else
        {
            $this->db->where('Id', $this->Id);
            return $this->db->update('Linha', $this);
        }
    }
    /*!
     *  RESPONSÁVEL POR "APAGAR" UMA LINHA DE UM DETERMINADO ORÇAMENTO/OS.
     *
     *  $id -> Id da linha a ser "apagada".
     */
    public function deletar($id)
    {
        $query = $this->db->query("UPDATE Linha SET Ativo = 0  
              WHERE Id = ".$this->db->escape($id)."");
    }
}