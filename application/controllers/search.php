<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->view('heading');
    }

    public function index(){
        $keyword = $this->input->get('searchBox');
    }
}