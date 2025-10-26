<?php

//pdf_library
include_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_lib extends TCPDF {

    function __construct() {
        parent::__construct();
    }
}
