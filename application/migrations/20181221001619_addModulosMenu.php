<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 21/12/2018
 * Time: 00:16
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addModulosMenu extends  CI_Migration
{
    public function up()
    {
        $fornecedor = array('Nome' => 'Fornecedores', 'Descricao' => 'Fornecedores', 'Url' => 'fornecedor', 'Icone' => 'fa fa-shopping-cart', 'Menu_id' => '1', 'Ordem' => '5');
        $this->db->insert('Modulo', $fornecedor);
        $categoria = array('Nome' => 'Categorias', 'Descricao' => 'Categorias', 'Url' => 'categoria', 'Icone' => 'fa fa-folder-open', 'Menu_id' => '1', 'Ordem' => '6');
        $this->db->insert('Modulo', $categoria);
        $peca = array('Nome' => 'Peças', 'Descricao' => 'Peças', 'Url' => 'peca', 'Icone' => 'fa fa-puzzle-piece', 'Menu_id' => '1', 'Ordem' => '7');
        $this->db->insert('Modulo', $peca);
        $transacao = array('Nome' => 'Transações', 'Descricao' => 'Transações', 'Url' => 'transacao', 'Icone' => 'fa fa-retweet', 'Menu_id' => '1', 'Ordem' => '8');
        $this->db->insert('Modulo', $transacao);
        $estoque = array('Nome' => 'Estoque', 'Descricao' => 'Estoque', 'Url' => 'estoque', 'Icone' => 'fa fa-archive', 'Menu_id' => '1', 'Ordem' => '9');
        $this->db->insert('Modulo', $estoque);
        $orcamento = array('Nome' => 'Orçamentos', 'Descricao' => 'Orçamentos', 'Url' => 'ocos/orcamento', 'Icone' => 'fa fa-calculator', 'Menu_id' => '1', 'Ordem' => '10');
        $this->db->insert('Modulo', $orcamento);
        $os = array('Nome' => 'Ordem de serviço', 'Descricao' => 'Ordem de serviço', 'Url' => 'ocos/os', 'Icone' => 'fa fa-tasks', 'Menu_id' => '1', 'Ordem' => '11');
        $this->db->insert('Modulo', $os);
    }

    public function down()
    {
        $this->db->query("DELETE FROM Modulo WHERE Nome = 'Fornecedores'");
        $this->db->query("DELETE FROM Modulo WHERE Nome = 'Categorias'");
        $this->db->query("DELETE FROM Modulo WHERE Nome = 'Peças'");
        $this->db->query("DELETE FROM Modulo WHERE Nome = 'Transações'");
        $this->db->query("DELETE FROM Modulo WHERE Nome = 'Estoque'");
        $this->db->query("DELETE FROM Modulo WHERE Nome = 'Orçamentos'");
        $this->db->query("DELETE FROM Modulo WHERE Nome = 'Ordem de serviço'");
    }
}