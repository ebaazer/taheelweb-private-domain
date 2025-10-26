<?php

class Crud_blog extends CI_Model {

    function get_data() {
        //$data = $this->db->get('society_question');

        $results = array();
        $data = array();
                
        $this->db->select('*');
        $this->db->where('published', 1);
        $this->db->where('active', 1);
        $query_frontend_blog = $this->db->get('frontend_blog');

        if ($query_frontend_blog->num_rows() > 0) {
            foreach ($query_frontend_blog->result_array() as $query_frontend_blog_row) {
                array_push($results, array(
                    'url' => base_url().'home/blog_detail/'.$query_frontend_blog_row["encrypt_thread"],
                ));
            }
        }        

        //return $data->result();
        return $results;
    }

}
