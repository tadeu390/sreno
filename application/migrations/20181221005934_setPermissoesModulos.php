<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 21/12/2018
 * Time: 01:00
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_setPermissoesModulos extends  CI_Migration
{
    public function up()
    {
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '5');
        $this->db->insert('Acesso', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '6');
        $this->db->insert('Acesso', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '7');
        $this->db->insert('Acesso', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '8');
        $this->db->insert('Acesso', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '9');
        $this->db->insert('Acesso', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '10');
        $this->db->insert('Acesso', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '11');
        $this->db->insert('Acesso', $acesso);


        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Modulo_id' => '5', 'Grupo_id' => '1');
        $this->db->insert('Acesso_padrao', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Modulo_id' => '6', 'Grupo_id' => '1');
        $this->db->insert('Acesso_padrao', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Modulo_id' => '7', 'Grupo_id' => '1');
        $this->db->insert('Acesso_padrao', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Modulo_id' => '8', 'Grupo_id' => '1');
        $this->db->insert('Acesso_padrao', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Modulo_id' => '9', 'Grupo_id' => '1');
        $this->db->insert('Acesso_padrao', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Modulo_id' => '10', 'Grupo_id' => '1');
        $this->db->insert('Acesso_padrao', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Modulo_id' => '11', 'Grupo_id' => '1');
        $this->db->insert('Acesso_padrao', $acesso);
    }
    public function down()
    {
        $this->db->query("DELETE FROM  Acesso WHERE Id IN (5, 6, 7, 8, 9, 10, 11)");
        $this->db->query("DELETE FROM  Acesso_padrao WHERE Id IN (5, 6, 7, 8, 9, 10, 11)");
    }
}