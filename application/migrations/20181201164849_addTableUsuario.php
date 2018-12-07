<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 01/12/2018
 * Time: 16:24
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableUsuario extends CI_Migration
{
    public  function up ()
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
            ),
            'Email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'Data_nascimento' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE
            ),
            'Sexo' => array(
                'type' => 'BOOLEAN',
                'null' => FALSE
            ),
            'Grupo_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Status' => array(
                'type' => 'INT DEFAULT 1',
                'null' => FALSE
            ),
            'Codigo_ativacao' => array(
                'type' => 'INT DEFAULT 0',
                'null' => FALSE
            ),
            'Contador_tentativa' => array(
                'type' => 'INT DEFAULT 0',
                'null' => FALSE
            ),
            'Data_ultima_tentativa' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE
            ),
            'Email_notifica_nova_conta' => array(
                'type' => 'BOOLEAN DEFAULT 0',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Usuario');

        $this->dbforge->add_column('Usuario', 'CONSTRAINT FK_GRUPO_USUARIO FOREIGN KEY(Grupo_id) REFERENCES Grupo(Id)');
    }
    public  function  down()
    {
        $this->dbforge->drop_table('Usuario');
    }
}