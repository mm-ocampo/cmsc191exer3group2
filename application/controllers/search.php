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

    public function preprocess_data(){

    }

    public function index(){
        $wordList = array();
        $weightList = array();
        /* [1] get total number of words */
        $totalWords = 0;
        // get all course description from all the tuples
        $query = $this->search_model->retrieve_all_coursedesc()->result();
        foreach ($query as $item) {
            // count words per tuple 
            $totalWords += str_word_count($item->coursedesc);
            // get all words in the tuple
            $temp = str_word_count($item->coursedesc, 1);
            /* [2] save each word to wordlist */
            foreach ($temp as $word) {
                // update the list of words and its occurrence
                if(array_key_exists($word, $wordList))
                    $wordList[$word] += 1;
                else
                    $wordList[$word] = 1;
            }
            /* [2] end save */
            /* [3] get weight per word */
            foreach ($wordList as $word => $value) {
                // compute for the weight of each word
                $weightList[$word] = 1 - ($value/$totalWords); 
            }
            /* [3] end get */
        }
        /* end [1] */
        $keyword = strtolower($this->input->get('searchBox'));
        // get all keywords
        $tempstr = explode(' ', $keyword);
        $data['results1'] = $this->search_model->search_one($keyword)->result();
        /* [4] rank all queries */
        $rank = array();
        foreach ($data['results1'] as $item) {
            $item->weight = 0;
            $temp = 0;
            $count = 0;
            foreach ($tempstr as $key) {
                if(array_key_exists($key, $wordList)){
                    $count++;
                    $temp += substr_count(strtolower($item->coursedesc), $key) * $weightList[$key];
                    $pos = stripos($item->coursename, $key);
                    if($pos !== false)
                        $temp += 2.5;
                    $item->weight += $temp;
                }
            }
            $item->weight += $count/count($tempstr);
            $rank[$item->coursecode] = $item->weight;
        }
        array_multisort($rank, SORT_DESC, $data['results1']);
        /* [4] end rank all queries */
        $this->load->view('results', $data);
    }
}