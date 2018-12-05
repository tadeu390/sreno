<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/12/2018
 * Time: 23:00
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableLog extends  CI_Migration
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
            'Ativo' => array(
                'type' => 'BOOLEAN DEFAULT TRUE',
                'null' => FALSE
            ),
            'Usuario_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Sucesso' => array(
                'type' => 'BOOLEAN'
            ),
            'Ip' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Log');
        $this->dbforge->add_column('Log','CONSTRAINT FK_USUARIO_LOG FOREIGN KEY(Usuario_id) REFERENCES Usuario(Id)');
    }
    public  function  down()
    {
        $this->dbforge->drop_table('Log');
    }
}