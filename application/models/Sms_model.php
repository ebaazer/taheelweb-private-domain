<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author 	: taheelweb
 * 	date		: 01/03/2021
 * 	The system for managing institutions for people with special needs
 * 	http://taheelweb.com
 */

class Sms_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //COMMON FUNCTION FOR SENDING SMS
    function send_sms($message = '', $reciever_phone = '') {
        $active_sms_service = $this->db->get_where('settings', array('type' => 'active_sms_service'))->row()->description;
        if ($active_sms_service == '' || $active_sms_service == 'disabled')
            return;

        if ($active_sms_service == 'active') {
      
            require_once(APPPATH.'models/includeSettings.php');
            $mobile = $this->db->get_where('settings', array('type' => 'mobile'))->row()->description;
            $password = $this->db->get_where('settings', array('type' => 'password'))->row()->description;
            $sender = $this->db->get_where('settings', array('type' => 'sender'))->row()->description;

            if (is_array($reciever_phone)) {
                $comma_separated = implode(",", $reciever_phone);
                $numbers = $comma_separated;
            } else {
                $numbers = $reciever_phone;
            }

            $msg = $message;

            $MsgID = rand(1, 99999);

            $timeSend = '';

            $dateSend = '';

            $deleteKey = 152485;

            $resultType = 1;

            //echo $message;
            sendSMS($mobile, $password, $numbers, $sender, $msg, $MsgID, $timeSend, $dateSend, $deleteKey, $resultType);

            $send = 1;
            return $send;

        }
    }

    function send_sms_via_mobily($message = '', $reciever_phone = '') {
        
    }

}
