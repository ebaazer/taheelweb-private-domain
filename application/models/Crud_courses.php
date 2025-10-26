<?php

class Crud_courses extends CI_Model {

    function get_data() {
        //$data = $this->db->get('society_question');

        $results = array();
        $data = array();
                
        $this->db->select('*');
        $this->db->where('publish_site', 1);
        $this->db->where('active', 1);
        $query_frontend_courses = $this->db->get('courses_taheelweb');

        if ($query_frontend_courses->num_rows() > 0) {
            foreach ($query_frontend_courses->result_array() as $query_frontend_courses_row) {
                array_push($results, array(
                    'url' => base_url().'home/courses_taheelweb_detail/'.$query_frontend_courses_row["encrypt_thread"],
                ));
            }
        }        

        //return $data->result();
        return $results;
    }

}
