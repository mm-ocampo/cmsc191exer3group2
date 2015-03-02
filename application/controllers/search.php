<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->view('heading');
        $this->load->model('search_model');
    }

    public function index(){
        $keyword = $this->input->get('searchBox');
        $data['results1'] = $this->search_model->search_one($keyword)->result();
        /*foreach($query->result() as $row){
            echo $row->coursecode;
            echo "<br />";
        }
        */
        $this->load->view('results', $data);
    }
}