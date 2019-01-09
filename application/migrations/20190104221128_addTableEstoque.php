<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/01/2019
 * Time: 22:12
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableEstoque extends CI_Migration
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
            'Saldo' => array(
                'type' => 'DOUBLE',
                'null' => FALSE
            ),
            'Preco_medio_unitario' => array(
                'type' => 'DOUBLE',
                'null' => FALSE
            ),
            'Peca_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Estoque');

        $this->dbforge->add_column('Estoque', 'CONSTRAINT FK_PECA_ESTOQUE FOREIGN KEY(Peca_id) REFERENCES Peca(Id)');
    }

    public function down()
    {
        $this->dbforge->drop_table('Estoque');
    }
}