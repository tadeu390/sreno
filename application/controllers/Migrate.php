<?php
/**
 * Created by PhpStorm.
 * User: tadeu
 * Date: 09/11/2018
 * Time: 04:23
 */

class Migrate extends CI_Controller
{
    function __construct()
    {
        // this is your constructor
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('migration');
    }


    public  function index()
    {

        if($this->migration->current() === FALSE)
            show_error($this->migration->error_string());
        else
            redirect("/account/login");
    }
}