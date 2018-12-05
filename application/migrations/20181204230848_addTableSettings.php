<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/12/2018
 * Time: 23:09
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class  Migration_addTableSettings extends  CI_Migration
{
    public  function  up()
    {
        $this->dbforge->add_field(array(
           'Id' => array(
               'type' => 'INT',
               'null' => FALSE
           ),
            'Data_registro' => array(
                'type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'null' => FALSE
            ),
            'Itens_por_pagina' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Settings');
    }
    public  function  down()
    {
        $this->dbforge->drop_table('Settings');
    }
}