
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_TrackingContainer extends MY_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    public function index() {

        $this->template->display('shipping/track_container/index');

    }


}
