<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 09/11/2018
 * Time: 04:23
 */

class Migrate extends CI_Controller
{
    public  function index()
    {
        $this->load->library('migration');
        if($this->migration->current() === FALSE)
            show_error($this->migration->error_string());
    }
}