<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 10/01/2019
 * Time: 23:00
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableStatus extends CI_Migration
{
    public function up()
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
                'constraint' => '100',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Status');
    }

    public function down()
    {
        $this->dbforge->drop_table('Status');
    }
}