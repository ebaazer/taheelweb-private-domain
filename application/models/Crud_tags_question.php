<?php

class Crud_tags_question extends CI_Model {

    function get_data() {
        //$data = $this->db->get('society_question');

        $results = array();
        $data = array();
                
        $this->db->select("a.*");
        $this->db->from("tag a");
        $this->db->join("tag_used c", "a.id = c.tag_id", 'left');
        $this->db->where('c.post_type', 1);
        $this->db->where('a.active', 1);
        $this->db->where('a.publish', 1);
        $this->db->group_by('a.id');
        $question_tag_array = $this->db->get()->result_array();

            foreach ($question_tag_array as $query_tag_question_row) {
                array_push($results, array(
                    'url' => base_url().'home/question_by_tag/'.$query_tag_question_row["encrypt_thread"],
                ));                
            }
        
        //return $data->result();
        return $results;
    }

}
