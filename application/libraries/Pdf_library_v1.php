<?php

//pdf_library
//include_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
require_once APPPATH . 'libraries/tcpdf/tcpdf.php'; // تعديل المسار حسب مكان المكتبة

class Pdf_library extends TCPDF {

    function __construct() {
        parent::__construct();
    }
}
