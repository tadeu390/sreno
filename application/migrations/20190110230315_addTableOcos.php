<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 10/01/2019
 * Time: 23:04
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableOcos extends CI_Migration
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
            'Nome_produto' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'Descricao' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'Tipo_servico' => array(//FABRICAÇÃO DE PRODUTO OU MANUTENÇÃO DE PRODUTO
                'type' => 'int',
                'null' => FALSE
            ),
            'Tempo' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Data_inicio' => array(
                'type' => 'TIMESTAMP',
                'null' => FALSE
            ),
            'Tipo' => array( //ORÇAMENTO OU ORDEM DE SERVIÇO
                'type' => 'INT',
                'null' => FALSE
            ),
            'Status_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Usuario_criador_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Usuario_responsavel_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Cliente_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Ocos');

        $this->dbforge->add_column('Ocos', 'CONSTRAINT FK_STATUS_OCOS FOREIGN KEY(Status_id) REFERENCES Status(Id)');
        $this->dbforge->add_column('Ocos', 'CONSTRAINT FK_USUARIO_CRIADOR_OCOS FOREIGN KEY(Usuario_criador_id) REFERENCES Usuario(Id)');
        $this->dbforge->add_column('Ocos', 'CONSTRAINT FK_USUARIO_RESPONSAVEL_OCOS FOREIGN KEY(Usuario_responsavel_id) REFERENCES Usuario(Id)');
        $this->dbforge->add_column('Ocos', 'CONSTRAINT FK_CLIENTE_OCOS FOREIGN KEY(Cliente_id) REFERENCES Usuario(Id)');
    }

    public function down()
    {
        $this->dbforge->drop_table('Ocos');
    }
}