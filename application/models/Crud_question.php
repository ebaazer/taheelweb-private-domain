<?php

class Crud_question extends CI_Model {

    function get_data() {
        //$data = $this->db->get('society_question');

        $results = array();
        $data = array();

        $this->db->select('*');
        $this->db->where('publish', 1);
        $this->db->where('active', 1);
        $query_society_question = $this->db->get('society_question');

        if ($query_society_question->num_rows() > 0) {
            foreach ($query_society_question->result_array() as $query_society_question_row) {
                array_push($results, array(
                    'url' => base_url() . 'home/question_details/' . $query_society_question_row["encrypt_thread"],
                ));
            }
        }


        //return $data->result();
        return $results;
    }

}
