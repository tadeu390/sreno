<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 10/01/2019
 * Time: 23:41
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class  Migration_addValoresStatus extends  CI_Migration
{
    public  function  up()
    {
        $status = array('Nome' => 'Não definido');
        $this->db->insert('Status', $status);
        $status = array('Nome' => 'Em execução');
        $this->db->insert('Status', $status);
        $status = array('Nome' => 'Aguardando peças');
        $this->db->insert('Status', $status);
        $status = array('Nome' => 'Aguardando retorno do cliente');
        $this->db->insert('Status', $status);
        $status = array('Nome' => 'Finalizado');
        $this->db->insert('Status', $status);
    }

    public  function  down()
    {
        $this->db->query('DELETE * FROM Status');
    }
}