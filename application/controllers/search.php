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
        $wordList = array();
        $weightList = array();
        /*[1] get total number of words */
        $totalWords = 0;
        $query = $this->search_model->retrieve_all_coursedesc()->result();
        foreach ($query as $item) {
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
            /* get weight per word */
            foreach ($wordList as $word => $value) {
                $weightList[$word] = 1 - ($value/$totalWords); 
            }
            /* end get */
        }
        /*echo var_dump($weightList);*/
        /*echo $totalWords . "<br/>";*/
        $numberOfDistinctWords = count($wordList);
        /* end [1] */
        $keyword = $this->input->get('searchBox');
        $data['results1'] = $this->search_model->search_one($keyword)->result();
        /*foreach($query->result() as $row){
            echo $row->coursecode;
            echo "<br />";
        }*/
        foreach ($data['results1'] as $item) {
            $temp = substr_count($item->coursedesc, $keyword) * $weightList[$keyword];
/*            $pos = stripos($item->coursename, needle);
            if($pos !== false)
                $temp += 2.5;*/
            $item['weight'] = $temp;
        }        
        echo var_dump($data['results1']);
        $this->load->view('results', $data);
    }
}