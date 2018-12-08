<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 01/12/2018
 * Time: 17:27
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Migration_addTableModulo extends CI_Migration
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
            'Nome' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            ),
            'Descricao' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'Url' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            'Icone' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            'Menu_id' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'Ordem' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        ));
        $this->dbforge->add_key('Id', TRUE);
        $this->dbforge->create_table('Modulo');

        $this->dbforge->add_column('Modulo', 'CONSTRAINT FK_MENU_MODULO FOREIGN KEY(Menu_id) REFERENCES Menu(Id)');

        $grupo = array('Nome' => 'Grupos', 'Descricao' => 'Grupos', 'Url' => 'grupo', 'Icone' => 'fa fa-group', 'Menu_id' => '1', 'Ordem' => '1');
        $this->db->insert('Modulo', $grupo);
        $modulo = array('Nome' => 'Módulos', 'Descricao' => 'Módulos', 'Url' => 'modulo', 'Icone' => 'fa fa-list-alt', 'Menu_id' => '1', 'Ordem' => '2');
        $this->db->insert('Modulo', $modulo);
        $menu = array('Nome' => 'Menus', 'Descricao' => 'Menus', 'Url' => 'menu', 'Icone' => 'fa fa-navicon', 'Menu_id' => '1', 'Ordem' => '3');
        $this->db->insert('Modulo', $menu);
        $usuario = array('Nome' => 'Usuários', 'Descricao' => 'Usuários', 'Url' => 'usuario', 'Icone' => 'glyphicon glyphicon-user', 'Menu_id' => '1', 'Ordem' => '4');
        $this->db->insert('Modulo', $usuario);
    }
    public  function  down()
    {
        $this->dbforge->drop_table('Modulo');
    }
}