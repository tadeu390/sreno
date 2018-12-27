<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 20/12/2018
 * Time: 22:31
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableCliente extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_fieLd(array(
            'Id' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
                'null' => FALSE
            ),
            'Telefone' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => FALSE
            ),
            'Celular' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => FALSE
            ),
            'Cpf' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE
            ),
            'Endereco_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Usuario_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Cliente');

        $this->dbforge->add_column('Cliente', 'CONSTRAINT FK_ENDERECO_CLIENTE FOREIGN KEY(Endereco_id) REFERENCES Endereco(Id)');
        $this->dbforge->add_column('Cliente', 'CONSTRAINT FK_USUARIO_CLIENTE FOREIGN KEY(Usuario_id) REFERENCES Usuario(Id)');
    }

    public function down()
    {
        $this->dbforge->drop_table('Cliente');
    }
}