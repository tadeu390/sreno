<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/12/2018
 * Time: 22:38
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableAcesso extends CI_Migration
{
    public  function  up()
    {
        $this->dbforge->add_field(array(
            'Id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
                'null' => FALSE
            ),
            'Data_registro' => array(
                'type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'null' => FALSE
            ),
            'Criar' => array(
                'type' => 'BOOLEAN'
            ),
            'Ler' => array(
                'type' => 'BOOLEAN'
            ),
            'Atualizar' => array(
                'type' => 'BOOLEAN'
            ),
            'Remover' => array(
                'type' => 'BOOLEAN'
            ),
            'Usuario_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Modulo_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Acesso');

        $this->dbforge->add_column('Acesso','CONSTRAINT FK_USUARIO_ACESSO FOREIGN KEY(Usuario_id) REFERENCES Usuario(Id) ON DELETE CASCADE');
        $this->dbforge->add_column('Acesso','CONSTRAINT FK_MODULO_ACESSO FOREIGN KEY(Modulo_id) REFERENCES Modulo(Id)');

        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '1');
        $this->db->insert('Acesso', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '2');
        $this->db->insert('Acesso', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '3');
        $this->db->insert('Acesso', $acesso);
        $acesso = array('Criar' => '1', 'Ler' => '1', 'Atualizar' => '1', 'Remover' => '1', 'Usuario_id' => '1', 'Modulo_id' => '4');
        $this->db->insert('Acesso', $acesso);
    }
    public  function  down()
    {
        $this->dbforge->drop_table("Acesso");
    }
}