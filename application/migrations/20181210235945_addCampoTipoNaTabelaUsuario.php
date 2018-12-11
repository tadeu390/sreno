<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 11/12/2018
 * Time: 00:00
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addCampoTipoNaTabelaUsuario extends CI_Migration
{
    public function up()
    {
        $campo = array(
            'Tipo_usuario_id' => array(
                'type' => 'INT',
                'null' => FALSE
            )
        );
        $this->dbforge->add_column('Usuario', $campo);
        $this->db->query('UPDATE Usuario SET Tipo_usuario_id = 1 WHERE Id = 1');
        $this->dbforge->add_column('Usuario', 'CONSTRAINT FK_TIPO_USUARIO_USUARIO FOREIGN KEY(Tipo_usuario_id) REFERENCES Tipo_usuario(Id)');
    }
    public function down()
    {
        $this->dbforge->drop_column('Usuario', 'Tipo_usuario_id');
    }
}