<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 26/12/2018
 * Time: 21:43
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableFornecedor extends  CI_Migration
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
            'Nome_fantasia' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'Email' => array(
              'type' => 'VARCHAR',
              'constraint' => '100',
              'null' => TRUE
            ),
            'Cnpj' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE
            ),
            'Celular' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ),
            'Telefone' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE
            ),
            'Razao_social' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'Endereco_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Fornecedor');

        $this->dbforge->add_column('Fornecedor', 'CONSTRAINT FK_ENDERECO_FORNECEDOR FOREIGN KEY(Endereco_id) REFERENCES Endereco(Id)');
    }
    public function down()
    {
        $this->dbforge->drop_table('Fornecedor');
    }
}