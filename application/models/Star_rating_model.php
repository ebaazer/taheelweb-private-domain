<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 09/03/2023
 * 	The system for managing institutions for people with special needs
 * 	http://taheelweb.com
 */

class Star_rating_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_rate_info_data() {
        $this->db->where('id', '1');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('rate_info');
    }

    function get_rate_info_rating($rate_info_id) {
        $this->db->select('AVG(rating) as rating');
        $this->db->from('rating');
        $this->db->where('rate_info_id', $rate_info_id);
        $data = $this->db->get();
        foreach ($data->result_array() as $row) {
            return $row["rating"];
        }
    }

    function html_output() {
        $data = $this->get_rate_info_data();
        $output = '';
        foreach ($data->result_array() as $row) {
            $color = '';
            $rating = $this->get_rate_info_rating($row["id"]);
            $output .= '
   <h3 class="text-primary" style="padding-bottom: 0px; margin-bottom: 0px;">' . $row["rate_name"] . '</h3>
   <ul class="list-inline" style="text-align: center; display: inline-flex;" data-rating="' . $rating2 . '" title="Average Rating - ' . $rating2 . '">
   ';
            for ($count = 1; $count <= 5; $count++) {
                if ($count <= $rating) {
                    //$color = 'color:#ffcc00;';
                } else {
                    //$color = 'color:#ccc;';
                }
                $color = '#ffcc00;';
                $output .= '<li title="' . $count . '" id="' . $row['id'] . '-' . $count . '" data-index="' . $count . '" data-rate_info_id="' . $row["id"] . '" data-rating="' . $rating . '" class="rating" style="cursor:pointer; ' . $color . ' font-size:70px;">&#9733;</li>';
            }
            $output .= '</ul>
   <hr />
   ';
        }
        echo $output;
    }

    function insert_rating($data) {
        $this->db->insert('rating', $data);
    }

}
