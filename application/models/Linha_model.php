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
            $Ativos = " AND Ativo = 1 ";

        if($id === FALSE)//FAZER DIFERENTE, BUSCAR TOAS AS LINHAS DE ORÇAMENTO E CARREGAR O NOME DA PEÇA PELO get_peca do Pecao_model usando um while
        {
            $query = $this->db->query("SELECT l.Id AS Linha_id, l.Ativo, l.Preco_unitario, l.Quantidade, l.Ocos_id, l.Peca_id 
              FROM Linha l WHERE l.Ativo = ".$this->db->escape_str($Ativos)." ");
            return json_decode(json_encode($query->result_array()),false);
        }
        $query = $this->db->query("SELECT l.Id AS Linha_id, l.Ativo, l.Preco_unitario, l.Quantidade, l.Ocos_id, l.Peca_id    
            FROM Linha l WHERE TRUE AND l.Ativo = ".$this->db->escape_str($Ativos)." AND Ocos_id = ".$this->db->escape_str($id)."");
        return json_decode(json_encode($query->row_array()),false);
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
}