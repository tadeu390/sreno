<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 20/12/2018
 * Time: 23:23
 */

require_once("Geral_model.php");//INCLUI A CLASSE GENÉRICA.
/*!
*	ESTA MODEL TRATA DAS OPERAÇÕES NO BANCO DE DADOS REFERENTE AOS DADOS DOS CLIENTES
*/
class Cliente_model extends Geral_model
{
    public function __construct()
    {
        $this->load->database();
    }
    /*!
    *	RESPONSÁVEL POR RETORNAR OS  DE CLIENTE DE UM USUÁRIO.
    *
    *	$usuario_id -> Id de usuário do cliente.
    */
    public function get_cliente($usuario_id)
    {
        $query = $this->db->query("
				SELECT Id AS Cliente_id, Telefone, Cpf, Celular, Endereco_id, Usuario_id   
					FROM Cliente 
				WHERE Usuario_id = ".$this->db->escape($usuario_id)."");

        return $query->row_object();
    }
    /*!
    *	RESPONSÁVEL POR CADASTRAR UM CLIENTE.
    *
    *	$data -> Contém os dados de um cliente.
    */
    public function set_cliente($data)
    {
        if(empty($data['Id']))
            $this->db->insert('Cliente',$data);
        else
        {
            $this->db->where('Id', $data['Id']);
            $this->db->update('Cliente', $data);
        }
    }
}