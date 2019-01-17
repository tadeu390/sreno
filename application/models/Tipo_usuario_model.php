<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 11/12/2018
 * Time: 00:27
 */

	require_once("Geral_model.php");//INCLUI A CLASSE GENÉRICA.
	/*!
	*	ESTA MODEL TRATA DAS OPERAÇÕES NO BANCO DE DADOS REFERENTE AOS TIPOS DE USUÁRIOS EXISTENTES NO SISTEMA.
	*/
	class Tipo_usuario_model extends Geral_model
    {
        public function __construct()
        {
            $this->load->database();
        }
        /*!
        *	RESPONSÁVEL POR TRAZR UMA LISTA QUE CONTÉM TODOS OS TIPOS DE USUÁRIOS CADASTRADOS NO SISTEMA.
        *
        *	$id -> Id do tipo de usuário que se quer buscar.
        */
        public function get_tipo_usuario($id = FALSE, $ativo)
        {
            $Ativos = "";
            if($ativo == true)
                $Ativos = " AND Ativo = 1 ";

            if($id === FALSE)
            {
                $query = $this->db->query("
                  SELECT * FROM Tipo_usuario WHERE TRUE  ".$Ativos." ");
                return $query->result_object();
            }
            $query = $this->db->query("
              SELECT * FROM Tipo_usuario WHERE TRUE ".$Ativos." AND Id = ".$this->db->escape($id)."");
            return $query->row_object();
        }
    }