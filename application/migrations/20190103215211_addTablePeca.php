<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 03/01/2019
 * Time: 21:52
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTablePeca extends CI_Migration
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
                'null' => false
            ),
            'Estocado_em' => array(
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE
            ),
            'Categoria_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Peca');

        $this->dbforge->add_column('Peca', 'CONSTRAINT FK_CATEGORIA_PECA FOREIGN KEY (Categoria_id) REFERENCES Categoria(Id)');
    }

    public function down()
    {
        $this->dbforge->drop_table('Peca');
    }
}