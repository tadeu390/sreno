<?php
	require_once("Geral_model.php");//INCLUI A CLASSE GENÉRICA.
	/*!
	*	ESTA MODEL TRATA DAS OPERAÇÕES NO BANCO DE DADOS REFERENTE AO ENDEREÇO DO CLIENTE OU DO FORNECEDOR.
	*/
	class Endereco_model extends Geral_model 
	{
	    public $Id;
	    public $Data_registro;
	    public $Ativo = true;
	    public $Rua;
	    public $Cidade;
	    public $Bairro;
	    public $Numero;
	    public $Complemento;

		public function __construct()
		{
			$this->load->database();
		}
		/*!
		*	RESPONSÁVEL POR RETORNAR O ENDEREÇO DO CLIENTE OU DO FORNECEDOR.
		*
		* 	$ativo-> Retorna apenas endereço ativo se passado algo diferente de false.
		*	$id -> Id de um endereço.
		*	$endereco_id -> Id do endereço do cliente.
		*/
		public function get_endereco($ativo, $endereco_id)
		{
			$a = "";
			if($ativo !== FALSE)
				$a = " AND Ativo = ".$ativo;

			$query = $this->db->query("
				SELECT Id AS Endereco_id, Rua, Bairro, Cidade, Complemento, Numero 
					FROM Endereco  
				WHERE Id = ".$this->db->escape($endereco_id)." ".$a."");

			return $query->row_array();
		}
		/*!
		*	RESPONSÁVEL POR CADASTRAR UM ENDEREÇO.
		*
		*	$data -> Contém os dados de um endereço.
		*/
		public function set_endereco()
		{
			if(empty($this->Id)) {
                $this->db->insert('Endereco', $this);
                $query = $this->db->query("SELECT Id FROM Endereco WHERE Numero = ".$this->db->escape($this->Numero)." ORDER BY Id DESC LIMIT 1");
                return $query->row_array()['Id'];
            }
			else
			{
				$this->db->where('Id', $this->Id);
				$this->db->update('Endereco', $this);
				return $this->Id;
			}
		}
	}