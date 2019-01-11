<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 10/01/2019
 * Time: 23:19
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableAnexo extends CI_Migration
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
            'Legenda' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => FALSE
            ),
            'Arquivo' => array(
                'type' => 'VARCHAR',
                'constraint' => '1000',
                'null' => FALSE
            ),
            'Ocos_id' => array(
                'type' => 'int',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Anexo');

        $this->dbforge->add_column('Anexo', 'CONSTRAINT FK_OCOS_ANEXO FOREIGN KEY(Ocos_id) REFERENCES Ocos(Id)');
    }

    public function down()
    {
        $this->dbforge->drop_table('Anexo');
    }
}