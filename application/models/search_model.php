<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function search_one($keyword){
        $query = $this->db->query("select coursecode, coursedesc from course where match(coursedesc) against('".$keyword."' in natural language mode)");
        return $query;
    }

    public function search_two(){

    }
}