<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/12/2018
 * Time: 22:51
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableAcessoPadrao extends CI_Migration
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
            'Grupo_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Modulo_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('AcessoPadrao');

        $this->dbforge->add_column('AcessoPadrao','CONSTRAINT FK_GRUPO_ACESSO_PADRAO FOREIGN KEY(Grupo_id) REFERENCES Grupo(Id)');
        $this->dbforge->add_column('AcessoPadrao','CONSTRAINT FK_MODULO_ACESSO_PADRAO FOREIGN KEY(Modulo_id) REFERENCES Modulo(Id)');
    }
    public  function  down()
    {
        $this->dbforge->drop_table("AcessoPadrao");
    }
}