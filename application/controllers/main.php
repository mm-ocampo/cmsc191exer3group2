<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->view('heading');
		$this->load->model('search_model');
	}


	public function index(){
		$wordList = array();
		/*[1] get total number of words */
		$totalWords = 0;
		$data['coursedesc'] = $this->search_model->retrieve_all_coursedesc()->result();
		foreach ($data['coursedesc'] as $item) {
			$totalWords += str_word_count($item->coursedesc);
			$temp = str_word_count($item->coursedesc, 1);
			/* save each word to wordlist */
			foreach ($temp as $word) {
				if(array_key_exists($word, $wordList))
					$wordList[$word] += 1;
				else
					$wordList[$word] = 1;
			}
			/* end save */
		}
		$numberOfDistinctWords = count($wordList);
		/* end [1] */
		$this->load->view('home');
	}

	public function results_page(){
		$this->load->view('results');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */