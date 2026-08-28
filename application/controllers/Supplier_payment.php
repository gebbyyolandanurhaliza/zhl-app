
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class supplier_payment extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Accounts_receivable'));
    }

    public function index() {
        $this->template->display('accounting/supplier_payment');
    }


}
