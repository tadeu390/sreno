<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 10/01/2019
 * Time: 23:32
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableLinha extends CI_Migration
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
            'Preco_unitario' => array(
                'type' => 'DOUBLE',
                'null' => FALSE
            ),
            'Quantidade' => array(
                'type' => 'DOUBLE',
                'null' => FALSE
            ),
            'Peca_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Ocos_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Linha');

        $this->dbforge->add_column('Linha', 'CONSTRAINT FK_PECA_LINHA FOREIGN KEY(Peca_id) REFERENCES Peca(Id)');
        $this->dbforge->add_column('Linha', 'CONSTRAINT FK_OCOS_LINHA FOREIGN KEY(Ocos_id) REFERENCES Ocos(Id)');
    }

    public function down()
    {
        $this->dbforge->drop_table('Linha');
    }
}