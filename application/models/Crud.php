<?php

class Crud extends CI_Model {

    function get_data() {
        //$data = $this->db->get('society_question');

        $results = array();
        $data = array();

        $query_society_question = $this->db->get('society_question');
        //$data['society_question'] =  $this->db->last_query();
        if ($query_society_question->num_rows() > 0) {
            foreach ($query_society_question->result_array() as $query_society_question_row) {
                array_push($results, array(
                    'url' => base_url().'home/question_details/'.$query_society_question_row["encrypt_thread"],
                ));
            }
        }
        
        $query_frontend_blog = $this->db->get('frontend_blog');
        //$data['society_question'] =  $this->db->last_query();
        if ($query_frontend_blog->num_rows() > 0) {
            foreach ($query_frontend_blog->result_array() as $query_frontend_blog_row) {
                array_push($results, array(
                    'url' => base_url().'home/blog_details/'.$query_frontend_blog_row["encrypt_thread"],
                ));
            }
        }        

        //return $data->result();
        return $results;
    }

}
