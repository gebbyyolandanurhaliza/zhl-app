
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts_receivable extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Accounts_receivable'));
        //test
    }

    public function index() {
        $this->template->display('accounting/accounts_receivable');
    }
}
