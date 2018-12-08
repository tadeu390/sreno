<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 04/12/2018
 * Time: 22:53
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addTableSenha extends CI_Migration
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
            'Ativo' => array(
                'type' => 'BOOLEAN DEFAULT TRUE',
                'null' => FALSE
            ),
            'Valor' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            'Usuario_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));

        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Senha');
        $this->dbforge->add_column('Senha','CONSTRAINT FK_USUARIO_SENHA FOREIGN KEY(Usuario_id) REFERENCES Usuario(Id)');

        $senha = array('Ativo' => '0', 'Valor' => '$2y$10$zpV3q4vyx89BPFui4RU9WuUsVqBo7bJLauBAbga.jm.uHdcdnz74S', 'Usuario_id' => '1');
        $this->db->insert('Senha', $senha);
        $senha = array('Ativo' => '1', 'Valor' => '$2y$10$zpV3q4vyx89BPFui4RU9WuUsVqBo7bJLauBAbga.jm.uHdcdnz74S', 'Usuario_id' => '1');
        $this->db->insert('Senha', $senha);
    }
    public  function  down()
    {
        $this->dbforge->drop_table('Senha');
    }
}