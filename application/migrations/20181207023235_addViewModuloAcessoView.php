<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 07/12/2018
 * Time: 02:34
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_addViewModuloAcessoView extends  CI_Migration
{
    public function up()
    {
        $this->db->query("CREATE OR REPLACE VIEW Modulo_acesso_view AS 
                            SELECT m.Ativo, mo.Nome AS Nome_modulo, mo.Id AS Modulo_id, mo.Menu_id AS Menu_id, 
                            mo.Url AS Url_modulo, mo.Icone, m.Nome AS Nome_menu, a.Usuario_id AS Usuario_id, 
                            m.Ordem AS Ordem_menu, mo.Ordem AS Ordem_modulo 
                            FROM Modulo mo 
                            INNER JOIN Acesso a on mo.Id = a.Modulo_id 
                            LEFT JOIN Menu m on mo.Menu_id = m.Id 
                            WHERE mo.Ativo = 1 and a.Ler = 1 ORDER BY mo.Ordem;");
    }
    public  function  down()
    {
        $this->db->query("DROP VIEW Modulo_acesso_view");
    }
}