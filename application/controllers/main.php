<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->view('heading');
		$this->load->model('search_model');
	}


	public function index(){
		$this->load->view('home');
	}

	public function results_page(){
		$this->load->view('results');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */