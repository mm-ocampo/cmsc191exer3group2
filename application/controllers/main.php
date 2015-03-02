<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->view('heading');
		$this->load->model('search_model');
	}


	public function index(){
		/*[1] get total number of words */
		$totalWords = 0;
		$data['coursedesc'] = $this->search_model->retrieve_all_coursedesc()->result();
		foreach ($data['coursedesc'] as $item) {
			$totalWords += str_word_count($item->coursedesc);
		}
		/* end [1] */
		$this->load->view('home');
	}

	public function results_page(){
		$this->load->view('results');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */