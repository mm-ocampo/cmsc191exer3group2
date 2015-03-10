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
                    if(in_array($key, preg_split( "/ [\s,.]] /", $item->coursename)))
                        $temp += 2.5;
                   /* $pos = stripos($item->coursename, $key);
                    if($pos !== false)
                        $temp += 2.5;*/
                    $item->weight += $temp;
                }
            }
            $item->weight += (($count/count($tempstr))*2) + ($occurrenceOfKeywordsInTuple/str_word_count($item->coursedesc));
            $rank[$item->coursecode] = $item->weight;
        }
        array_multisort($rank, SORT_DESC, $matched);
        /* [1] end rank all queries */
        return $matched;
    }

    public function proximity_scoring($exploded, $matchRow){
        $countMatchRow = count($matchRow);
        $explodedMatchRow = explode(' ', $matchRow);
        $currentExplodedIndex = 1;
        $score = 0.05;
        $ctr = 0;
        foreach($explodedMatchRow as $word){
            if($exploded[$currentExplodedIndex]==$word){
                switch($ctr){
                    case 0: $score+= 1;
                        break;
                    case 1: $score+=0.75;
                        break;
                    case 2: $score+=0.5;
                        break;
                    case 3: $score+=0.25;
                        break;
                    case 4: $score+=0.1;
                        break;
                    default: $score+=0;
                        break;
                }
                $currentExplodedIndex++;
                if($currentExplodedIndex>=count($exploded)){
                    break;
                }
                $ctr = 0;
            }
            else{
                $ctr++;
            }
        }
        return $score;
    }

    function cmp($a, $b) {
        return $a['score'] - $b['score'];
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
        $arr = array();
        $size = count($exploded);
        $matched = null;
        if($size == 1){
            $matched = $this->scoring_algo1();
        }
        else{
            $matched = $this->search_model->search_one($exploded[0])->result();
            $ct = count($matched);
            for($i=0;$i<$ct;$i++){
                $matched[$i]->weight = $this->proximity_scoring($exploded, $matched[$i]->coursedesc);
                $arr[$matched[$i]->coursedesc] = $matched[$i]->weight;
            }
            array_multisort($arr, SORT_DESC, $matched);
        }
        return $matched;
    }

    public function index(){
        $data['results1'] = $this->scoring_algo1();
        $data['query'] = strtolower($this->input->get('searchBox'));
        $data['results2'] = $this->scoring_algo2();
        $this->load->view('results', $data);
    }
}