<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 01/12/2018
 * Time: 16:49
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableGrupo extends  CI_Migration
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
                   'Ativo' => 'BOOLEAN'
               ),
               'Ativo' => array(
                   'type' => 'BOOLEAN DEFAULT TRUE',
                   'null' => FALSE
               ),
               'Nome' => array(
                   'type' => 'VARCHAR',
                   'constraint' => '20',
                   'null' => FALSE
               )
           ));
           $this->dbforge->add_key('Id', TRUE);
           $this->dbforge->create_table('Grupo');
    }
    public  function  down()
    {
        $this->dbforge->drop_table('Grupo');
    }
}