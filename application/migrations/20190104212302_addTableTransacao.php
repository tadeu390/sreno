<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/01/2019
 * Time: 21:23
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableTransacao extends CI_Migration
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
            'Quantidade' => array(
                'type' => 'INT',
                'null' => false
            ),
            'Preco_unitario' => array(
                'type' => 'DOUBLE',
                'null' => TRUE
            ),
            'Fornecedor_id' => array(
                'type' => 'INT',
                'null' => TRUE
            ),
            'Peca_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Transacao');

        $this->dbforge->add_column('Transacao', 'CONSTRAINT FK_FORNECEDOR_TRANSACAO FOREIGN KEY(Fornecedor_id) REFERENCES Fornecedor(Id)');
        $this->dbforge->add_column('Transacao', 'CONSTRAINT FK_PECA_TRANSACAO FOREIGN KEY(Peca_id) REFERENCES Peca(Id)');
    }

    public function down()
    {
        $this->dbforge->drop_table('Transacao');
    }
}