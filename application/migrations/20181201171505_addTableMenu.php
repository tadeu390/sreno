<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 01/12/2018
 * Time: 17:16
 */

defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_addTableMenu extends CI_Migration
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
            'Nome' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            ),
            'Ordem' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Menu');
    }
    public  function  down()
    {
        $this->dbforge->drop_table('Menu');
    }
}