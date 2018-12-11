<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 10/12/2018
 * Time: 23:49
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableTipoUsuario extends  CI_Migration
{
    public function  up()
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
            'Ativo' => array(
                'type' => 'BOOLEAN DEFAULT TRUE',
                'null' => FALSE
            ),
            'Nome' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Tipo_usuario');

        $tipo_usuario = array('Nome' => 'Administrador');
        $this->db->insert('Tipo_usuario', $tipo_usuario);
        $tipo_usuario = array('Nome' => 'Cliente');
        $this->db->insert('Tipo_usuario', $tipo_usuario);
    }
    public function down()
    {
        $this->dbforge->drop_table('Tipo_usuario');
    }
}