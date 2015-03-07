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
        return $weightList;
    }

    public function compute_scores($matched,$weightList, $tempstr){
        /* [1] rank all queries */
        $rank = array();
        foreach ($matched as $item) {
            $item->weight = 0;
            $temp = 0;
            $count = 0;
            $occurrenceOfKeywordsInTuple = 0;
            foreach ($tempstr as $key) {
                if(array_key_exists($key, $weightList)){
                    $count++;
                    $occurrenceOfKeywordsInTuple += substr_count(strtolower($item->coursedesc), $key);
                    $temp +=  substr_count(strtolower($item->coursedesc), $key) * $weightList[$key];
                    $pos = stripos($item->coursename, $key);
                    if($pos !== false)
                        $temp += 2.5;
                    $item->weight += $temp;
                }
            }
            $item->weight += $count/count($tempstr) + ($occurrenceOfKeywordsInTuple/str_word_count($item->coursedesc));
            $rank[$item->coursecode] = $item->weight;
        }
        array_multisort($rank, SORT_DESC, $matched);
        /* [1] end rank all queries */
        return $matched;
    }

    public function proximity_scoring($exploded, $matchRow){
        $countMatchRow = count($matchRow);
        $explodedMatchRow = explode(' ', $matchRow);
        $currentExplodedIndex = 0;
        $score = 0.0;
        $ctr = 0;
        foreach($explodedMatchRow as $word){

            $ctr++;
        }
        return 1;
    }

    public function scoring_algo1(){
        $weightList= $this->preprocess_data();
        $keyword = strtolower($this->input->get('searchBox'));
        // get all keywords
        $tempstr = explode(' ', $keyword);
        $matched = $this->search_model->search_one($keyword)->result();
        $matched = $this->compute_scores($matched, $weightList, $tempstr);
        return $matched;
    }

    public function scoring_algo2(){
        $keyword = strtolower($this->input->get('searchBox'));
        $exploded = explode(' ', $keyword);
        $size = count($exploded);
        $matched = $this->search_model->search_two($exploded[0])->result();
        foreach($matched as $row){
            $row['score'] = proximity_scoring($exploded, $row['coursedesc']);;
        }
    }

    public function index(){
        $data['results1'] = $this->scoring_algo1();
        $data['results2'] = $this->scoring_algo2();
        $this->load->view('results', $data);
    }
}