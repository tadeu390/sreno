<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/12/2018
 * Time: 23:14
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableSettingsEmail extends CI_Migration
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
            'Email' => array(
                'type' => 'VARCHAR',
                'constraint' => 70,
                'null' => FALSE
            ),
            'Descricao' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => FALSE
            ),
            'Usuario' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => TRUE
            ),
            'Senha' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => TRUE
            ),
            'Protocolo' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => FALSE
            ),
            'Host' => array(
                'type' => 'VARCHAR',
                'constraint' => 70,
                'null' => FALSE
            ),
            'Porta' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Settings_email');
    }
    public  function  down()
    {
        $this->dbforge->drop_table('Settings_email');
    }
}